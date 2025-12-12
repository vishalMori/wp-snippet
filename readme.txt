=== Classic Theme Slug ===
Contributors: your-name
Tags: blog, responsive, accessibility-ready, custom-menu, featured-images, translation-ready
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A fast, secure, and minimalist WordPress theme ideal for blogs and small content websites.

== Description ==

**Classic Theme Slug** is a clean and modern WordPress theme with performance and security in mind. It includes custom template files, widget areas, and enhanced frontend performance. Ideal for developers who want a strong base to customize or extend further.

== Features ==

* ✅ Fully responsive and accessible
* 🧩 Custom templates: Custom Page
* 🧷 Widget-ready (custom sidebar area)
* 🛡️ Security-focused headers included:
    - Strict-Transport-Security (HSTS)
    - Referrer-Policy
    - X-Frame-Options, X-XSS-Protection, X-Content-Type-Options
* 📄 SVG file upload support
* 🚫 Disables large image scaling
* 🧹 Removes unneeded block editor styles (for optimization)
* ⚡ Cache-busting via `filemtime()` in style/script enqueueing
* ✉️ Compatible with Contact Form 7 (`wpcf7_autop_or_not` filter supported)

== Installation ==

1. Upload the theme to the `/wp-content/themes/` directory.
2. Activate the theme via **Appearance > Themes** in the admin dashboard.
3. Create a new page and assign the “Contact Page” template under **Page Attributes**.

== Frequently Asked Questions ==

= How do I show a contact form? =  
Install a plugin like Contact Form 7 or WPForms and paste the shortcode into the Contact Page's content.

= Can I upload SVGs with this theme? =  
Yes. SVG upload support is built-in.

= How can I add a custom sidebar widget? =  
Go to **Appearance > Widgets**, and use the **Your Widgets** area.

= Are default Gutenberg/block styles removed? =  
Yes. To improve speed, block library styles are dequeued unless you re-enable them.

== Changelog ==

= 1.0.0 =
* Initial release.
* Custom header security filters added.
* Custom widget area registered.
* Contact page template added.
* Scripts and styles properly enqueued with cache-busting.
* SVG upload and large image size threshold disabled.

== Credits ==

* WordPress Theme Developer Handbook
* HTML5 boilerplate ideas

== License ==

This theme is distributed under the GPL v2 or later.
See https://www.gnu.org/licenses/gpl-2.0.html for full license text.
