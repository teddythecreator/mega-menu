=== TCB MegaMenu ===
Contributors: thecreatorbusiness
Tags: mega menu, divi, navigation, menu, responsive, accessible
Requires at least: 5.8
Tested up to: 6.5
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Professional mega menus for WordPress with seamless Divi integration. Create stunning, accessible mega menus using Divi Library layouts or custom columns.

== Description ==

**TCB MegaMenu** transforms your standard WordPress navigation menus into professional, accessible mega menus — designed with the Divi Builder you already know and love.

= Key Features =

* **Divi Library Integration** — Design your mega menu panels with the Divi Builder, save as Library layouts, and assign them to any menu item.
* **Custom Columns Mode** — Works without Divi! Automatically organizes child menu items into responsive columns.
* **Fully Accessible** — WCAG 2.1 AA compliant with full keyboard navigation and screen reader support.
* **Responsive Design** — Desktop hover panels automatically convert to mobile accordions.
* **Performance Optimized** — Conditional asset loading (zero overhead when not in use), vanilla JavaScript < 5 KB.
* **Customizable** — 3 style presets (Dark, Light, Minimal) plus full color/typography customization.
* **No Dependencies** — Pure vanilla JavaScript, no jQuery required on the front-end.

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

1. Upload the `tcb-megamenu` folder to `/wp-content/plugins/` or install through WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen.
3. Go to **TCB MegaMenu → Settings** to configure global settings.
4. Go to **Appearance → Menus** to enable mega panels on menu items.

= Quick Start =

1. Configure settings (choose a preset or customize colors)
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

Yes! Global settings allow you to customize all colors, typography, spacing, and animation timing. Three presets are included: Dark, Light, and Minimal.

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

== Screenshots ==

1. Mega menu panel on desktop (hover state)
2. Menu item metabox in Appearance → Menus
3. Global settings page with color customization
4. Mobile accordion view
5. Divi Library layout integration

== Changelog ==

= 1.0.0 =
* Initial release
* Divi Library layout integration
* Custom columns mode (no Divi required)
* 3 style presets (Dark, Light, Minimal)
* Full WCAG 2.1 AA accessibility
* Responsive mobile accordion
* Keyboard navigation
* Conditional asset loading
* Performance optimized (< 5 KB JS)

== Upgrade Notice ==

= 1.0.0 =
Initial release of TCB MegaMenu.

== Support ==

For support, documentation, and updates, visit [thecreator.business](https://thecreator.business/).
