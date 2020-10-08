<?php

namespace SW_WAPF_PRO\Includes\Controllers {

    use SW_WAPF_PRO\Includes\Classes\Woocommerce_Service;

    if (!defined('ABSPATH')) {
        die;
    }

    class Public_Controller {

        public function __construct()
        {

            if(!$this->is_woocommerce_active())
                return;

            add_action( 'wp_enqueue_scripts', array($this, 'register_assets'), 5000 );

	        add_filter('wc_stripe_hide_payment_request_on_product_page','__return_true',10,2);

            new Product_Controller();

        }

        public function register_assets() {

            $url =  trailingslashit(wapf_get_setting('url')) . 'assets/';
            $version = wapf_get_setting('version');

            wp_enqueue_style('wapf-frontend', $url . 'css/frontend.min.css', array(), $version);
            wp_enqueue_script('wapf-frontend-js', $url . 'js/frontend.min.js', array('jquery'), $version, true);

            $script_vars = array(
            	'ajax'              =>  admin_url('admin-ajax.php'),
                'page_type'         => Woocommerce_Service::get_current_page_type(),
                'display_options'   => Woocommerce_Service::get_price_display_options(),
	            'slider_support'    => get_theme_support('wc-product-gallery-slider')
            );

            wp_localize_Script('wapf-frontend-js', 'wapf_config', $script_vars);

        }

        public function is_woocommerce_active()
        {
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                return true;
            }
            if (is_multisite()) {
                $plugins = get_site_option('active_sitewide_plugins');
                if (isset($plugins['woocommerce/woocommerce.php']))
                    return true;
            }
            return false;
        }

    }
}