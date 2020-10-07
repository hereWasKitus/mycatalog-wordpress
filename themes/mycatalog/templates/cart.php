<?php
/**
 * Template Name: Cart
 */
get_header();

get_template_part('template-parts/page-header');
?>

<main>
  <section class="floating-content p-cart">

    <?php get_template_part('template-parts/floating-content-social') ?>

    <h2 class="p-cart__title"><?= get_the_title() ?></h2>

    <?php get_template_part('template-parts/back-button') ?>

    <?php the_content() ?>

  </section>
</main>

<?php get_footer() ?>