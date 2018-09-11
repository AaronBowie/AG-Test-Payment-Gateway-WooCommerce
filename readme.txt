=== Plugin Name ===
Contributors: Aaron - We are AG
Requires at least: 4.0
Tested up to: 4.9.*
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: WooCommerce, Payment gateway, test gateway, debug gateway

A simple test payment gateway for WooCommerce, The gateway is shown to admins only by default, anyone in WP_DEBUG mode or customers via tick box in the settings.

== Description ==

Adds a simple test payment gateway to WooCommerce.

This can be safely used in the live environment for telephone/email orders etc as outside of the settings to enable for certain groups, only an administrator can see the gateway.

When WP_DEBUG is set to true in your wp-config.php file this will show for everyone. Very useful when testing the user journey for new builds or in situations where payment is not needed

== Changelog ==

= 0.1 =
* Initial build and release.
