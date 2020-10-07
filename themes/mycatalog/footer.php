<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mycatalog
 */

?>

  <footer class="footer">
    <div class="wrapper">
      <div class="inner">

        <div class="footer-grid">
          <!-- FOOTER CONTACT DATA -->
          <div class="footer-col footer-col--contact">
            <div class="footer__logo"><img src="<?= get_template_directory_uri() . '/assets/images/logo-footer.svg' ?>"></div>
            <p class="footer__phone">+7 000 00 0000</p>
            <p class="footer__mail">mycatalog@gmail.com</p>
          </div>

          <!-- FOOTER NEWSLETTER FORM -->
          <div class="footer-col footer-col--newsletter">
            <p class="footer__heading"><?= __('stay updated', 'mycatalog') ?></p>
            <form class="js-newsletter-form">
              <input type="hidden" name="action" value="subscribe_to_newsletter">
              <input type="email" name="email" placeholder="<?= __('Email', 'mycatalog') ?>">
              <input type="submit" value="<?= __('Subscribe to the newsletter', 'mycatalog') ?>">
            </form>
          </div>

          <!-- FOOTER SOCIAL -->
          <div class="footer-col footer-col--social">
            <p class="footer__heading"><?= __('social', 'mycatalog') ?></p>
            <div class="icons">
              <a href="<?= get_field('facebook', 'option') ?>"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a>
              <a href="<?= get_field('linkedin', 'option') ?>"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a>
              <a href="<?= get_field('instagram', 'option') ?>"><img src="<?= get_template_directory_uri() . '/assets/images/social/instagram.svg' ?>"></a>
            </div>
          </div>
        </div>

        <div class="footer-copyright">
          <p>COPYRIGHT 2020 mycatalog <a href="#">Terms & Conditions Privacy Policy</a></p>
        </div>

    </div>
  </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
