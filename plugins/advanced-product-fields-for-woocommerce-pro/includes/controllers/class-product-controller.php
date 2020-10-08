<?php

namespace SW_WAPF_PRO\Includes\Controllers {

	use SW_WAPF_PRO\Includes\Classes\Cache;
	use SW_WAPF_PRO\Includes\Classes\Cart;
	use SW_WAPF_PRO\Includes\Classes\Enumerable;
    use SW_WAPF_PRO\Includes\Classes\Field_Groups;
	use SW_WAPF_PRO\Includes\Classes\File_Upload;
	use SW_WAPF_PRO\Includes\Classes\Helper;
	use SW_WAPF_PRO\Includes\Classes\Html;
	use SW_WAPF_PRO\Includes\Models\Field;

	if (!defined('ABSPATH')) {
        die;
    }

    class Product_Controller
    {

    	public $show_fieldgroup = false;

        public function __construct()
        {
            add_action('woocommerce_before_add_to_cart_button',             array($this, 'display_field_groups'));

            add_action('wp_footer',                                         array($this, 'remove_image_update_function'), 999999);

            add_filter('woocommerce_add_to_cart_validation',                array($this, 'validate_cart_data'), 10, 4);

	        add_filter('woocommerce_add_cart_item_data',                    array($this, 'add_fields_to_cart_item' ), 10, 4);

            add_action('woocommerce_add_to_cart',                           array($this, 'split_cart_items_by_quantity'), 10, 6);

	        add_action('woocommerce_add_to_cart',                           array($this, 'calculate_cart_item_price'), 10, 6);

	        add_filter('woocommerce_update_cart_action_cart_updated',       array($this, 'recalculate_cart_item_price'), 10, 1);

            add_action('woocommerce_before_calculate_totals',               array($this, 'add_prices_to_cart_item'));

            add_filter('woocommerce_get_item_data',                         array($this, 'display_fields_on_cart_and_checkout'),10, 2);

	        add_filter('woocommerce_cart_item_price',                       array($this, 'mini_cart_display_product_price'),10,3);

            add_action('woocommerce_checkout_create_order_line_item',       array($this, 'add_meta_to_order_item'),20, 4);

	        add_filter('woocommerce_order_item_get_formatted_meta_data',    array($this,'hide_fields_in_order'),10,2);

            add_filter('woocommerce_product_add_to_cart_text',              array($this, 'change_add_to_cart_text'), 10, 2);

            add_filter('woocommerce_product_supports',                      array($this, 'check_product_support'), 10, 3);

            add_filter('woocommerce_product_add_to_cart_url',               array($this, 'set_add_to_cart_url'), 10, 2);

			add_filter('woocommerce_single_product_image_thumbnail_html',   array($this,'add_attachment_id_to_html'), 10, 2 );

	        add_filter('woocommerce_order_again_cart_item_data',            array($this, 'order_again_cart_item_data'), 10, 3);
	        add_filter('woocommerce_add_order_again_cart_item',             array($this, 'calculate_prices_for_ordered_again_item'), 10, 2);

	        add_action('wp_head',                                           array($this, 'add_lookup_tables'));
	        add_action('wp_footer',                                         array($this, 'add_lookup_tables_code'), 30);
        }

        public function set_add_to_cart_url($url, $product) {
            if($product->get_type() === 'external')
                return $url;

            if(Field_Groups::product_has_field_group($product))
                return $product->get_permalink();

            return $url;
        }

        public function check_product_support($support, $feature, $product)
        {
            if($feature === 'ajax_add_to_cart' && Field_Groups::product_has_field_group($product) )
                $support = false;

            return $support;
        }

        public function change_add_to_cart_text($text, $product) {
            if(!$product->is_in_stock())
                return $text;

            if (in_array($product->get_type(), array('grouped', 'external')))
                return $text;

            if(is_product())
            	return $text;

            if( Field_Groups::product_has_field_group($product) )
                return esc_html(get_option('wapf_add_to_cart_text',__('Select options','sw-wapf')));

            return $text;

        }

        public function validate_cart_data($passed, $product_id, $qty, $variation_id = null) {

            if(!isset($_REQUEST['wapf_field_groups']))
                return $passed;

	        $field_groups = Field_Groups::get_by_ids(explode(',',sanitize_text_field($_REQUEST['wapf_field_groups'])));

	        $files = File_Upload::create_uploaded_file_array();
	        Cache::set_files($files); 

            $validation = Cart::validate_cart_data($field_groups,$passed, $product_id, $qty, $variation_id);

            if(is_string($validation)) {
	            wc_add_notice(esc_html($validation), 'error');
	            return false;
            }

            if($passed && !empty($files)) {

            	$files_upload_result = File_Upload::handle_files_array($field_groups,$files);
				if(is_string($files_upload_result)) {
					wc_add_notice(esc_html($files_upload_result), 'error');
					return false;
				}
	            Cache::set_files($files_upload_result);

            }

            return $passed;

        }

        public function add_fields_to_cart_item($cart_item_data, $product_id, $variation_id, $quantity = 1) {

	        if( isset($cart_item_data['wapf']) || !isset($_REQUEST['wapf_field_groups']))
		        return $cart_item_data;

	        $field_group_ids = explode(',', sanitize_text_field($_REQUEST['wapf_field_groups']));
	        $field_groups = Field_Groups::get_by_ids($field_group_ids);
	        $fields = Enumerable::from($field_groups)->merge(function($x){return $x->fields; })->toArray();

			$files = Cache::get_files();

            $wapf_data = array();
			$clones = array();

            foreach($fields as $field) {
	            $key = 'field_' . $field->id;

            	if( ($field->type === 'file' && isset($files[$key]) ) || (isset($_REQUEST['wapf']) && isset($_REQUEST['wapf'][$key])) ) {
		            $cart_field  = Cart::to_cart_item_field( $field, 0 );
		            $wapf_data[] = $cart_field;
	            }

	            if($quantity > 1) {
	            	for($i=2; $i <= $quantity ; $i++) {
	            		$key = 'field_' . $field->id . '_clone_' . $i;

	            		if( ($field->type === 'file' && isset($files[$key])) || (isset($_REQUEST['wapf']) && isset($_REQUEST['wapf'][$key])) ) {
				            $cart_field = Cart::to_cart_item_field( $field, $i );
				            $clones[ $i - 2 ][] = $cart_field;
			            }
		            }
	            }

            }

	        $sorted = $wapf_data;
	        $sorted = Enumerable::from($sorted)->orderBy(function($x) { return $x['id']; })->toArray();
	        $wapf_unique_key = $this->generate_cart_item_id($product_id,$variation_id,array_values($sorted));

	        if(!empty($clones))
		        Cache::add_clone($wapf_unique_key, $clones);

	        if(!empty($wapf_data)) {
		        $cart_item_data['wapf'] = $wapf_data;
		        $cart_item_data['wapf_key'] = $wapf_unique_key;
		        $cart_item_data['wapf_field_groups'] = $field_group_ids;
		        $cart_item_data['wapf_clone'] = 0;
	        }

	        return $cart_item_data;

        }

	    public function split_cart_items_by_quantity($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {

		    if($quantity === 1) return;

		    if(empty($cart_item_data['wapf']) || !is_array($cart_item_data['wapf']) )
			    return;

		    $cart_data_clones = Cache::get_clone($cart_item_data['wapf_key']);

		    if(!$cart_data_clones || empty($cart_data_clones))
			    return;

		    $fingerprint = $cart_item_data['wapf_key'];

		    $main_item_qty = isset(WC()->cart->cart_contents[$cart_item_key]['quantity']) ? WC()->cart->cart_contents[$cart_item_key]['quantity'] : 1;

		    $field_groups = Field_Groups::get_by_ids($cart_item_data['wapf_field_groups']);
		    $fields = Enumerable::from($field_groups)->merge(function($x){return $x->fields; })->toArray();
		    for($i=0; $i < count($cart_data_clones); $i++) {
			    $clone_group = $cart_data_clones[$i];
			    $complete_clone  = array();

			    foreach ($fields as $field) {
				    $field_in_clone = Enumerable::from($clone_group)->firstOrDefault(function($clone_field) use ($field) {
					    return $field->id === $clone_field['id'];
				    });
				    if($field_in_clone)
					    $complete_clone[] = $field_in_clone;
				    else {
					    $field_in_parent = Enumerable::from($cart_item_data['wapf'])->firstOrDefault(function($parent_field) use($field) {
						    return $field->id === $parent_field['id'];
					    });
					    if($field_in_parent)
						    $complete_clone[] = $field_in_parent;
				    }

			    }

			    $ordered = array_values( Enumerable::from( $complete_clone )->orderBy( function ( $x ) {
				    return $x['id'];
			    } )->toArray() );

			    $clone_fingerprint = $this->generate_cart_item_id( $product_id, $variation_id, $ordered );

			    if ( $clone_fingerprint !== $fingerprint ) {

				    $content = WC()->cart->cart_contents;
				    $is_in_cart = false;
				    foreach ( $content as $key => $item_in_cart ) {
					    if ( empty( $item_in_cart['wapf'] ) || $key === $cart_item_key )
						    continue;

					    $item_fingerprint = $item_in_cart['wapf_key'];

					    if ( $item_fingerprint === $clone_fingerprint ) {
						    $old_qty = empty( $item_in_cart['quantity'] ) ? 1 : $item_in_cart['quantity'];
						    WC()->cart->set_quantity( $key, $old_qty + 1 );
						    $is_in_cart = true;
						    break;
					    }
				    }

				    if ( ! $is_in_cart ) {

					    $new_cart_item_data = array(
						    'wapf'              => $complete_clone,
						    'wapf_key'          => $clone_fingerprint,
						    'wapf_field_groups' => $cart_item_data['wapf_field_groups'],
						    'wapf_clone'        => $i+2,
					    );

					    remove_action('woocommerce_add_to_cart', array($this, 'split_cart_items_by_quantity'));
					    remove_action('woocommerce_add_cart_item_data', array($this, 'add_fields_to_cart_item'));

					    WC()->cart->add_to_cart( $product_id, 1, $variation_id, $variation, $new_cart_item_data );

					    add_action('woocommerce_add_to_cart', array($this, 'split_cart_items_by_quantity'));
					    add_action('woocommerce_add_cart_item_data', array($this, 'add_fields_to_cart_item'));
				    }

				    $main_item_qty = $main_item_qty - 1;
				    if($main_item_qty < 1)
					    $main_item_qty = 1;
				    WC()->cart->set_quantity( $cart_item_key, $main_item_qty );

			    }
		    }

	    }

	    public function calculate_cart_item_price($cart_item_key,$product_id,$quantity,$variation_id,$variation,$cart_item_data) {
	        if(empty($cart_item_data['wapf']))
		        return;

	        $cart_item = WC()->cart->cart_contents[$cart_item_key];

	        $pricing = Cart::calculate_cart_item_options_total($cart_item);

		    if($pricing !== false)
		        WC()->cart->cart_contents[ $cart_item_key ]['wapf_item_price'] = $pricing;
        }

	    public function recalculate_cart_item_price($cart_updated) {

		    if(!$cart_updated)
			    return $cart_updated;

		    $cart = WC()->cart->get_cart();

		    foreach( $cart as $key=>$item ) {
		    	if(!empty($item['wapf'])) {
				    $pricing = Cart::calculate_cart_item_options_total($item);
				    if($pricing !== false)
				        WC()->cart->cart_contents[$key]['wapf_item_price'] = $pricing;
			    }
		    }

		    return $cart_updated;
	    }

	    public function add_prices_to_cart_item($cart_obj) {

		    if (is_admin() && ! defined('DOING_AJAX'))
			    return;

		    foreach( $cart_obj->get_cart() as $key=>$item ) {

				if(isset($item['wapf_item_price'])) {

					$item_price = floatval($item['wapf_item_price']['base']) + floatval( $item['wapf_item_price']['options_total'] );
					if($item_price < 0)
						$item_price = 0;

					$item['data']->set_price( $item_price );

				}
		    }
        }

        public function display_fields_on_cart_and_checkout($item_data, $cart_item) {

            if(empty($cart_item['wapf']) || !is_array($cart_item['wapf']) )
                return $item_data;

            if (!is_array($item_data))
                $item_data = array();

            $is_cart = is_cart();
            $is_checkout = is_checkout();

            if(
	            ($is_cart && get_option('wapf_settings_show_in_cart','yes') === 'yes') || 
	            ($is_checkout && get_option('wapf_settings_show_in_checkout','yes') === 'yes') || 
	            (!$is_checkout && !$is_cart && get_option('wapf_settings_show_in_mini_cart','no') === 'yes' ) 
            ) {

	            foreach($cart_item['wapf'] as $field) {

                	if(!isset($field['values']))
                		continue;

                	if($is_cart && isset($field['hide_cart']) && $field['hide_cart'] )
                		continue;

		            if($is_checkout && isset($field['hide_checkout']) && $field['hide_checkout'])
			            continue;

                    if(Enumerable::from($field['values'])->any(function($x) use($cart_item){ return !empty($x['label']);})) {

	                    $item_data[] = array(
		                    'key'   => $field['label'],
		                    'value' => Enumerable::from( $field['values'] )->join( function ( $x ) use($cart_item, $field) {

			                    if ( $x['price_type'] !== 'none' && !empty($x['price']) ) {

				                    $v = isset($x['slug']) ? $x['label'] : $field['raw'];

				                    if(isset($cart_item['wapf_item_price']['options'][$field['id']][$v])) {

				                    	$pricing_hint = $cart_item['wapf_item_price']['options'][$field['id']][$v]['pricing_hint'];

					                    return sprintf(
						                    '%s %s',
						                    $x['label'],
						                    $pricing_hint
					                    );
				                    }

			                    }

			                    return $x['label'];
		                    }, ', ' )
	                    );
                    }

                }
            }

            return apply_filters('wapf/cart/item_data',$item_data, $cart_item);

        }

        public function mini_cart_display_product_price($price, $cart_item, $cart_item_key) {
		    if(!empty($cart_item['wapf_item_price']) && wp_doing_ajax() ) {
			    $price = floatval($cart_item['wapf_item_price']['base']) + floatval( $cart_item['wapf_item_price']['options_total'] );
			    if($price < 0) $price = 0;
			    $price = Helper::maybe_add_tax($cart_item['data'],$price,'cart');
			    $price = apply_filters('wapf/pricing/mini_cart_item_price',$price,$cart_item,$cart_item_key);
			    $price = wc_price($price);
		    }

	        return $price;
        }

	    #region Frontend
	    public function display_field_groups() {

		    global $product;
		    if(!$product)
			    return;

		    if(in_array($product->get_type(),array('grouped','external')))
			    return;

		    $field_groups = Field_Groups::get_valid_field_groups('product');

		    $product_field_group = get_post_meta($product->get_id(),'_wapf_fieldgroup', true);

		    if($product_field_group)
			    array_unshift($field_groups, Field_Groups::process_data($product_field_group));

		    if(empty($field_groups))
			    return;

		    $this->show_fieldgroup = true;

		    echo Html::display_field_groups($field_groups,$product);

	    }

	    public function remove_image_update_function() {
		    if(!$this->show_fieldgroup)
			    return;

		    echo '<script>jQuery(document).on(\'wapf:delete_var\',function(){if(jQuery.fn.wc_variations_image_update) jQuery.fn.wc_variations_image_update = function(){}; });</script>';
	    }

	    public function add_attachment_id_to_html($html, $attachment_id) {
		    return str_replace('<div ','<div data-wapf-att-id="'.$attachment_id.'" ',$html);
	    }
	    #endregion

	    #region Order
	    public function add_meta_to_order_item($item, $cart_item_key, $values, $order) {

		    if (empty($values['wapf']))
			    return;

		    $fields_meta = array();
			$fields_meta_settings = array();

		    for($i=0;$i<count($values['wapf']);$i++) {

		    	$field = $values['wapf'][$i];

			    if(Enumerable::from($field['values'])->any(function($x){ return !empty($x['label']);})) {

			    	$vals =  Enumerable::from( $field['values'] )->join( function ( $x ) use($item,$values,$field) {
					    if ( $x['price_type'] !== 'none' && !empty($x['price']) ) {

					    	$v = isset($x['slug']) ? $x['label'] : $field['raw'];

						    if(isset($values['wapf_item_price']['options'][$field['id']][$v])) {

							    $pricing_hint = $values['wapf_item_price']['options'][$field['id']][$v]['pricing_hint'];

							    return sprintf(
								    '%s %s',
								    $x['label'],
								    $pricing_hint
							    );

						    }

					    }
					    return $x['label'];
				    }, ', ' );

				    $item->add_meta_data(
				    	$field['label'],
						$vals
				    );

				    $fields_meta[] = array(
				        'id'        => $field['id'],
					    'label'     => $field['label'],
					    'value'     => $vals,
					    'values'    => $field['values']
				    );

				    if(isset($fields_meta_settings[$field['label']])) {
					    $fields_meta_settings[$field['label']][] = $field['hide_order'];
				    } else {
					    $fields_meta_settings[$field['label']] = array($field['hide_order']);
				    }

			    }

		    }

		    if(!empty($fields_meta))
		        $item->add_meta_data('_wapf_meta', array('fields' => $fields_meta, 'settings' => $fields_meta_settings));
	    }

	    public function hide_fields_in_order($formatted_meta,$order_item) {

		    if(Helper::is_admin_order())
			    return $formatted_meta;

		    $wapf_meta = $order_item->get_meta('_wapf_meta',true);

		    if(empty($wapf_meta) || !isset($wapf_meta['settings']))
			    return $formatted_meta;

		    $already_occured = array();

		    foreach($formatted_meta as $meta_id => $formatted) {

			    if(isset($wapf_meta['settings'][$formatted->key])) {
			    	$exists = isset($already_occured[$formatted->key]);

			    	$hide = $wapf_meta['settings'][$formatted->key][$exists ? $already_occured[$formatted->key] : 0];
				    if($hide)
					    unset($formatted_meta[$meta_id]);

				    $already_occured[$formatted->key] = $exists ? $already_occured[$formatted->key] +1 : 1;
			    }
		    }

		    return $formatted_meta;
	    }
	    #endregion

	    #region Order Again
	    public function order_again_cart_item_data($cart_item_data, $item, $order) {

		    $meta_data = $item->get_meta('_wapf_meta');

		    if(is_array($meta_data) && isset($meta_data['fields'])) {
			    $wapf = array();

			    $product_id = $item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id();
			    $groups = wapf_get_field_groups_of_product($product_id);
			    $fields = Enumerable::from($groups)->merge(function($x){return $x->fields; })->toArray();
			    foreach($meta_data['fields'] as $field_meta) {
				    $field = Enumerable::from($fields)->firstOrDefault(function($x) use($field_meta){ return $x->id === $field_meta['id'];});
				    if(!$field)
					    continue;

				    $cart_field  = Cart::to_cart_item_field( $field, 0, $field_meta['values'] );
				    $wapf[] = $cart_field;
			    }
			    if(!empty($wapf)) {
				    $cart_item_data['wapf'] = $wapf;
				    $cart_item_data['wapf_key'] = $this->generate_cart_item_id($item->get_product_id(),$item->get_variation_id(),$wapf);
				    $cart_item_data['wapf_field_groups'] = Enumerable::from($groups)->select(function($x){return $x->id;})->toArray();
				    $cart_item_data['wapf_clone'] = 0;
			    }
		    }

		    return $cart_item_data;
	    }

	    public function calculate_prices_for_ordered_again_item($cart_item, $cart_id) {
		    $pricing = Cart::calculate_cart_item_options_total($cart_item);
		    if($pricing !== false)
			    $cart_item['wapf_item_price'] = $pricing;
		    return $cart_item;
	    }
	    #endregion

	    #region Lookup tables functionality
	    public function add_lookup_tables() {
		    $tables = apply_filters( 'wapf/lookup_tables', array() );
		    if(!empty($tables)) {
			    Cache::set('lookup_tables',true);
			    echo '<script>var wapf_lookup_tables='.wp_json_encode($tables).';</script>';
		    }
	    }

	    public function add_lookup_tables_code() {

		    if(!Cache::get('lookup_tables'))
			    return;

		    Html::partial('frontend/lookup-tables');

	    }
	    #endregion

	    #region Private Helpers

	    private function generate_cart_item_id($product_id, $variation_id, $data) {

		    return md5(json_encode(array(
			    (int) $product_id,
			    (int) $variation_id,
			    $data
		    )));

	    }

	    #endregion

    }
}