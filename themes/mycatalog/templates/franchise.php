<?php
/**
 * Template Name: Franchise page
 */
  get_header();
  global $post;
  $slug = $post -> post_name;
?>
<div class="template-franchise <?= "franchise-$slug" ?>">
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

  <!-- THANK YOU POPUP -->
  <div class="brief-popup-container">
    <div class="brief-popup">
      <div class="brief-popup__header">
        <img src="<?= get_template_directory_uri() . '/assets/images/logo-mini.svg' ?>">
        <p class="brief-popup__header__title"><?= __('Thank you!', 'mycatalog') ?></p>
        <div class="brief-popup__close brief-popup__cross click-animation"></div>
      </div>
      <div class="brief-popup__content">
        <p><?= __('Thanks for your request!', 'mycatalog') ?></p>
        <p><?= __('Our managers will contact you asap', 'mycatalog') ?></p>
        <input type="submit" class="brief-popup__submit" value="<?= __('ok', 'mycatalog') ?>">
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>