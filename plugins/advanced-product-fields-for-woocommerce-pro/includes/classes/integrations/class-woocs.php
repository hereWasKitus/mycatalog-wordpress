<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	use SW_WAPF_PRO\Includes\Classes\Cart;

	class Woocs
    {
        public function __construct($mode = 'public') {
	        add_action('woocommerce_before_calculate_totals',   array($this, 'recalculate_pricing'),9);

	        add_filter('wapf/pricing/addon',                    array($this,'convert_addon_price'), 10, 4);

	        add_filter('wapf/html/pricing_hint/amount',         array($this,'convert_pricing_hint'),10,3);

	        add_filter('wapf/html/product_totals/data',         array($this,'add_raw_price'),10,2);

	        add_filter('wapf/pricing/base',                     array($this,'convert_back'),10,3);

	        add_action('wp_footer',                             array($this,'add_footer_script'),100);

	        add_filter('wapf/pricing/mini_cart_item_price',     array($this,'change_mini_cart_item_price'),10,3);

        }

        public function change_mini_cart_item_price($price,$cart_item,$cart_item_key) {
	        if(!empty($cart_item['wapf_item_price']) && wp_doing_ajax() ) {

	            if(!$this->is_default_currency()) {
		            $price = get_option('woocs_is_multiple_allowed') != 1 ? $price : $this->convert_to_current_currency($price);
	            }
	        }

	        return $price;
        }

        public function convert_back($price) {
	        if(!$this->is_default_currency() && $this->price_already_converted()) {
	            global $WOOCS;
	            $rate = $this->get_current_currency_rate();

		        return $WOOCS->back_convert($price,$rate,8);
	        }
	        return $price;
        }

        public function add_raw_price($data, $product) {
        	$rate = $this->get_current_currency_rate();

        	if($this->is_default_currency())
        	    $data['woocs-price'] = $data['product-price'];
        	else {
        	    $data['woocs-price'] = $this->price_already_converted() ? $this->convert_back($data['product-price']) : $data['product-price']; 
            }

        	return $data;
        }

        public function add_footer_script() {

        	if($this->is_default_currency())
        		return;
        	?>
	        <script>
		        var wapf_woocs_rate = <?php echo $this->get_current_currency_rate(); ?>;

		        jQuery(document).on('wapf/pricing',function(e,productTotal,optionsTotal,total,$parent){
		            var rawBase = jQuery('.wapf-product-totals').data('woocs-price') * WAPF.Util.selectedQuantity($parent);
		            jQuery('.wapf-product-total').html(WAPF.Util.formatMoney(rawBase*wapf_woocs_rate,window.wapf_config.display_options));
		            jQuery('.wapf-options-total').html(WAPF.Util.formatMoney(optionsTotal*wapf_woocs_rate,window.wapf_config.display_options));
		            jQuery('.wapf-grand-total').html(WAPF.Util.formatMoney((optionsTotal+rawBase)*wapf_woocs_rate,window.wapf_config.display_options));
		        });

		        WAPF.Filter.add('wapf/fx/hint',function(price){
		            return price*wapf_woocs_rate;
                });
	        </script>
			<?php
        }

        public function convert_pricing_hint($amount,$product,$type) {
	        if(!$this->is_default_currency() && !$this->product_has_fixed_price($product)) {
		        $rate = $this->get_current_currency_rate();
		        return (float) $amount*$rate;
	        }

	        return $amount;
        }

        public function convert_product_price($price, $product){

        	if(!$this->is_default_currency() && !$this->price_already_converted()) {
		        return $this->convert_to_current_currency($price);
	        }

	        return $price;
        }



        public function convert_addon_price($amount, $product, $type, $for_page) {

	        return $amount;
        }

        public function recalculate_pricing($cart_obj) {

	        foreach( $cart_obj->get_cart() as $key=>$item ) {
		        $cart_item = WC()->cart->cart_contents[$key];
		        if(empty($cart_item['wapf']))
		        	continue;
		        $pricing = Cart::calculate_cart_item_options_total($cart_item);

		        if($pricing !== false)
			        WC()->cart->cart_contents[$key]['wapf_item_price'] = $pricing;

	        }
        }

		private function price_already_converted() {
			if(get_option('woocs_is_multiple_allowed') != 1)
				return false;
			return true;
		}

		private function is_default_currency($curr = false) {
			global $WOOCS;
			if(!$curr)
				$curr = $WOOCS->current_currency;

			return strtolower($curr) === strtolower($WOOCS->default_currency);
		}

		private function product_has_fixed_price($product) {

			if(get_option('woocs_is_fixed_enabled') != 1)
				return false;

			global $WOOCS;

			$curr = $WOOCS->current_currency;

			$regular_price = get_post_meta( $product->get_id(), '_woocs_regular_price_' . $curr, true);
			if(!empty($regular_price) && floatval($regular_price) > 0)
				return true;

			$sale_price = get_post_meta( $product->get_id(), '_woocs_sale_price_' . $curr, true);
			if(!empty($sale_price) && floatval($sale_price) > 0 )
				return true;

			return false;
		}

		private function convert_to_current_currency($value) {
			return apply_filters('woocs_exchange_value', $value);
		}

		private function get_current_currency_rate() {
			global $WOOCS;
			$currencies = $WOOCS->get_currencies();
        	return floatval($currencies[$WOOCS->current_currency]['rate']);
		}


    }
}