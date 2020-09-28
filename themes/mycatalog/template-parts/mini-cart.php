<?php
global $woocommerce;
$cart_count = WC() -> cart -> cart_contents_count;
?>

<div class="mini-cart js-mini-cart">
  <img class="mini-cart__icon" src="<?= get_template_directory_uri() . '/assets/images/basket.svg' ?>">
  <span class="mini-cart__count"><?= $cart_count ?></span>

  <!-- PRODUCTS LIST -->
  <div class="mini-cart-container">
    <?php if ( ! WC()->cart->is_empty() ) : ?>
    <ul class="mini-cart__list woocommerce-mini-cart  <?php echo esc_attr( $args['list_class'] ); ?>">
      <?php
      do_action( 'woocommerce_before_mini_cart_contents' );

      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
          $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
          $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
          $thumbnail_url     = get_the_post_thumbnail_url($product_id);
          $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
          $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
          ?>
          <li class="mini-cart-item woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
            <a class="mini-cart-item__image" href="<?= $product_permalink ?>"><img src="<?= $thumbnail_url ?>"></a>
            <div class="mini-cart-item__info">
              <span class="mini-cart-item__name"><?= $product_name ?></span>
              <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
              <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="mini-cart-item__quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <a href="#" class="mini-cart-item__remove" aria-label="<?= esc_attr__( 'Remove this item', 'woocommerce' ) ?>" data-product_id="<?= esc_attr( $product_id ) ?>" data-cart_item_key="<?= esc_attr( $cart_item_key ) ?>" data-product_sku="<?= esc_attr( $_product->get_sku() ) ?>"></a>
          </li>
          <?php
        }
      }
      do_action( 'woocommerce_mini_cart_contents' );
      ?>
    </ul>

    <!-- TOTAL -->
    <p class="mini-cart__total woocommerce-mini-cart__total total">
      <?php do_action( 'woocommerce_widget_shopping_cart_total' ); ?>
    </p>

    <!-- BUTTONS -->
    <p class="mini-cart__buttons woocommerce-mini-cart__buttons buttons">
      <a href="<?= esc_url( wc_get_cart_url() ) ?>" class="mini-cart__button click-animation"><?= __('View cart', 'mycatalog') ?></a>
      <a href="<?= esc_url( wc_get_checkout_url() ) ?>" class="mini-cart__button click-animation"><?= __('Checkout', 'mycatalog') ?></a>
    </p>

    <?php else : ?>
    <p class="mini-cart__empty-message"><?= __('No products in the cart.', 'mycatalog') ?></p>
    <?php endif; ?>
  </div>

</div>