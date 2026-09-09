=== TBMX Mega Menu ===
Contributors: tubomax
Tags: mega menu, divi, navigation, menu, divi builder
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 8.0
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Converts native WordPress menus into professional mega menus with Divi aesthetic. Panel content uses Divi Library layouts.

== Description ==

**TBMX Mega Menu** transforms your standard WordPress navigation menus into rich, professional mega menus — designed with the same Divi Builder you already know and love.

= Key Features =

* **Use Divi Library layouts as panel content** — Design your mega menu panels with the Divi Builder, save as a Library layout, and assign it to any menu item.
* **Native WordPress menus** — Works with Appearance > Menus. No proprietary menu system.
* **Accessible by design** — Full WAI-ARIA support: keyboard navigation, screen reader announcements, focus management.
* **Responsive** — Desktop hover-intent panels collapse into mobile accordions automatically.
* **Performance optimized** — Conditional asset loading (zero overhead when not in use), vanilla JS < 5 KB.
* **Theme-agnostic** — Works with Divi theme and any theme using Divi Builder.

= How it works =

1. Design your mega menu panel with the Divi Builder and save it as a Library layout.
2. Go to Appearance > Menus and enable the mega panel on any menu item.
3. Select the Divi Library layout you want to use as panel content.
4. Done! Your mega menu is live on the front-end.

= Requirements =

* WordPress 5.8 or higher
* PHP 8.0 or higher
* Divi theme or Divi Builder plugin

== Installation ==

1. Upload the `tbmx-megamenu` folder to the `/wp-content/plugins/` directory, or install through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Appearance > Menus to configure your mega menu items.
4. (Optional) Go to Appearance > TBMX Mega Menu to customize global settings.

== Frequently Asked Questions ==

= Do I need Divi to use this plugin? =

You need either the Divi theme or the Divi Builder plugin to design panel content using Divi Library layouts. However, the plugin includes a fallback "columns" mode that works without Divi.

= Will it slow down my site? =

No. Assets are only loaded on pages where the active menu has mega menu items. The JavaScript is vanilla and under 5 KB.

= Is it accessible? =

Yes. The plugin follows the WAI-ARIA disclosure/menu pattern with full keyboard navigation, screen reader support, and visible focus indicators.

= Can I customize the colors? =

Yes. Global settings allow you to customize all colors, typography, spacing, and animation timing. Three presets are included: Dark, Light, and Minimal.

== Screenshots ==

1. Mega menu panel on desktop (hover state)
2. Menu item metabox in Appearance > Menus
3. Global settings page with color customization
4. Mobile accordion view

== Changelog ==

= 0.1.0 =
* Initial release
* Metabox for menu items (enable mega panel, select Divi layout)
* Custom Nav_Menu Walker with ARIA attributes
* Conditional asset loading
* Global settings page with color tokens
* Responsive mobile accordion
* Keyboard navigation and accessibility
* Three style presets: Dark, Light, Minimal

== Upgrade Notice ==

= 0.1.0 =
Initial release.
