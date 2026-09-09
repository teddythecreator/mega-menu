# 🚀 TCB MegaMenu - Installation & Setup Guide

> **By [The Creator Business](https://thecreator.business/)**
> Version 1.0.0

---

## 📋 Table of Contents

1. [Installation](#installation)
2. [Quick Start (5 minutes)](#quick-start)
3. [Using with Divi](#using-with-divi)
4. [Using Without Divi](#using-without-divi)
5. [Configuration Guide](#configuration)
6. [Troubleshooting](#troubleshooting)
7. [FAQ](#faq)

---

## Installation

### Method 1: WordPress Admin (Recommended)

1. Download the `tcb-megamenu.zip` file
2. Go to **Plugins → Add New → Upload Plugin**
3. Select the zip file and click **Install Now**
4. Click **Activate Plugin**

### Method 2: FTP Upload

1. Download and extract `tcb-megamenu.zip`
2. Upload the `tcb-megamenu` folder to `/wp-content/plugins/`
3. Go to **Plugins** in WordPress admin
4. Activate **TCB MegaMenu**

### Verify Installation

After activation, you should see:
- ✅ **TCB MegaMenu** in the main admin menu (left sidebar)
- ✅ New fields in menu items (Appearance → Menus)

---

## Quick Start

### Step 1: Configure Global Settings (2 min)

1. Click **TCB MegaMenu** in the admin menu
2. Go to **Settings**
3. Choose a preset:
   - **Dark** — Dark background, white text, red accent
   - **Light** — Light background, dark text, red accent
   - **Minimal** — Gray background, black text, square corners
4. Click **Save Changes**

### Step 2: Create Your Menu (3 min)

1. Go to **Appearance → Menus**
2. Create a new menu or edit existing
3. Add menu items (pages, categories, custom links)
4. **Important:** Assign the menu to a theme location
5. Click **Save Menu**

### Step 3: Enable Mega Menu (2 min)

1. Find the parent menu item you want to convert
2. Click the **▼ arrow** to expand it
3. Scroll down to **TCB MegaMenu** section
4. Check **"Enable Mega Panel"**
5. Choose **Content Source**:
   - **Divi Library Layout** (if using Divi)
   - **Custom Columns** (without Divi)
6. Configure width, alignment, optional badge
7. Click **Save Menu**

### Step 4: View on Front-End (30 sec)

1. Open your website
2. Hover over the menu item
3. **The mega menu should appear!** 🎉

---

## Using with Divi

### Create a Divi Layout for Mega Menu

1. Go to **Divi → Divi Library**
2. Click **Add New Layout**
3. Name it descriptively (e.g., "Mega Menu - Services")
4. Design your layout with Divi Builder:
   - Use **Sections** and **Rows** for structure
   - Add **Modules**: Text, Blurb, Button, Image, etc.
   - Use **Columns** to organize content
5. Save the layout

### Design Tips

**Recommended structure:**
```
Section (Full Width)
├── Row (4 columns)
│   ├── Column 1/4: Title + description
│   ├── Column 1/4: Links list
│   ├── Column 1/4: Links list
│   └── Column 1/4: CTA button
```

**Best practices:**
- Use percentage widths (not fixed pixels)
- Keep layouts simple and clean
- Test on mobile (accordion mode)
- Use Divi's built-in modules

### Assign Layout to Menu

1. Go to **Appearance → Menus**
2. Enable **Mega Panel** on parent item
3. Select **Divi Library Layout** as Content Source
4. Choose your layout from dropdown
5. Save menu

---

## Using Without Divi

### Create Menu with Sub-Items

1. Go to **Appearance → Menus**
2. Add parent menu item (e.g., "Services")
3. Add child items:
   - Drag items slightly to the right under parent
   - Or select parent from dropdown when adding
4. Enable **Mega Panel** on parent
5. Select **Custom Columns (no Divi)** as Content Source
6. Save menu

### How Columns Work

Sub-items automatically organize into columns:

- **1-5 items** → 1 column
- **6-10 items** → 2 columns
- **11-15 items** → 3 columns
- **16+ items** → 4 columns (max)

### Example

```
Services (Mega Panel enabled)
├── Web Design
├── Development
├── SEO
├── Marketing
└── Consulting
```

This creates a 2-column layout with 5 links.

---

## Configuration

### Global Settings

Go to **TCB MegaMenu → Settings**

#### Colors
- **Background Color** — Panel background
- **Text Color** — Main text
- **Muted Text** — Secondary text
- **Accent Color** — Links hover, badges
- **Border Color** — Borders and separators

#### Layout
- **Font Family** — Panel typography
- **Border Radius** — Corner rounding
- **Box Shadow** — Panel shadow
- **Gap** — Spacing between elements

#### Behavior
- **Hover In Delay** — Time before opening (default: 120ms)
- **Hover Out Delay** — Time before closing (default: 200ms)
- **Mobile Breakpoint** — Width for mobile mode (default: 980px)
- **Default Panel Width** — Full or Container

### Per-Item Settings

In **Appearance → Menus**, expand a menu item:

- **Enable Mega Panel** — Activate mega menu
- **Content Source** — Divi Layout or Custom Columns
- **Select Divi Layout** — Choose layout (if using Divi)
- **Panel Width** — Full / Container / Custom
- **Panel Alignment** — Left / Center / Right
- **Icon** — Optional icon class or SVG
- **Badge** — Optional label (e.g., "New", "Sale")

---

## Troubleshooting

### Mega menu doesn't appear

**Possible causes:**

1. **Plugin not activated**
   - Go to Plugins and activate TCB MegaMenu

2. **Mega Panel not enabled**
   - Edit menu and check "Enable Mega Panel"

3. **Menu not assigned to location**
   - In Menus, check a theme location and save

4. **No layout selected**
   - If using Divi, select a layout from dropdown

5. **No sub-items**
   - If using Custom Columns, add child items

### Divi layout doesn't render

**Possible causes:**

1. **Divi not active**
   - Activate Divi theme or Divi Builder plugin
   - Plugin shows warning if Divi is missing

2. **Layout is empty**
   - Edit layout in Divi Library and add content

3. **Layout not published**
   - Ensure layout is published (not draft)

### Colors don't apply

**Solutions:**

1. **Clear browser cache**
   - Press Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)

2. **Clear caching plugin**
   - If using WP Rocket, W3 Total Cache, etc., clear cache

3. **Check for CSS conflicts**
   - Use browser inspector to check for overrides

### Mobile menu doesn't work

**Solutions:**

1. **Check breakpoint**
   - Go to Settings → Behavior → Mobile Breakpoint
   - Adjust to match your theme

2. **Theme conflict**
   - Some themes have their own mobile menu
   - Check theme documentation

### JavaScript errors in console

**Solutions:**

1. **Plugin conflict**
   - Deactivate other plugins one by one

2. **Theme incompatibility**
   - Switch to default theme to test

3. **jQuery not loaded**
   - Admin requires jQuery (WordPress loads it by default)

---

## FAQ

### Do I need Divi?

**No.** The plugin works without Divi using "Custom Columns" mode. However, for Divi Library layouts, you need Divi theme or Divi Builder plugin.

### Is it accessible?

**Yes.** Full WCAG 2.1 AA compliance with keyboard navigation, screen reader support, and visible focus indicators.

### Will it slow my site?

**No.** Assets only load when mega menus are present. JavaScript is vanilla and < 5 KB. No jQuery on front-end.

### Can I use multiple mega menus?

**Yes.** Enable mega panels on as many parent items as needed. Each can have its own layout.

### How do I update?

1. Download new version
2. Deactivate old plugin
3. Delete old plugin
4. Upload and activate new version
5. Settings are preserved

### Can I customize with CSS?

**Yes.** Add custom CSS in **Appearance → Customize → Additional CSS**:

```css
/* Change badge color */
.tcb-badge {
    background: #ff6b6b;
}

/* Increase column spacing */
.tcb-columns {
    gap: 40px;
}
```

### Does it work with WooCommerce?

**Yes.** Works with any WordPress theme using `wp_nav_menu()`.

### Can I translate it?

**Yes.** The plugin is translation-ready. Translation files go in `/languages/` folder.

---

## Support

For support and documentation:
- **Website:** [thecreator.business](https://thecreator.business/)
- **Email:** support@thecreator.business

---

## License

GPL v2 or later - See LICENSE file for details.

---

**Thank you for using TCB MegaMenu!** 🎉
