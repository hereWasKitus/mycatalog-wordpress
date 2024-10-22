<?php
/**
 * mycatalog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mycatalog
 */

if ( ! defined( '_S_VERSION' ) ) {
  // Replace the version number of the theme on each release.
  define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'mycatalog_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function mycatalog_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on mycatalog, use a find and replace
     * to change 'mycatalog' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'mycatalog', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
      array(
        'menu-1' => esc_html__( 'Primary', 'mycatalog' ),
      )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
      'html5',
      array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
      )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
      'custom-background',
      apply_filters(
        'mycatalog_custom_background_args',
        array(
          'default-color' => 'ffffff',
          'default-image' => '',
        )
      )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
      'custom-logo',
      array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
      )
    );
  }
endif;
add_action( 'after_setup_theme', 'mycatalog_setup' );
add_theme_support( 'woocommerce' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mycatalog_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'mycatalog_content_width', 640 );
}
add_action( 'after_setup_theme', 'mycatalog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mycatalog_widgets_init() {
  register_sidebar(
    array(
      'name'          => esc_html__( 'Sidebar', 'mycatalog' ),
      'id'            => 'sidebar-1',
      'description'   => esc_html__( 'Add widgets here.', 'mycatalog' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action( 'widgets_init', 'mycatalog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mycatalog_scripts() {
  wp_enqueue_style( 'mycatalog-style', get_stylesheet_uri(), array(), _S_VERSION );
  wp_style_add_data( 'mycatalog-style', 'rtl', 'replace' );

  wp_enqueue_script( 'mycatalog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  // jQuery
  if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ( 'https://code.jquery.com/jquery-3.5.1.min.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );
	}

  // Slick
  if ( is_front_page() ) {
    wp_enqueue_style( 'mycatalog-slick-style', get_template_directory_uri() . '/src/css/slick.css', array(), false );
    wp_enqueue_style( 'mycatalog-slick-style-theme', get_template_directory_uri() . '/src/css/slick-theme.css', array(), false );
    wp_enqueue_script( 'mycatalog-slick-script', get_template_directory_uri() . '/src/js/libs/exception/slick.min.js', array(), false, true );
  }

  // Main
  wp_enqueue_style( 'mycatalog-main-css', get_template_directory_uri() . '/src/css/main.css', array(), false );
  wp_enqueue_script( 'mycatalog-index-js', get_template_directory_uri() . '/src/js/index.js', array(), false, true );
  wp_localize_script( 'mycatalog-index-js', 'wp_data', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'is_rtl' => is_rtl(),
    'lang' => ICL_LANGUAGE_CODE
  ] );

}
add_action( 'wp_enqueue_scripts', 'mycatalog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
  require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Add attribute to script
 */
add_filter('script_loader_tag', 'add_type_attribute' , 10, 3);
function add_type_attribute($tag, $handle, $src) {
  if ( 'mycatalog-index-js' !== $handle ) {
    return $tag;
  }
  $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
  return $tag;
}

/**
 * Ajax products search
 */
add_action( 'wp_ajax_products_search', 'ajax_get_products' );
add_action( 'wp_ajax_nopriv_products_search', 'ajax_get_products' );

function ajax_get_products () {
  $query = $_POST['query'];
  $category = $_POST['category'];
  $html = '';

  $args = [
    'post_type' => 'product',
    'order' => 'DESC',
    'orderby' => 'date',
    's' => $query,
    'product_cat' => $category
  ];

  if ( $query == '' ) {
    $args['posts_per_page'] = 12;
  }

  $products_loop = new WP_Query($args);

  while ( $products_loop -> have_posts() ) {
    $products_loop -> the_post();
    $product = wc_get_product( get_the_ID() );
    $currency = get_woocommerce_currency_symbol();
    $is_sale = $product -> get_sale_price() != '';

    $html .= '<div class="c-product-item fade-in">';
      $html .= '<img class="c-product-item__image" src="' . get_the_post_thumbnail_url() . '">';
      $html .= '<div class="c-product-item__footer">';
        $html .= '<div class="c-product-item__category">' . $product -> get_categories() . '</div>';
        $html .= '<h3 class="c-product-item__name">' . $product -> get_name() . '</h3>';

        if ( $is_sale ):
        $html .= '<p class="c-product-item__price"><span class="crossed">' . $currency . $product -> get_regular_price() . '</span>' . $currency . $product -> get_sale_price() . '</p>';
        else:
        $html .= '<p class="c-product-item__price">' . $currency . $product -> get_regular_price() . '</p>';
        endif;

      $html .= '</div>';
      $html .= '<a class="c-product-item__link" href="' . get_the_permalink() . '"></a>';
      if ( $is_sale ) {
        $html .= '<div class="sale-circle is-top-right"><span>' .  __('%', 'mycatalog') . '</span></div>';
      }
    $html .= '</div>';
  }

  wp_reset_postdata();
  echo json_encode([
    'status' => 'success',
    'body' => $html
  ]);
  wp_die();
}

/**
 * Ajax get search hints
 */
add_action( 'wp_ajax_get_search_hints', 'get_search_hints' );
add_action( 'wp_ajax_nopriv_get_search_hints', 'get_search_hints' );
function get_search_hints () {
  $html = '';
  $args = [
    'post_type' => 'product',
    'order' => 'DESC',
    'orderby' => 'date',
    's' => $_POST['query'],
    'product_cat' => $_POST['category']
  ];

  $products = new WP_Query($args);

  if ( !$products -> have_posts() ) {
    echo json_encode([
    'body' => "<li class='is-disabled'>" . __('No such products', 'mycatalog') . "</li>"
    ]);
    wp_die();
  }

  while ( $products -> have_posts() ) {
    $products -> the_post();
    $html .= "<li>" . get_the_title() . "</li>";
  }
  wp_reset_postdata();

  echo json_encode([
    'body' => $html
  ]);
  wp_die();
}

/**
 * Get all products categories
 */
function get_products_categories () {
  $terms = get_terms(['texonomy' => 'product_cat']);
  $categories = [];

  foreach ($terms as $key => $term) {
    $categories[$key]['name'] = $term -> name;
    $categories[$key]['slug'] = $term -> slug;
    $categories[$key]['id'] = $term -> term_id;
  }

  return $categories;
}

/**
 * Get list of franchise pages
 */
function get_franchise_pages () {
  $query = new WP_Query([
    'post_type' => 'page',
    'meta_query' => [
      [
        'key' => '_wp_page_template',
        'value' => 'templates/franchise.php'
      ]
    ]
  ]);
  $pages = [];
  $count = 0;

  while ( $query -> have_posts() ) {
    $query -> the_post();
    $pages[$count]['name'] = get_the_title();
    $pages[$count]['link'] = get_the_permalink();
    $count ++;
  }

  wp_reset_postdata();
  return $pages;
}

/**
 * Send contact form
 */
add_action( 'wp_ajax_send_contact_form', 'send_contact_form' );
add_action( 'wp_ajax_nopriv_send_contact_form', 'send_contact_form' );
function send_contact_form () {
  $files = [];
  $attachments = [];
  $message_body = "Full name: " . $_POST['name'] . "\r\n";
  $headers = [
    'from' => 'mycatalog@gmail.com'
  ];

  $response['response']=1;
  $response['errors']['email']=1;
  $response['errors']['phone']=1;

  if ( isset($_POST['email']) ) {
    $message_body .= "Email: " . $_POST['email'] . "\r\n";
    if(!preg_match( '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $_POST['email'] )){
      $response['response']=0;
      $response['errors']['email']=0;
    }
  }

  if ( isset($_POST['company']) ) {
    $message_body .= "Company: " . $_POST['company'] . "\r\n";
  }

  if ( isset($_POST['position']) ) {
    $message_body .= "Position in company: " . $_POST['position'] . "\r\n";
  }

  if ( isset($_POST['phone']) ) {
    $message_body .= "Phone: " . $_POST['phone'] . "\r\n";
    if(!preg_match( '/(^\+?[0-9]{10,15}$)/', $_POST['phone'] )){
      $response['response']=0;
      $response['errors']['phone']=0;
    }
  }

  if ( isset($_POST['links']) ) {
    foreach($_POST['links'] as $key => $value)
    {
      $message_body .= "Web resource: " . $_POST['links'][$key] . "\r\n";
    }
  }

  if ( isset($_POST['message']) ) {
    $message_body .= "Message: " . $_POST['message'] . "\r\n";
  }

  if ( isset($_FILES['files']) ) {
    foreach ($_FILES['files']['name'] as $key => $value) {
      $file = [
        'name' => $_FILES['files']['name'][$key],
        'type' => $_FILES['files']['type'][$key],
        'tmp_name' => $_FILES['files']['tmp_name'][$key],
        'error' => $_FILES['files']['error'][$key],
        'size' => $_FILES['files']['size'][$key]
      ];
      $files[] = wp_handle_upload($file, ['test_form' => false]);
    }
  }

  foreach ($files as $file) {
    $attachments[] = $file['file'];
  }

  if(isset($response['response']) && $response['response']==0){
    echo json_encode(['status' => $response]);
    wp_die();
  }


  // $mail_sent = wp_mail(get_option('admin_email'), 'My Catalog form', $message_body, $headers, $attachments);
  $mail_sent = wp_mail(get_field('contact_email', 'option'), 'My Catalog form', $message_body, $headers, $attachments);
  echo json_encode(['status' => $mail_sent, 'files' => $files]);
  wp_die();
}

/**
 * Ajax remove product from cart
 */
add_action( 'wp_ajax_product_remove', 'ajax_product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', 'ajax_product_remove' );

function ajax_product_remove () {
  ob_start();

  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] ) {
      WC()->cart->remove_cart_item($cart_item_key);
    }
  }

  WC()->cart->calculate_totals();
  WC()->cart->maybe_set_cart_cookies();

  woocommerce_mini_cart();

  $mini_cart = ob_get_clean();

  // Fragments and mini cart are returned
  $data = [
    'status' => 'success',
    'fragments' => apply_filters('woocommerce_add_to_cart_fragments', [
      'cart_count' => WC() -> cart -> cart_contents_count,
      'empty_message_fragment' => '<p class="mini-cart__empty-message">' .  __('No products in the cart.', 'mycatalog') . '</p>',
      '.mini-cart .mini-cart__count' => '<span class="mini-cart__count">' . WC() -> cart -> cart_contents_count .'</span>',
      '.mini-cart .mini-cart__total' => '<p class="mini-cart__total woocommerce-mini-cart__total total">' . '<strong>' . __('Subtotal', 'mycatalog') . ':</strong> ' . WC() -> cart -> get_cart_subtotal() . '</p>',
    ]),
    'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
  ];

  wp_send_json( $data );

  wp_die();
}

/**
 * Ajax get cart items
 */
add_action( 'wp_ajax_get_cart_items', 'ajax_get_cart_items' );
add_action( 'wp_ajax_nopriv_get_cart_items', 'ajax_get_cart_items' );

function ajax_get_cart_items () {
  $cart_items = '';
  ob_start();

  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
      $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
      $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
      $thumbnail_url     = get_the_post_thumbnail_url($product_id);
      $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
      $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

      $cart_items .= '<li class="mini-cart-item woocommerce-mini-cart-item' . esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ) . '">';
        $cart_items .= '<a class="mini-cart-item__image" href="' . $product_permalink . '"><img src="' . $thumbnail_url . '"></a>';
        $cart_items .= '<div class="mini-cart-item__info">';
          $cart_items .= '<span class="mini-cart-item__name">' . $product_name . '</span>';
          $cart_items .= wc_get_formatted_cart_item_data( $cart_item );
          $cart_items .= apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="mini-cart-item__quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key );
        $cart_items .= '</div>';
        $cart_items .= '<a href="#" class="mini-cart-item__remove" aria-label="' . esc_attr__( 'Remove this item', 'woocommerce' ) . '" data-product_id="' . esc_attr( $product_id ) . '" data-cart_item_key="' . esc_attr( $cart_item_key ) . '" data-product_sku="' . esc_attr( $_product->get_sku() ) . '"></a>';
      $cart_items .= '</li>';
    }
  }

  WC()->cart->calculate_totals();
  WC()->cart->maybe_set_cart_cookies();

  woocommerce_mini_cart();

  $mini_cart = ob_get_clean();

  // Fragments and mini cart are returned
  $data = [
    'status' => 'success',
    'fragments' => apply_filters('woocommerce_add_to_cart_fragments', [
      'cart_count' => WC() -> cart -> cart_contents_count,
      'cart_items' => $cart_items,
      'empty_message_fragment' => '<p class="mini-cart__empty-message">' .  __('No products in the cart.', 'mycatalog') . '</p>',
      '.mini-cart .mini-cart__count' => '<span class="mini-cart__count">' . WC() -> cart -> cart_contents_count .'</span>',
      '.mini-cart .mini-cart__total' => '<p class="mini-cart__total woocommerce-mini-cart__total total">' . '<strong>' . __('Subtotal', 'mycatalog') . ':</strong> ' . WC() -> cart -> get_cart_subtotal() . '</p>',
    ]),
    'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
  ];

  wp_send_json( $data );

  wp_die();
}

/**
 * Add form label filter
 */
// define the woocommerce_form_field_args callback
// add_filter( 'woocommerce_form_field_args', 'filter_woocommerce_form_field_args', 10, 3 );
// function filter_woocommerce_form_field_args( $args, $key, $value ) {
//   $args['label'] = '<span>' . $args['label'] . '</span>';
//   return $args;
// }

/**
 * Change limit of related products
 */
function tm_related_products_limit() {
    global $product;

    $orderby = '';
    $columns = 4;
    $related = $product->get_related( 4 );
    $args = array(
        'post_type'           => 'product',
        'no_found_rows'       => 1,
        'posts_per_page'      => 4,
        'ignore_sticky_posts' => 1,
        'orderby'             => $orderby,
        'post__in'            => $related,
        'post__not_in'        => array($product->id)
    );
    return $args;
}
add_filter( 'woocommerce_related_products_args', 'tm_related_products_limit' );

/**
 * Subscribe to newsletter
 */
add_action( 'wp_ajax_subscribe_to_newsletter', 'subscribe_to_newsletter' );
add_action( 'wp_ajax_nopriv_subscribe_to_newsletter', 'subscribe_to_newsletter' );

function subscribe_to_newsletter () {
  $resp = [
    'success' => true,
    'message' => __('Thanks for subscription!', 'mycatalog')
  ];
  $res = TNP::subscribe( ['email' => $_POST['email']] );

  if ( is_wp_error( $res ) ) {
    $resp['success'] = false;
    $resp['message'] = $res -> get_error_message();
  }

  echo json_encode( $resp );
  wp_die();
}

/**
 * Brief form
 */
add_action( 'wp_ajax_brief_popup_submit', 'brief_popup_submit' );
add_action( 'wp_ajax_nopriv_brief_popup_submit', 'brief_popup_submit' );
function brief_popup_submit () {
  $message = '';
  $resp = [
    'success' => true,
    'message' => [
      'header' => __('Thank you!', 'mycatalog')
    ]
  ];

  if ( isset($_POST['markets']) ) {
    $message .= 'The markets I want to distribute: ' . $_POST['markets'] . "\r\n";
  }

  if ( isset($_POST['channels']) ) {
    $message .= "The channels I'm going to use for distribution: " . implode(', ', $_POST['channels']) . "\r\n";
  }

  if ( isset($_POST['information']) ) {
    $message .= "I'd like to receive this information: " . $_POST['information'] . "\r\n";
  }

  if ( isset($_POST['goals']) ) {
    $message .= "I want to: " . implode(', ', $_POST['goals']) . "\r\n";
  }

  // $mail_sent = wp_mail(get_option('admin_email'), 'My Catalog Brief Form', $message, ['From: My Catalog']);
  $mail_sent = wp_mail(get_field('contact_email', 'option'), 'My Catalog Brief Form', $message, ['From: My Catalog']);

  echo json_encode( $resp );

  wp_die();
}

/**
 * Options pages
 */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'My Catalog settings',
		'menu_title'	=> 'Theme settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
    'icon_url'    => 'dashicons-admin-appearance',
		'redirect'		=> false
	));

}

/**
 * Zip Code validation for checkout
 */


add_filter( 'woocommerce_checkout_fields', 'delete_default_validate_checkout' );
 
function delete_default_validate_checkout( $fields ){
 
  unset( $fields['billing']['billing_postcode']['validate']);
  unset( $fields['billing']['billing_phone']['validate']);
	return $fields;
 
}


add_action( 'woocommerce_after_checkout_validation', 'checkout_validate_checkout', 10, 2);
 
function checkout_validate_checkout( $fields, $errors ){
  if(!preg_match( '/(^\d{5}$)|(^[A-z0-9]{6}$)|(^[A-z0-9]{3}\s[A-z0-9]{3}$)|(^\d{5}-\d{4}$)|(^[A-z0-9]{3,10}$)/', $fields[ 'billing_postcode' ] )){
    $errors->add( 'validation', '<strong>Billing Postcode / ZIP</strong> is a required field.' );
  }
  if(!preg_match( '/(^\+?[0-9]{10,15}$)/', $fields[ 'billing_phone' ] )){
    $errors->add( 'validation', '<strong>Billing Phone</strong> is a required field.' );
  }
}