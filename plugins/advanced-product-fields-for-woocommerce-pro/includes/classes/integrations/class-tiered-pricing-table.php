<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	use TierPricingTable\PriceManager;

	class Tiered_Pricing_Table{

		public function __construct() {
			add_action('wp_footer',         array($this, 'add_javascript'),100);
			add_filter('wapf/pricing/base', array($this, 'get_base_price'),10,3);
		}

		public function add_javascript() {
			?>
			<script>
                WAPF.Filter.add('wapf/pricing/base',function(price, data) {
                    if(data.parent.find('.price-rule-active').length)
                        return data.parent.find('.price-rule-active').data('price-rules-price');
                    return price;
                });
			</script>
			<?php
		}

		public function get_base_price($price, $product, $quantity = 1) {
		    $p = PriceManager::getPriceByRules($quantity,$product->get_id());
		    return $p ? $p : $price;
		}

	}

}