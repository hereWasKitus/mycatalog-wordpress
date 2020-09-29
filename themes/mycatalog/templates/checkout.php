<?php
/**
 * Template Name: Checkout
 */
get_header();

get_template_part('template-parts/page-header');
?>

<main>
  <section class="floating-content p-checkout">

    <div class="floating-content__social">
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a>
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a>
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/twitter.svg' ?>"></a>
    </div>

    <h2><?= get_the_title() ?></h2>

    <?php get_template_part('template-parts/back-button') ?>

    <?php the_content() ?>

  </section>
</main>

<?php get_footer() ?>