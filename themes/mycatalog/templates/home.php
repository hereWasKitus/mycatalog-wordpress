<?php
/**
 * Template Name: Home
 */

get_header();

get_template_part('template-parts/page-header');
?>
<!-- MAIN CONTENT -->
<main>
  <section class="floating-content">

    <?php get_template_part('template-parts/floating-content-social') ?>

    <!-- LAST 2 PRODUCTS -->
    <div class="last-products">
      <div class="wrapper">
        <div class="inner slick-last-products">
          <?php
          $loop = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => 2,
            'order' => 'DESC',
            'orderby' => 'date'
          ]);
          $count = 0;

          while ( $loop -> have_posts() ) :
            $loop -> the_post();
            $product = wc_get_product( get_the_ID() );
            $image = get_the_post_thumbnail_url();
            $is_sale = $product -> get_sale_price() != '';
            $currency = get_woocommerce_currency_symbol();
            $price = $is_sale ? $product -> get_sale_price() : $product -> get_regular_price() ;
          ?>

          <!-- LAST PRODUCT ITEM -->
          <!-- <div class="last-products__item-container"> -->
          <div class="last-products__item <?= "item-" . $loop -> current_post ?>">
            <div class="last-products__item__info">
              <span class="last-products__item__status"><?= __('new', 'mycatalog') ?></span>
              <p class="last-products__item__category"><?= $product -> get_categories() ?></p>
              <p class="last-products__item__price"><?= $currency . $price ?></p>
              <h3 class="last-products__item__name"><?= $product -> get_name() ?></h3>
              <a class="last-products__item__button click-animation" href="<?= get_the_permalink() ?>"><?= __('Buy now', 'mycatalog') ?></a>
            </div>
            <div class="last-products__item__image">
              <a href="<?= get_the_permalink() ?>"><img src="<?= $image ?>"></a>
              <?php if ( $is_sale ): ?>
              <div class="sale-circle is-top-right"><span><?= __('Sale!', 'mycatalog') ?></span></div>
              <?php endif; ?>
            </div>
          </div>
          <!-- </div> -->

          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </div>

    <!-- PRODUCTS -->
    <div class="products">
      <!-- PRODUCTS SEARCH -->
      <div class="products-search">
        <div class="products-search__input loading-animation">
          <input type="text" name="product-query" placeholder="<?= __('Search...', 'mycatalog') ?>">
          <img class="products-search__trigger click-animation" src="<?= get_template_directory_uri() . '/assets/images/search.svg' ?>">
          <ul class="products-search__list">
            <li>Juice 1</li>
            <li>Juice 2</li>
            <li>Juice 1</li>
            <li>Juice 2</li>
            <li>Juice 1</li>
            <li>Juice 2</li>
          </ul>
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
            'order' => 'DESC',
            'orderby' => 'date',
            'paged' => $paged
          ]);

          while ( $products_loop -> have_posts() ) :

            $products_loop -> the_post();
            get_template_part('template-parts/product-item');

          endwhile;
          wp_reset_postdata();
          ?>
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