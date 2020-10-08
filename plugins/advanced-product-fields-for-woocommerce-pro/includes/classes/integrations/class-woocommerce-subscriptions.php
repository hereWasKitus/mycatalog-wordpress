<?php

namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	class WooCommerce_Subscriptions{

		public function __construct() {
			add_filter('wapf/admin/allowed_product_types',      array($this, 'allowed_product_types'));

            add_action('wp_footer',                             array($this, 'add_javascript'),100);
		}

		public function allowed_product_types($product_types) {
			$product_types[] = 'subscription';
			$product_types[] = 'variable-subscription';
			return $product_types;
		}

		public function add_javascript() {
			?>
			<script>
                WAPF.Filter.add('wapf/pricing/base',function(price, data) {
                    if(WAPF.Util.currentProductType(data.parent) === 'variable-subscription') {
                        var v = WAPF.Util.selectedVariation(data.parent);
                        if(v)
                            price = v.display_price;
                    }
                    return price;
                });
			</script>
			<?php
		}

	}

}