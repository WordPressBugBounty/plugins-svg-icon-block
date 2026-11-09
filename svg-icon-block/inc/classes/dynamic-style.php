<?php
/**
 * Svgib Blocks - Generate Dynamic Styles
 *
 * @since 1.0.0
 * @package SvgibBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Svgib_Block_Dynamic_Style' ) ) {

    /**
     * Svgib Blocks Dynamic Style Class
     *
     * @since 1.0.0
     * @package SvgibBlock
     */
    class Svgib_Block_Dynamic_Style {

        private $dynamic_styles = '';

        /**
         * Constructor
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            $this->init();
        }

        /**
         * Initialize the Class
         *
         * @since 1.0.0
         * @return void
         */
        private function init() {
            add_filter( 'render_block', array( $this, 'generate_dynamic_styles' ), 10, 2 );

            // Enqueue Dynamic Styles
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_dynamic_styles' ) );
        }

        /**
         * Generate Dynamic Styles
         *
         * @since 1.0.0
         * @param string $block_content Block Content.
         * @param array  $block Block Attributes.
         * @return string
         */
        public function generate_dynamic_styles( $block_content, $block ) {
            if ( isset( $block['blockName'] ) && strpos( $block['blockName'], 'svgib/' ) !== false ) {
                if ( isset( $block['attrs']['blockStyle'] ) ) {
                    $style = sanitize_text_field( $block['attrs']['blockStyle'] );
                    $this->enqueue_dynamic_styles( $style );
                }
            }
            return $block_content;
        }

        /**
         * Enqueue Dynamic Styles
         *
         * @since 1.0.0
         * @param string $style Custom CSS to be enqueued.
         * @return void
         */
        public function enqueue_dynamic_styles( $style ) {
            if ( ! empty( $style ) ) {
                $handle = 'svg-icon-block-inline-style-' . wp_rand( 100, 10000 );
                wp_register_style( $handle, false, array(), SVGIB_VERSION, 'all' );
                wp_enqueue_style( $handle, false, array(), SVGIB_VERSION, 'all');
                wp_add_inline_style( $handle, $this->sanitize_css( $style ) );
            }
        }

        /**
         * Sanitize CSS method
         *
         * @since 1.0.0
         * @param string $css CSS to Sanitize.
         * @return string
         */
        private function sanitize_css( $css ) {
            // Validate UTF-8 encoding
            $css = wp_check_invalid_utf8( $css );

            if ( empty( $css ) ) {
                return '';
            }

            // Normalize whitespace to prevent obfuscation tricks
            $css = preg_replace( '/\s+/', ' ', $css );

            // Remove CSS comments (can hide payloads: /* expression */background:url() */)
            $css = preg_replace( '!/\*.*?\*/!s', '', $css );

            // Remove backslash escapes used to bypass keyword filters (e.g. \65 xpression)
            $css = preg_replace( '/\\\\[0-9a-fA-F]{0,6}\s?/', '', $css );

            // Background images come through as url(). Keep plain http(s) or
            // root-relative ones and neutralise anything else, rather than
            // throwing away every style on the block.
            $css = preg_replace_callback(
                '/url\s*\(\s*([\'"]?)([^\'")]*)\1\s*\)/i',
                array( $this, 'sanitize_css_url' ),
                $css
            );

            // Block dangerous CSS functions and protocols
            // Covers: expression(), stray url(), javascript:, vbscript:, data:, behavior
            if ( preg_match(
                '/expression\s*\(
                | url\s*\((?!"(?:https?:\/\/|\/)[^"]*"\))
                | javascript\s*:
                | vbscript\s*:
                | data\s*:
                | @import
                | behavior\s*:
                | -moz-binding\s*:
                | content\s*:/ix',
                $css
            ) ) {
                return '';
            }

            // Block HTML tags that could escape the <style> context
            if ( preg_match( '/<\s*\/?\s*(script|style|link|meta|object|embed|iframe)/i', $css ) ) {
                return '';
            }

            // Trim and return
            return trim( $css );
        }

        /**
         * Rebuild a single url() with a safe, quoted URL, or drop it.
         *
         * @since 1.2.0
         * @param array $matches Regex matches; index 2 is the raw URL.
         * @return string
         */
        private function sanitize_css_url( $matches ) {
            $url = trim( $matches[2] );

            $is_root_relative = 0 === strpos( $url, '/' ) && 0 !== strpos( $url, '//' );
            $is_http          = (bool) preg_match( '#^https?://#i', $url );

            if ( ! $is_root_relative && ! $is_http ) {
                return 'none';
            }

            $clean = esc_url_raw( $url, array( 'http', 'https' ) );
            if ( '' === $clean && ! $is_root_relative ) {
                return 'none';
            }

            // Quotes and parentheses would let the value break out of url().
            $clean = str_replace( array( '"', "'", '(', ')', '\\' ), array( '%22', '%27', '%28', '%29', '' ), $is_root_relative ? $url : $clean );

            return 'url("' . $clean . '")';
        }
    }

    new Svgib_Block_Dynamic_Style(); // Initialize the Dynamic Style class.
}