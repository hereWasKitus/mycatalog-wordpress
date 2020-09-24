<?php
  $user = is_user_logged_in() ? wp_get_current_user() : false;
  $avatar_url = $user !== false ? get_avatar_url( $user -> ID ) : '';
  $cart_count = '';

  if ( $user !== false ) {
    global $woocommerce;
    $cart_count = $woocommerce -> cart -> cart_contents_count;
  }
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

  <header class="header <?= is_user_logged_in() ? 'is-logged-in' : '' ?>">
    <div class="wrapper">
      <div class="inner">

        <ul class="header__menu">
          <li><a href="#" class="click-animation">pod</a></li>
          <li><a href="#" class="click-animation">digital franchise</a></li>

          <li class="header__logo">
            <a href="<?= home_url() ?>"><img src="<?= get_template_directory_uri() . '/assets/images/logo.svg' ?>"></a>
          </li>

          <li><a href="#" class="click-animation">for advertisers</a></li>
          <li><a href="#" class="click-animation">private label</a></li>
        </ul>

        <div class="header__user">
          <a href="<?= wc_get_cart_url() ?>" class="header__user-cart">
            <img src="<?= get_template_directory_uri() . '/assets/images/basket.svg' ?>">
            <span class="header__user-cart__counter"><?= $cart_count ?></span>
          </a>
          <a href="#" class="header__user-avatar">
            <img src="<?= get_template_directory_uri() . '/assets/images/no-avatar.svg' ?>">
          </a>
        </div>

      </div>
    </div>
  </header><!-- #masthead -->