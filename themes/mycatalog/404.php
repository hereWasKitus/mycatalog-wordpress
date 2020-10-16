<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package mycatalog
 */

get_header();
?>
<div class="wrapper">
	<div class="error404-content">
		<div class="error404-content__images">
			<div class="error404-content__images-main">
				<img src="<?= get_template_directory_uri() . '/assets/images/error404-cut.png' ?>" alt="error 404 page">
				<div class="error404-content__images-oops">
					<img src="<?= get_template_directory_uri() . '/assets/images/error404-oops.svg' ?>" alt="error 404 oops!">
					<p><?= __('oops!', 'mycatalog') ?></p>
				</div>
			</div>
		</div>
		<div class="error404-content__text">
			<p><?= __('This page is currently unavailable or does not exist.', 'mycatalog') ?></p>
		</div>
		<div class="error404-content__circles-top">
			<div class="error404-content-circle error404-content-circle-s117"></div>
			<div class="error404-content-circle error404-content-circle-s39"></div>
			<div class="error404-content-circle error404-content-circle-s13"></div>
		</div>
		<div class="error404-content__circles-bottom">
			<div class="error404-content-circle error404-content-circle-s13"></div>
			<div class="error404-content-circle error404-content-circle-s39"></div>
			<div class="error404-content-circle error404-content-circle-s117"></div>
		</div>
	</div>
</div>

<?php
get_footer();
