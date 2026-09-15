=== TCB MegaMenu ===
Contributors: thecreatorbusiness
Tags: mega menu, divi, navigation, menu, responsive, accessible
Requires at least: 5.8
Tested up to: 6.5
Requires PHP: 8.0
Stable tag: 1.3.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Professional mega menus for WordPress with native Divi integration. Create stunning mega menus using Divi Library layouts or custom columns.

== Description ==

**TCB MegaMenu** transforms your standard WordPress navigation menus into professional, accessible mega menus with native Divi integration. The content of each panel can be a **Divi Library layout** or **custom columns** without needing Divi.

= Key Features =

* **Automatic Divi Integration** — Works without additional code
* **4 Mobile Menu Styles** — Accordion, Drawer, Overlay, Slide
* **5 Hamburger Icons** — Classic, Arrow, Dots, Plus, X
* **Configurable Panel Width** — Full, Container, Custom
* **Customizable Colors** — Background, Text, Accent
* **WCAG 2.1 AA Accessibility** — Complete keyboard navigation
* **Optimized Performance** — Conditional assets, vanilla JS < 5 KB
* **No External Code** — Works automatically when activated

= How It Works =

1. **With Divi:** Design your mega menu panel using the Divi Builder, save it as a Library layout, and assign it to a menu item.
2. **Without Divi:** Add child menu items to a parent item, enable the mega panel, and select "Custom Columns" mode.

= Requirements =

* WordPress 5.8 or higher
* PHP 8.0 or higher
* Divi theme or Divi Builder plugin (optional, for Divi layouts)

= Perfect For =

* Agencies and freelancers using Divi
* E-commerce sites with complex navigation
* Corporate websites with extensive menu structures
* Anyone needing professional mega menus without coding

== Installation ==

1. Upload the `tcb-megamenu` folder to `/wp-content/plugins/` or install through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen.
3. Go to **TCB MegaMenu → Settings** to configure global settings.
4. Go to **Appearance → Menus** to enable mega panels on menu items.

= Quick Start =

1. Configure settings (choose colors or use presets)
2. Create/edit a menu and assign it to a theme location
3. Enable "Mega Panel" on parent menu items
4. Choose content source (Divi Library or Custom Columns)
5. Save and view on front-end!

== Frequently Asked Questions ==

= Do I need Divi to use this plugin? =

No! The plugin works perfectly without Divi using "Custom Columns" mode. However, to use Divi Library layouts as panel content, you need either the Divi theme or Divi Builder plugin.

= Will it slow down my site? =

No. Assets are only loaded on pages where the active menu has mega menu items. The JavaScript is vanilla and under 5 KB. No jQuery dependency on the front-end.

= Is it accessible? =

Yes! The plugin follows WAI-ARIA disclosure/menu patterns with full keyboard navigation, screen reader support, and visible focus indicators. It meets WCAG 2.1 Level AA standards.

= Can I customize the colors? =

Yes! Global settings allow you to customize all colors, typography, spacing, and animation timing. You can also customize the hamburger icon style, color, size, and thickness.

= How do I create a Divi layout for the mega menu? =

1. Go to Divi → Divi Library
2. Click "Add New Layout"
3. Design your panel with Divi Builder (use sections, rows, columns, modules)
4. Save the layout
5. In Appearance → Menus, enable Mega Panel and select your layout

= Can I have multiple mega menus? =

Yes! You can enable mega panels on as many parent menu items as you want. Each can have its own layout or configuration.

= Does it work with my theme? =

TCB MegaMenu works with any WordPress theme that uses `wp_nav_menu()`. It's been tested with Divi, Astra, GeneratePress, OceanWP, and Twenty Twenty-Four.

= Do I need to add code to functions.php? =

No! The plugin works automatically when activated. No external code or snippets are needed.

== Screenshots ==

1. Mega menu panel on desktop (hover state)
2. Menu item metabox in Appearance → Menus
3. Global settings page with color customization
4. Mobile accordion view
5. Mobile drawer view
6. Mobile overlay view
7. Hamburger icon customization

== Changelog ==

= 1.3.6 =
* CRITICAL: Integrated walker natively - panels now render INSIDE each menu item
* CRITICAL: Forced walker with priority 999 for Divi compatibility
* CRITICAL: Forced assets loading with priority 999
* 100% autonomous - NO external code needed in functions.php
* Full Divi compatibility without snippets
* Works automatically with any theme

= 1.3.5 =
* Fixed settings form to properly save all configurations
* Integrated walker automatically - no external code needed
* Improved Divi compatibility
* Clean mobile menu without duplicate icons
* All settings now save correctly

= 1.3.4 =
* Added mobile-fix.css for clean mobile menus
* Removed duplicate hamburger icons in mobile
* Improved mobile dropdown structure
* Better mobile responsive design

= 1.3.3 =
* Data preservation when deactivating plugin
* Added Data Management section in settings
* Improved settings interface
* Added advanced settings options

= 1.3.2 =
* Fixed mobile menu rendering
* Panels now render inside menu items
* Better Divi compatibility
* Improved HTML structure

= 1.3.1 =
* Added Divi Builder compatibility
* Automatic detection of page builders
* Plugin doesn't interfere with Divi Builder

= 1.3.0 =
* 4 mobile menu styles (Accordion, Drawer, Overlay, Slide)
* 5 customizable hamburger icons
* Complete icon customization (color, size, thickness)
* Configurable drawer position and width

= 1.0.0 =
* Initial release
* Divi Library layout integration
* Custom columns mode (no Divi needed)
* 3 style presets (Dark, Light, Minimal)
* Full WCAG 2.1 AA accessibility
* Responsive mobile accordion
* Keyboard navigation
* Conditional asset loading
* Performance optimized (< 5 KB JS)

== Upgrade Notice ==

= 1.3.5 =
Critical update: Fixed settings saving and integrated walker automatically. No external code needed anymore. Update recommended for all users.

== Support ==

For support, documentation, and updates, visit [thecreator.business](https://thecreator.business/).

Email: soporte@thecreator.business
