<?php
/**
 * Template Name: Franchise page
 */
  get_header();
?>
<div class="template-franchise">
  <div class="wrapper">
    <div class="inner">

      <!-- TEXT SECTION -->
      <div class="franchise-section">
        <div class="franchise-title">
          <img src="<?= get_template_directory_uri() . '/assets/images/back-arrow.svg' ?>" class="js-history-back click-animation">
          <h1><?= get_the_title() ?></h1>
        </div>

        <div class="franchise-content"><?= get_the_content() ?></div>

        <?php
          $form_template = get_field('franchise_form');
          get_template_part("template-parts/{$form_template}");
        ?>
      </div>

      <!-- IMAGES SECTION -->
      <div class="franchise-section franchise-image">
        <img src="<?= get_field('franchise_image') ?>">
      </div>

    </div>
  </div>
</div>
<?php get_footer(); ?>