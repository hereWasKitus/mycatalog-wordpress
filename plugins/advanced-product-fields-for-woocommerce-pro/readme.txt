=== Advanced Product Fields Pro for WooCommerce ===
Contributors: studiowombat,maartenbelmans
Tags: woocommerce, custom fields, product, addon, acf
Requires at least: 4.5
Tested up to: 5.5.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.4.5

Customize WooCommerce product pages with extra form fields ( = product add-ons). This is the premium version.

== Description ==

The premium version of Advanced Product Fields for WooCommerce.

== Changelog ==

= version 1.4.5 =
 * Added: new conditional rules based on product attributes.
 * Added: compatibility with WooCommerce subscriptions (beta).
 * Added: paragraph field can now contain HTML links with style & class attributes.
 * Fix: fixed return statement in recalculate_cart_item_price filter function.
 * Fix: fixed a bug with the conditional setting "product type" in the backend.
 * Fix: fixed edge case bug in the lookup tables functionality.

= version 1.4.4 =
 * Added: now works with WooCommerce's "order again" functionality.
 * Fix: fixed an issue where the multi select swatches couldn't have multiple swatches pre-selected from the admin.
 * Fix: fixed an issue where some price formulas showed rounding errors of 0.1 cents.
 * Fix: fixed "advanced" tab of Yoast SEO plugin not showing.
 * Fix: minor WP 5.5 admin style changes.

= version 1.4.3 =
 * Added: pricing options can now add negative pricing (below zero).
 * Fix: fixed a bug where in some cases, the system would automatically add duplicated rules to fields.
 * Fix: improved admin settings performance when adding many gallery images.
 * Fix: fixed a bug with required multi-select images and "min" and "max" selections.
 * Tweak: for devs: replaced filter "wapf/field_classes/{field id}" with "wapf/html/field_classes" on field level.
 * Tweak: for devs: replaced filter "wapf/field_classes" with "wapf/html/field_container_classes" on container level.

= version 1.4.2 =
 * Added: options to hide fields from the cart, checkout, order & order emails.
 * Added: support for WooCommerce [product_page] shortcode.
 * Added: new hook for developers "wapf/pricing/mini_cart_item_price".
 * Update: bumped required WooCommerce from 3.2 to 3.4, but 3.2 compatibility is still ensured for min. 3 updates.
 * Fix: removed some PHP warnings that were appearing in certain cases.
 * Fix: fixed mini cart display with the WOOCS plugin integration.

= verion 1.4.1 =
 * Fix: fixed a PHP warning with stripslashes().

= version 1.4 =
 * Added: product images can now change according to the last selected option from the user.
 * Added: integration with a new plugin: Yith Request a Quote.
 * Added: new hook for developers: wapf/html/product_totals/data.
 * Added: new hook for developers: wapf/html/pricing_hint/amount.
 * Update: hide Stripe's "buy now" buttons on product page as an integration is sadly not possible.
 * Update: "add to cart" backend validation now also takes into account min/max selections for cloned fields.
 * Update: improved saving product fields to the database.
 * Update: added WOOCS compatibility for formula-based pricing.
 * Fix: fixed an edge-case bug where empty conditionals would be added to the field backend.
 * Fix: fixed a bug with recalculating pricing on cart page when cart was updated.
 * Fix: fixed a bug with WOOCS compatibility and recalculating pricing on page reload.
 * Fix: removed "wapf-checked:hover" styles for image swatches to fix android mobile issues where deselect styling wasn't correctly applied.
 * Fix: fixed a bug when changing field types in the backend. The "required" attribute didn't revert to "false" when doing so.
 * Fix: fixed "Delete permanently" label in the backend.
 * Fix: fixed an issue when refreshing the page after duplicating would generate another duplicate.
 * Fix: fixed an issue when a user entered text with a quote symbol, a slash would appear before it in cart/checkout.

= version 1.3 =
 * Added: lookup tables for pricing options (currently beta).
 * Added: new option for "number" field to allow decimal numbers as well.
 * Added: option to define maximum selectable choices in a multiple-choice option.
 * Added: option to define the minimum selectable choices in a multiple-choice option.
 * Added: added filter "wapf/html/field_label" to change field labels programmatically.
 * Added: added filter "wapf/html/field_description" to change field descriptions programmatically.
 * Added: frontend & backend filters so developers can add their own functions in formulas.
 * Update: if needed, upgrade notices will be shown on the plugin update page of your dashboard. So you know when a large update requires testing.
 * Fix: fixed an issue with duplicating field groups in the admin screen.
 * Fix: fixed a CSS issue with portrait thumbnail preview of "change product image" option.
 * Fix: fixed an issue where the pricing hint didn't have the same HTML across all pages (cart, checkout, order).
 * Fix: fixed a bug where admin screen keeps on loading when you added a section field that had "variable product" conditions.

= version 1.2.6 =
 * Fix: fixed a small pricing display issue with taxed products.
 * Fix: fixed an issue with some mini carts.
 * Fix: fixed a small bug with deleting fields in the backend that were used in the variable builder.
 * Fix: fixed a bug with the "pattern" option on the text field.
 * Fix: fixed a small bug with deleting some variables from the variable builder.
 * Fix: fixed a bug with duplicating field groups under "WooCommerce > Product Fields". field ID's weren't unique when duplicating.

= version 1.2.5 =
  * Added: new field "File Upload".
  * Added: variable builder for more complex pricing options.
  * Added: support for the Flatsome theme.
  * Added: new options for the "text" field: for the HTML5 validation pattern, min. character and max. character length.
  * Added: new options for the "textarea" field: min. character and max. character length.
  * Update: the paragraph field can now contain shortcodes.
  * Update: added some styling for compatibility with Elementor page builder to layout your product pages.
  * Update: update the backend UI for conditional rules so there's less clutter on the screen.
  * Update: verify compatibility with Woo 4.0 an 4.0.1.
  * Fix: fixed an issue with mini cart and options pricing.
  * Fix: fixed a bug with cart validation and choice fields.
  * Fix: fixed a bug with quantity-based select fields & custom formulas.
  * Fix: fixed a compatibility issue when using variable products in the Product Table plugin of Barn2 Media.
  * Fix: fixed a bug with validating cart data and the true/false field in a conditional setting.

= version 1.2.4 =
 * Fix: fixed an issue with required radio buttons not firing "onchange" event.

= version 1.2.3 =
 * Update: added "quantity based percentage fee" as pricing option.
 * Update: added possibility to use min() and max() in pricing formulas.
 * Update: added an invisible order meta array with extra info for other plugins or our API.
 * Update: improved plugin update notification for multisite networks that don't have the plugin globally activated.
 * Fix: fixed a bug with percentage based pricing in cart.
 * Fix: fixed wrong addon price being shown in cart for checkbox fields with different prices.

= version 1.2.2 =
 * Added: new integration with Woodmart theme (if you don't use that theme, it won't be loaded).
 * Update: The HTLM "i" element is now allowed in option labels and descriptions.
 * Update: better error indication when saving field groups in the admin.
 * Update: UX improvement: duplicating sections in the backend will now also duplicate children in these sections.
 * Update: support lazy loading by Jetpack on the frontend.
 * Fix: field labels were sometimes not displaying in the same order on the cart or checkout page.
 * Fix: fix a bug with system generated conditionals for nested fields.

= version 1.2.1
 * Added: formulas can now contain other field values.
 * Added: added extra API call to fetch fields from an order.
 * Added: added a filter so developers can easily edit attributes of input elements.
 * Added: added two new options to the "true-false" field.
 * Update: swatches can now be deselected.
 * Update: added field ID in the backend order meta information so it can be picked up by our API.
 * Fix: fixed a bug with "multi select text swatch" not being selectable in the backend settings screen.
 * Fix: fixed an issue with non-selected checkboxes of duplicated quantity-based fields.
 * Fix: bugfixes & various improvements when working with quantity-based "section" fields.

= version 1.2.0 =
 * Fix: fixed a bug with conditional rules on a 'paragraph' field.
 * Fix: fixed a bug with the pricing of the first quantity-based true-false field in a set of fields.
 * Fix: fixed a bug with the HTML label of quantity-based radio buttons & checkboxes.
 * Fix: fixed a bug with dependency fields and radio buttons defaulting back to their original state without UI update.

=version 1.1.9=
 * Added: action hooks for developers.
 * Update: allow multiple class names in the "class" setting of each field.
 * Update: allow more HTML tags in the paragraph field.
 * Update: allow some HTML in the swatch labels.
 * Fix: fixed minor CSS issue for fields of different widths.
 * Fix: fixed wrong labels being shown when duplicating a whole section.
 * Fix: fixed a bug where duplicated sections didn't appear in "cart" screen.

=version 1.1.8=
 * Added: new field type "section" which allows to group fields.
 * Added: section field can group quantity fields together.
 * Fix: when min/max value of number field was 0, it wasn't output to the frontend.
 * Fix: fixed a bug with "required" fields and variable product conditions.

=version 1.1.7=
 * Added: new conditional: product tags.
 * Update: the frontend Javascript is smaller (from 5kb to 4.8kb gzipped).
 * Update: changed some admin CSS to better match the new WordPress admin UI.

=version 1.1.6=
 * Added: new field type: "text swatch".
 * Added: new field type: "paragraph".
 * Added: new field type: "image".
 * Added: Added support for Tiered Pricing plugin (if applicable).
 * Update: uses less JavaScript dependencies now.
 * Update: Added more filters so developers can extend.
 * Fix: better image zooming support on single product page (if enabled within the theme).
 * Fix: "select options" was sometimes showing incorrectly.

=version 1.1.5=
 * Added: formula-based pricing for more advanced pricing options.
 * Fix: fixed a bug with "ajax add to cart" themes and "required" image swatches.
 * Fix: fixed a bug when calculating percentage based pricing on the frontend.
 * Fix: fixed a bug with jQuery in the "product edit" screen in the backend.
 * Fix: fixed the "percentage pricing" hint output.

=version 1.1.4=
 * Added: support taxation.
 * Added: support multi-currency with the WOOCS plugin.
 * Added: support for multilingual stores with Polylang & WPML.
 * Added: the settings "show in cart" & "show in checkout" now default to "yes".
 * Added: more layout options for multi-image swatches.
 * Added: option to show/hide field summary in the mini cart.
 * Fix: fixed a bug with color swatches and the "required" HTML attribute.

=version 1.1.3=
 * Added: better dependency checking on the frontend.
 * Added: the dropdown label "choose an option" now only appears when necessary.
 * Added: added frontend translations for Dutch, French, German, and Spannish.
 * Fix: fixed an issue with select lists and pricing.
 * Fix: fixed an issue with true-false field price labeling.
 * Fix: fixed an issue with columns wrapping on a new line when setting variable widths.


=version 1.1.2=
 * Added: added new pricing method: value x amount.
 * Added: added new pricing method: characters x amount.
 * Added: support for variations loaded via ajax.
 * Added: better support for adding quantity-based fields to the cart.
 * Added: better support for the image slider on page load.
 * Added: you can now also find products in draft when searching products in the backend.
 * Added: added extra info dialogs to the pricing options, so you better understand all options available.
 * Fix: fixed an issue with themes using a "section" element instead of a "div" in single product templates.
 * Fix: fixed an image-switching issue with true/false fields.
 * Fix: fixed an issue with hidden fields wrongly validating in cart.
 * Fix: fixed an issue with removing quantity-based fields on the frontend.
 * Fix: minor styling corrections for the color swatches.

=version 1.1.1=
 * Fix: better compatibility when switching from free to premium.
 * Fix: fixed a bug with duplicating a field in the backend.
 * Fix: fixed jQuery image zoom issue with some themes.

=version 1.1.0=
 * Update: Your options can now also change the product image on the product page.
 * Added: added tootlips to the color swatches.
 * Added: added more design options to the color swatches.
 * Fix: fixed decimal issue in numbers with USA format.
 * Fix: fixed color swatch file issue.
 * Fix: fixed an issue with images and non ascii characters in their file name.

=version 1.0.7=
 * Fix: fixed a HTML bug with checkbox series.

=version 1.0.6=
 * Added: added a few API functions for developers. This will grow in the future.
 * Fix: fixed a small issue with price labels showing even if price addition was zero.

=version 1.0.5=
 * Added: added .pot file for translators.
 * Added: added filter for devs to change the "product totals" HTML.
 * Update: allow some HTML in field descriptions & labels.

= version 1.0.4 =
* Fix: fixed a bug with item pricing when changing item quantity on the cart page.

= version 1.0.3 =
 * Fix: small backend Javascript bugfix.

= version 1.0.2 =
 * Update: Made frontend Javascript file 19% smaller.

= version 1.0.1 =
 * Update: HTML Changes so it can more easily be styled with CSS

= version 1.0.0 =
 * Initial version