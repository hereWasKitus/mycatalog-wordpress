<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );

$attachment_ids = $product->get_gallery_image_ids();
?>

<!-- PRODUCT GALLERY -->
<div class="c-product-images">
  <div class="c-product-images__main">
    <img data-index="0" src="<?= get_the_post_thumbnail_url() ?>">
  </div>

  <div class="c-product-images__gallery">
    <?php foreach ( $attachment_ids as $key => $attachment_id ): ?>
    <img data-index="<?= $key + 1 ?>" src="<?= wp_get_attachment_url( $attachment_id ) ?>">
    <?php endforeach; ?>
  </div>

  <!-- PRODUCT GALLERY POPUP -->
  <div class="gallery-popup-container js-gallery-popup">
    <div class="gallery-popup">

      <!-- BIG IMAGES -->
      <div class="gallery-popup__display-image">
        <div class="gallery-popup__button-close close click-animation"></div>
        <a data-direction="<?= is_rtl() ? '1' : '-1' ?>" href="#" class="gallery-popup__arrow left"><img class="except" src="<?= get_template_directory_uri() . '/assets/images/popup-arrow.svg' ?>"></a>
        <img data-index="0" class="is-active" src="<?= get_the_post_thumbnail_url() ?>">
        <?php foreach ( $attachment_ids as $key => $attachment_id ): ?>
        <img data-index="<?= $key + 1 ?>" src="<?= wp_get_attachment_url( $attachment_id ) ?>">
        <?php endforeach; ?>
        <a data-direction="<?= is_rtl() ? '-1' : '1' ?>" href="#" class="gallery-popup__arrow right"><img class="except" src="<?= get_template_directory_uri() . '/assets/images/popup-arrow.svg' ?>"></a>
      </div>

      <!-- SMALL IMAGES -->
      <div class="gallery-popup__images-list">
        <div class="gallery-popup__small-image is-active" data-index="0"><img src="<?= get_the_post_thumbnail_url() ?>"></div>
        <?php foreach ( $attachment_ids as $key => $attachment_id ): ?>
        <div class="gallery-popup__small-image" data-index="<?= $key + 1 ?>"><img src="<?= wp_get_attachment_url( $attachment_id ) ?>"></div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

</div>