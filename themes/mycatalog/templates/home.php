<?php
/**
 * Template Name: Home
 */

get_header();
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="wrapper">
    <div class="inner">

      <h1><?= __('choose for yourself', 'mycatalog') ?></h1>
      <ul>
        <li><a href="#">pod</a></li>
        <li><a href="#">digital franchise</a></li>
        <li><a href="#">for advertisers</a></li>
        <li><a href="#">private label</a></li>
      </ul>

    </div>
  </div>
</section>

<!-- MAIN CONTENT -->
<main>
  <section class="floating-content">

    <div class="floating-content__social">
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/facebook.svg' ?>"></a>
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/linkedin.svg' ?>"></a>
      <a href="#" class="floating-content__social__icon"><img src="<?= get_template_directory_uri() . '/assets/images/social/twitter.svg' ?>"></a>
    </div>

    <!-- LAST 2 PRODUCTS -->
    <div class="last-products">
      <div class="wrapper">
        <div class="inner">
          <?php
          $loop = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => 2,
            'order' => 'DESC',
            'orderby' => 'date'
          ]);

          while ( $loop -> have_posts() ) :
            $loop -> the_post();
            $product = wc_get_product( get_the_ID() );
            $image = get_the_post_thumbnail_url();
          ?>

          <!-- LAST PRODUCT ITEM -->
          <div class="last-products__item">
            <div class="last-products__item__info">
              <span class="last-products__item__status"><?= __('new', 'mycatalog') ?></span>
              <p class="last-products__item__category"><?= $product -> get_categories() ?></p>
              <p class="last-products__item__price">$<?= $product -> get_regular_price() ?></p>
              <h3 class="last-products__item__name"><?= $product -> get_name() ?></h3>
              <a class="last-products__item__button click-animation" href="<?= get_the_permalink() ?>"><?= __('Buy now', 'mycatelog') ?></a>
            </div>
            <div class="last-products__item__image">
              <a href="<?= get_the_permalink() ?>"><img src="<?= $image ?>"></a>
              <div class="sale-circle is-top-right"><span><?= __('Sale!') ?></span></div>
            </div>
          </div>

          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </div>

    <!-- PRODUCTS -->
    <div class="products">
      <!-- PRODUCTS SEARCH -->
      <div class="products__search">
        <div class="products__search__input">
          <input type="text" name="product-query" placeholder="<?= __('Search...', 'mycatalog') ?>">
          <img class="products__search-trigger click-animation" src="<?= get_template_directory_uri() . '/assets/images/search.svg' ?>">
        </div>
        <select name="products-category" class="products__search__category custom-select">
          <option value=""><?= __('Choose category', 'mycatalog') ?></option>
          <?php foreach ( get_products_categories() as $cat ): ?>
          <option value="<?= $cat['slug'] ?>"><?= $cat['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- PRODUCTS GRID -->
      <div class="products__grid">
        <?php
          $paged = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ) : 1;

          // Fix pagination offset
          $products_loop = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => 12,
            'order' => 'ASC',
            'orderby' => 'date',
            'paged' => $paged
          ]);

          while ( $products_loop -> have_posts() ) :
            $products_loop -> the_post();
            $product = wc_get_product( get_the_ID() );
            $image = get_the_post_thumbnail_url();
          ?>
          <div class="products__grid__item">
            <img class="products__grid__item__image" src="<?= $image ?>">
            <div class="products__grid__item__footer">
              <div class="products__grid__item__category"><?= $product -> get_categories() ?></div>
              <h3 class="products__grid__item__name"><?= $product -> get_name() ?></h3>
              <p class="products__grid__item__price">$<?= $product -> get_regular_price() ?></p>
            </div>
            <a class="products__grid__item__link" href="<?= get_the_permalink() ?>"></a>
          </div>
          <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <!-- PRODUCTS PAGINATION -->
      <?php
        $big = 999999999;
        $pagination_html = paginate_links( array(
          'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'current' => max( 1, get_query_var('page') ),
          'total'   => $products_loop->max_num_pages,
          'next_text' => "<img src=" . get_template_directory_uri() . '/assets/images/pagination-arrow.svg' . ">",
          'prev_text' => "<img src=" . get_template_directory_uri() . '/assets/images/pagination-arrow.svg' . ">"
        ) );

        if ( strlen( $pagination_html ) > 0 ) :
      ?>
      <div class="products__pagination"><?= $pagination_html ?></div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>