<?php

namespace SW_WAPF_PRO\Includes\Controllers {

    if (!defined('ABSPATH')) {
        die;
    }

    class Integrations_Controller
    {

        private $available_integrations = array(
	        'Barn2\Plugin\WC_Quick_View_Pro\Quick_View_Plugin'  => 'Quickview',
	        'WC_Product_Table_Plugin'                           => 'Product_Table',
	        'TierPricingTable\TierPricingTablePlugin'           => 'Tiered_Pricing_Table',
	        'WOOCS'                                             => 'Woocs',
	        'YITH_Request_Quote'                                => 'Yith_RAQ',
	        'WC_Subscriptions'                                  => 'WooCommerce_Subscriptions',
        );

        private $available_themes = array(
        	'Woodmart' => 'Woodmart',
        	'Flatsome' => 'Flatsome'
        );

        public function __construct()
        {
        	add_action('plugins_loaded',    array($this,'add_integrations'),50);
        }

        public function add_integrations() {

	        foreach ($this->available_integrations as $integration => $class) {
		        if(class_exists($integration)) {
		        	$n = 'SW_WAPF_PRO\\Includes\\Classes\\Integrations\\' . $class;
			        new $n();
		        }
	        }

	        $theme = wp_get_theme();
			$parent_theme = $theme->parent() ? $theme->parent()->Name  : '';

	        if($theme->exists()) {
		        foreach($this->available_themes as $theme_name => $class) {
			        if($theme->Name === $theme_name || $parent_theme === $theme_name ) {
				        $n = 'SW_WAPF_PRO\\Includes\\Classes\\Integrations\\' . $class;
				        new $n();
			        }
		        }
	        }

        }


    }
}