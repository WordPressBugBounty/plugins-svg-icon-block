=== SVG Icon Block ===
Contributors: gkits, binsaifullah
Tags: svg icon, icon block, font awesome, svg upload, gutenberg
Requires at least: 6.0
Tested up to: 7.1
Stable tag: 1.2.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add SVG icons to the WordPress block editor: 1,800+ Font Awesome icons, custom SVG code, safe SVG uploads and a reusable icon library.

== Description ==

**SVG Icon Block** is a lightweight Gutenberg block for adding SVG icons anywhere in the WordPress block editor. Pick from more than 1,800 Font Awesome icons, paste your own SVG code, or upload an SVG file. Then style the icon with size, color, background, border, rotation and flip controls.

Icons are output as inline SVG markup, not an icon font. Your pages don't load an extra font file or stylesheet, icons stay sharp on every screen, and the Font Awesome data loads in the editor only when you open the icon library.

### Video Tutorial
[youtube http://www.youtube.com/watch?v=K7iUgJU42GI]

### Three ways to add an icon

* **Icon Library** – search 1,800+ Font Awesome Free icons (Solid, Regular and Brands) and insert one with a click.
* **Custom SVG** – paste SVG code from Figma, Illustrator, Inkscape or any icon set. The markup is validated and previewed on light, dark and transparent backgrounds.
* **Upload SVG** – upload an `.svg` file to the Media Library, or drop it straight into the editor. SVG uploads are enabled safely, with every file sanitized.

### Features

* 1,800+ Font Awesome SVG icons (Solid, Regular and Brands)
* Custom SVG code with live preview and markup validation
* Safe SVG upload support for the Media Library
* **My Icons** – save your own SVG icons once and reuse them in any post or page
* Icon size, fill, stroke and hover colors, background, padding, border and border radius
* Responsive size, spacing and alignment for desktop, tablet and mobile
* Rotate and flip icons horizontally or vertically
* Optional text label next to the icon, with typography controls
* Link an icon to any URL, with new tab, nofollow and sponsored options
* Accessible: alternative text for icons, plus a warning when an icon-only link has no accessible name
* Additional CSS class and HTML anchor support
* Works with block themes, classic themes and Full Site Editing
* Lightweight with no third-party dependencies, and only the SVG markup is rendered

### My Icons: a reusable SVG icon library

Paste your SVG code in the Custom SVG window, turn on **Add to My Icons**, give it a label, and the icon is saved to your site. A **My Icons** button then appears in the block placeholder, so you can insert that icon in any post or page without pasting the code again.

The library is shared by everyone on the site who can edit posts. A logo or brand icon saved by one author is available to the whole team. You can search and remove saved icons from the same window.

### Secure SVG support

SVG files can contain scripts, so WordPress blocks SVG uploads by default. SVG Icon Block enables them safely: every uploaded file, pasted SVG code and saved icon goes through an allow-list sanitizer that removes scripts, event handlers, unsafe links and external references before anything is stored.

### Use cases

* Feature lists and service boxes with icons
* Social media icons and brand logos
* Icon buttons and call-to-action links
* Contact details with phone, email and map icons
* Custom illustrations and logos as scalable SVG

== Installation ==

1. In your WordPress dashboard, go to **Plugins → Add New** and search for "SVG Icon Block".
2. Click **Install Now**, then **Activate**.
3. Open the block editor, click the **+** inserter and add the **SVG Icon** block.
4. Choose an icon from the Icon Library, paste custom SVG code, or upload an SVG file.

To install manually, upload the `svg-icon-block` folder to `/wp-content/plugins/` and activate it from the **Plugins** screen.

== Frequently Asked Questions ==

= How do I add an SVG icon in the WordPress block editor? =

Add the **SVG Icon** block from the inserter, then pick an icon from the Icon Library, paste SVG code with **Custom SVG**, or upload an `.svg` file. Use the block sidebar to change size, color and other styles.

= Does this plugin load Font Awesome on the front end? =

No. Each icon is saved as inline SVG markup, so no icon font, CSS file or JavaScript from Font Awesome is loaded on your site's front end.

= Can I upload my own SVG icons? =

Yes. You can upload `.svg` files to the Media Library, drop them into the editor, or paste SVG code directly. Turn on **Add to My Icons** to save an icon for reuse.

= Is it safe to allow SVG uploads? =

The plugin sanitizes every SVG with an allow-list before it is saved. Scripts, event handlers, unsafe links and external references are removed, so a malicious file can't run code on your site.

= Can Authors and Contributors use the block? =

Yes. Icons display correctly for users without the `unfiltered_html` capability, including on Multisite networks.

= Can I link an icon? =

Yes. Add a URL in the block settings and choose whether it opens in a new tab or uses nofollow or sponsored. For icon-only links, add alternative text so screen readers can announce the link.

= Can I change the icon color on hover? =

Yes. The block has separate normal and hover colors for the icon fill, stroke, label and background.

= Does it work with Full Site Editing and block themes? =

Yes. You can use the SVG Icon block in posts, pages, templates, template parts and patterns.

== Screenshots ==

1. Font Awesome icon library with search inside the SVG Icon block.

== Changelog ==
= 1.2.1 =
* Improved: New plugin icon and banner
* Improved: Rewrote the plugin description, features list and FAQ
* Tested up to WordPress 7.1
= 1.2.0 =
* Fixed: Icons no longer vanish when saved by Authors, Contributors, or on Multisite (users without unfiltered HTML)
* Fixed: Adding a background image no longer drops every other style of the block on the front end
* Fixed: SVG code typed in the sidebar is now sanitized, and invalid markup no longer replaces the icon
* Added: Alternative text for icons, with a warning for icon-only links that have no accessible name
* Added: Additional CSS class and HTML anchor settings
* Added: Popular icons in the block placeholder for one-click insert
* Improved: Redesigned icon library, Custom SVG window, My Icons window and block placeholder
* Improved: Removing a saved icon from My Icons now asks for confirmation, since the library is shared site-wide
* Improved: Custom SVG window validates markup, previews on light, dark and transparent backgrounds, and accepts dropped .svg files
* Improved: Font Awesome data loads only when needed, making the editor script about 88% smaller

= 1.1.0 =
* Added: My Icons library - save a custom SVG with "Add to My Icons" and reuse it in any block
* Added: My Icons button in the block placeholder to pick a saved icon, with search and remove
* Fixed: SVG upload no longer failed on icons exported from Illustrator, Inkscape and similar tools
* Fixed: An SVG that could not be parsed is now rejected with a clear message instead of being saved empty
* Fixed: SVG uploads sent through the REST API (drag and drop into the editor) are accepted
* Fixed: PHP notices while preparing SVG attachments, which could break the upload response
* Fixed: Link is no longer clickable inside the editor, so an accidental click does not navigate away
* Improved: SVG sanitizer rewritten to an allow-list, stripping scripts, event handlers, unsafe links and external references
* Improved: SVG width, height and previews now display correctly in the media library

= 1.0.6 =
* Compatibility check

= 1.0.5 = 
* Transform features (rotate, flip) are added 
* Dynamic CSS codes are optimized 

= 1.0.4 =
* Compatibility with WordPress 6.8

= 1.0.3 =
* Added: Edit SVG Icon option at sidebar
* Improved: Search functionality for icons
* Optimized: Codes are optimized

= 1.0.2 =
* Added: Direct SVG upload option
* Added: SVG format support for direct upload

= 1.0.1 =
* Compatibility with WordPress 6.7.1

= 1.0.0 =
* Initial Release

