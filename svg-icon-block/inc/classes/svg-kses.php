<?php
/**
 * SVG in Post Content
 *
 * Users without the `unfiltered_html` capability (Authors, Contributors, and
 * everyone but super admins on Multisite) have their post content run through
 * kses, which strips <svg> entirely. That empties the SVG Icon block on save.
 *
 * This adds a conservative SVG allow-list to the `post` kses context. Anything
 * able to run script or rewrite links is left out on purpose: <a>, <style>,
 * <script>, <foreignObject>, the SMIL elements (<animate>, <set>, ...) and all
 * event handler attributes.
 *
 * @since 1.2.0
 * @package SvgibBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Svgib_SVG_Kses' ) ) {

	/**
	 * Svgib SVG Kses Class
	 *
	 * @since 1.2.0
	 * @package SvgibBlock
	 */
	class Svgib_SVG_Kses {

		/**
		 * Constructor
		 *
		 * @since 1.2.0
		 * @return void
		 */
		public function __construct() {
			add_filter( 'wp_kses_allowed_html', array( $this, 'allow_svg' ), 10, 2 );
			add_filter( 'wp_kses_uri_attributes', array( $this, 'uri_attributes' ) );
		}

		/**
		 * Add the SVG allow-list to the post context.
		 *
		 * @since 1.2.0
		 * @param array        $allowed Allowed tags and attributes.
		 * @param string|array $context kses context.
		 * @return array
		 */
		public function allow_svg( $allowed, $context ) {
			if ( 'post' !== $context ) {
				return $allowed;
			}

			$attributes = array_fill_keys( self::attributes(), true );

			foreach ( self::elements() as $element ) {
				$existing            = isset( $allowed[ $element ] ) && is_array( $allowed[ $element ] ) ? $allowed[ $element ] : array();
				$allowed[ $element ] = array_merge( $existing, $attributes );
			}

			return $allowed;
		}

		/**
		 * Run `xlink:href` through the same protocol check as `href`.
		 *
		 * @since 1.2.0
		 * @param string[] $attributes Attributes treated as URLs.
		 * @return string[]
		 */
		public function uri_attributes( $attributes ) {
			$attributes[] = 'xlink:href';
			return array_unique( $attributes );
		}

		/**
		 * Elements allowed in post content. Lowercase, as kses compares them.
		 *
		 * @since 1.2.0
		 * @return string[]
		 */
		private static function elements() {
			$elements = array(
				'svg', 'g', 'defs', 'symbol', 'use', 'title', 'desc', 'metadata',
				'path', 'circle', 'ellipse', 'line', 'polygon', 'polyline', 'rect',
				'text', 'tspan', 'textpath',
				'lineargradient', 'radialgradient', 'stop', 'pattern',
				'clippath', 'mask', 'marker', 'filter',
				'feblend', 'fecolormatrix', 'fecomponenttransfer', 'fecomposite',
				'feflood', 'fefunca', 'fefuncb', 'fefuncg', 'fefuncr',
				'fegaussianblur', 'femerge', 'femergenode', 'femorphology',
				'feoffset', 'fedropshadow', 'feturbulence',
			);

			/**
			 * Filters the SVG elements allowed in post content.
			 *
			 * @since 1.2.0
			 * @param string[] $elements Lowercase element names.
			 */
			return array_map( 'strtolower', (array) apply_filters( 'svgib_kses_svg_elements', $elements ) );
		}

		/**
		 * Attributes allowed on every SVG element. Lowercase, as kses compares them.
		 *
		 * @since 1.2.0
		 * @return string[]
		 */
		private static function attributes() {
			$attributes = array(
				// Document and accessibility.
				'xmlns', 'xmlns:xlink', 'version', 'viewbox', 'preserveaspectratio',
				'id', 'class', 'style', 'role', 'focusable', 'aria-hidden', 'aria-label', 'aria-labelledby',
				'width', 'height', 'x', 'y', 'href', 'xlink:href',
				// Geometry.
				'd', 'points', 'cx', 'cy', 'r', 'rx', 'ry', 'x1', 'y1', 'x2', 'y2', 'fx', 'fy', 'pathlength',
				'transform', 'transform-origin',
				// Painting.
				'fill', 'fill-opacity', 'fill-rule', 'clip-rule', 'clip-path', 'mask', 'filter',
				'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin', 'stroke-miterlimit',
				'stroke-dasharray', 'stroke-dashoffset', 'stroke-opacity',
				'opacity', 'color', 'display', 'visibility', 'overflow', 'vector-effect',
				'shape-rendering', 'paint-order', 'mix-blend-mode', 'isolation',
				// Gradients, patterns, clipping and markers.
				'offset', 'stop-color', 'stop-opacity', 'gradientunits', 'gradienttransform', 'spreadmethod',
				'patternunits', 'patterncontentunits', 'patterntransform',
				'clippathunits', 'maskunits', 'maskcontentunits',
				'marker-start', 'marker-mid', 'marker-end', 'markerwidth', 'markerheight',
				'markerunits', 'refx', 'refy', 'orient',
				// Text.
				'font-family', 'font-size', 'font-weight', 'font-style', 'text-anchor',
				'dominant-baseline', 'alignment-baseline', 'letter-spacing', 'dx', 'dy', 'startoffset',
				// Filters.
				'filterunits', 'primitiveunits', 'in', 'in2', 'result', 'stddeviation', 'mode',
				'operator', 'k1', 'k2', 'k3', 'k4', 'values', 'type', 'tablevalues', 'slope',
				'intercept', 'amplitude', 'exponent', 'radius', 'basefrequency', 'numoctaves',
				'seed', 'stitchtiles', 'flood-color', 'flood-opacity', 'lighting-color',
				'color-interpolation-filters',
			);

			/**
			 * Filters the attributes allowed on SVG elements in post content.
			 *
			 * @since 1.2.0
			 * @param string[] $attributes Lowercase attribute names.
			 */
			return array_map( 'strtolower', (array) apply_filters( 'svgib_kses_svg_attributes', $attributes ) );
		}
	}

	new Svgib_SVG_Kses();
}
