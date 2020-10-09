<?php
$product = wc_get_product( get_the_ID() );
$image = get_the_post_thumbnail_url();
$currency = get_woocommerce_currency_symbol();
$is_sale = $product -> get_sale_price() != '';
?>

<div class="c-product-item">
  <img class="c-product-item__image" src="<?= $image ?>">
  <div class="c-product-item__footer">
    <div class="c-product-item__category"><?= $product -> get_categories() ?></div>
    <h3 class="c-product-item__name"><?= $product -> get_name() ?></h3>

    <?php if ( $is_sale ): ?>
    <p class="c-product-item__price">
      <span class="crossed"><?= $currency . $product -> get_regular_price() ?></span>
      <?= $currency . $product -> get_sale_price() ?>
    </p>
    <?php else: ?>
    <p class="c-product-item__price">
      <?= $currency . $product -> get_regular_price() ?>
    </p>
    <?php endif; ?>

  </div>
  <a class="c-product-item__link" href="<?= get_the_permalink() ?>"></a>
  <?php if ( $is_sale ): ?>
  <div class="sale-circle is-top-right"><span><?= __('Sale!', 'mycatalog') ?></span></div>
  <?php endif; ?>
</div>