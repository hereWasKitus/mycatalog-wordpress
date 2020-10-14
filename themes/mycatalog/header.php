<?php
  $user = is_user_logged_in() ? wp_get_current_user() : false;
  $avatar_url = $user !== false ? get_avatar_url( $user -> ID ) : '';
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

  <header class="header">
    <div class="wrapper">
      <div class="inner">

        <!-- HEADER MENU -->
        <div class="header__menu">
          <div class="menu-button">
            <div class="menu-button__line"></div>
            <div class="menu-button__line"></div>
            <div class="menu-button__line"></div>
          </div>

          <div class="header__menu__list-wrapper">
            <ul class="header__menu__list">
              <?php foreach ( get_franchise_pages() as $page ): ?>
              <li><a href="<?= $page['link'] ?>"><?= $page['name'] ?></a></li>
              <?php endforeach; ?>
            </ul>
            <ul class="header__menu__social">
              <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a></li>
              <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/twitter.svg' ?>"></a></li>
              <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a></li>
            </ul>
          </div>
        </div>

        <a class="header__logo" href="<?= home_url() ?>">
          <?php $logo_url = get_template_directory_uri() . '/assets/images/logo-svg.svg' ?>
          <img src="<?= $logo_url ?>">
        </a>

        <div class="header__user">
          <div class="header__user-cart">
            <?php get_template_part('template-parts/mini-cart') ?>
          </div>
          <a href="#" class="header__user-avatar">
            <img src="<?= get_template_directory_uri() . '/assets/images/no-avatar.svg' ?>">
          </a>
        </div>

      </div>
    </div>
  </header><!-- #masthead -->