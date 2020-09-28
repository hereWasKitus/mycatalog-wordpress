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

  <header class="header <?= is_user_logged_in() ? 'is-logged-in' : '' ?>">
    <div class="wrapper">
      <div class="inner">

        <ul class="header__menu">
          <?php
            $franchise_pages = get_franchise_pages();
            foreach ( $franchise_pages as $index => $page ):
          ?>
          <li><a href="<?= $page['link'] ?>" class="click-animation"><?= $page['name'] ?></a></li>

          <?php if ( $index == 1 ): ?>
          <li class="header__logo">
            <a href="<?= home_url() ?>"><img src="<?= get_template_directory_uri() . '/assets/images/logo.svg' ?>"></a>
          </li>
          <?php endif; ?>

          <?php endforeach; ?>
        </ul>

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