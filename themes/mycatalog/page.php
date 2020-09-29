<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mycatalog
 */

get_header();
?>

	<?php get_template_part('template-parts/page-header') ?>

	<main id="primary" class="site-main">
		<section class="floating-content">

			<div class="floating-content__social">
				<a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a>
				<a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a>
				<a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/twitter.svg' ?>"></a>
			</div>

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</section>
	</main><!-- #main -->

<?php
get_footer();