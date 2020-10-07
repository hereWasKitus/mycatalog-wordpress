<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
get_template_part('template-parts/page-header'); ?>

	<main>
		<section class="floating-content p-single-product">
			<?php get_template_part('template-parts/floating-content-social'); ?>

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
		</section>

		<!-- PRODUCT BRIEF POPUP -->
		<div class="brief-popup-container js-brief-popup">
			<div class="brief-popup modal">

				<!-- HEADING -->
				<div class="brief-popup__header">
					<img src="<?= get_template_directory_uri() . '/assets/images/logo-mini.svg' ?>">
					<p class="brief-popup__header__title"><?= __('To explore the digital franchising opportunity for this brand, please, fill in this form: ', 'mycatalog') ?></p>
					<div class="brief-popup__close brief-popup__cross click-animation"></div>
				</div>

				<!-- CONTENT -->
				<div class="brief-popup__content">
					<form class="is-active">
						<input type="hidden" name="action" value="brief_popup_submit">
						<div class="brief-popup__control">
							<p class="brief-popup__control__title"><?= __('The markets you want to distribute:', 'mycatalog') ?></p>
							<input class="brief-popup__input-text" type="text" name="markets">
						</div>
						<div class="brief-popup__control">
							<p class="brief-popup__control__title"><?= __("The channels your're going to use for distribution:") ?></p>
							<div>
								<input type="checkbox" name="channels[]" value="Social media">
								<span><?= __('Social media', 'mycatalog') ?></span>
							</div>
							<div>
								<input type="checkbox" name="channels[]" value="Own online resource">
								<span><?= __('Own online resource', 'mycatalog') ?></span>
							</div>
							<div>
								<input type="checkbox" name="channels[]" value="Physical store">
								<span><?= __('Physical store', 'mycatalog') ?></span>
							</div>
							<div>
								<input type="checkbox" name="channels[]" value="Other">
								<span><?= __('Other', 'mycatalog') ?></span>
							</div>
							<div>
								<input type="checkbox" name="channels[]" value="I need a resource distribution">
								<span><?= __('I need a resource distribution', 'mycatalog') ?></span>
							</div>
						</div>
						<div class="brief-popup__control">
							<p class="brief-popup__control__title"><?= __("What information you'd like to receive about the brand?", 'mycatalog') ?></p>
							<input name="information" class="brief-popup__input-text" type="text">
						</div>
						<div class="brief-popup__control">
							<p class="brief-popup__control__title"><?= __('I want to:') ?></p>
							<div>
								<input type="checkbox" name="goals[]" value="Arrange a Zoom meeting with the brand representatives">
								<span><?= __('Arrange a Zoom meeting with the brand representatives', 'mycatalog') ?></span>
							</div>
							<div>
								<input type="checkbox" name="goals[]" value="Forward a business offer to this brand">
								<span><?= __('Forward a business offer to this brand', 'mycatalog') ?></span>
							</div>
						</div>
						<div class="brief-popup__control">
							<button class="brief-popup__submit click-animation" type="submit"><?= __('send', 'mycatalog') ?></button>
						</div>
					</form>
					<div class="brief-popup__thanks">
						<p class="brief-popup__thanks-text"><?= __('Your request is accepted and our manager will reach you in 48 hours!', 'mycatalog') ?></p>
						<div class="brief-popup__thanks-button brief-popup__close click-animation">OK</div>
					</div>
				</div>

			</div>
		</div>
	</main>

<?php
get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
