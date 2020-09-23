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

        <div class="col footer__contacts">
          <p class="col-heading">contacts</p>
          <ul>
            <li>City</li>
            <li>Street</li>
            <li>+7 974 87 982</li>
            <li>irss2019@gmail.com</li>
          </ul>
        </div>
        <div class="col footer__social">
          <p class="col-heading">social</p>
          <ul>
            <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a></li>
            <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a></li>
            <li><a href="#"><img src="<?= get_template_directory_uri() . '/assets/images/social/twitter.svg' ?>"></a></li>
          </ul>
        </div>
        <div class="col footer__logo">
          <img src="<?= get_template_directory_uri() . '/assets/images/logo-footer.svg' ?>">
        </div>
        <div class="col">
          <p class="col-heading">news</p>
          <ul>
            <li>Num 1</li>
            <li>Num 2</li>
            <li>Num 3</li>
            <li>Num 4</li>
          </ul>
        </div>
        <div class="col">
          <p class="col-heading">events</p>
          <ul>
            <li>Num 1</li>
            <li>Num 2</li>
            <li>Num 3</li>
            <li>Num 4</li>
          </ul>
        </div>
        <div class="col">
          <p class="col-heading">blog</p>
          <ul>
            <li>Num 1</li>
            <li>Num 2</li>
            <li>Num 3</li>
            <li>Num 4</li>
          </ul>
        </div>

      </div>
      <div class="copyright">
        <p>COPYRIGHT 2020 QANTUMTHEMES. CUSTOMIZABLE TEXT.</p>
      </div>
    </div>
  </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
