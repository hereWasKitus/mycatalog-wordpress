<?php

namespace SW_WAPF_PRO\Includes\Classes {

	class Helper
    {

        public static function get_all_roles() {

            $roles = get_editable_roles();

            return Enumerable::from($roles)->select(function($role, $id) {
                return array('id' => $id,'text' => $role['name']);
            })->toArray();
        }

        public static function thing_to_html_attribute_string($thing){

            $encoded = wp_json_encode($thing);
            return function_exists('wc_esc_json') ? wc_esc_json($encoded) : _wp_specialchars($encoded, ENT_QUOTES, 'UTF-8', true);

        }

	    public static function normalize_string_decimal($number)
	    {
		    return preg_replace('/\.(?=.*\.)/', '', (str_replace(',', '.', $number)));
	    }

	    public static function hex_to_rgba( $hex, $alpha = 1 ) {

		    $hex = str_replace( '#', '', $hex );

		    $length = strlen( $hex );
		    $rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
		    $rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
		    $rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
		    return sprintf('rgba(%s,%s,%s,%s)',$rgb['r'],$rgb['g'],$rgb['b'],$alpha);
	    }

        #region Price functions

		public static function maybe_add_tax($product, $price, $for_page = 'shop'){

				if(empty($price) || $price < 0 || !wc_tax_enabled())
					return $price;

				if(is_int($product))
					$product = wc_get_product($product);

				$args = array('qty' => 1, 'price' => $price);

				if($for_page === 'cart') {
					if(get_option('woocommerce_tax_display_cart') === 'incl')
						return wc_get_price_including_tax($product, $args);
					else
						return wc_get_price_excluding_tax($product, $args);
				}
				else
					return wc_get_price_to_display($product, $args);

		}

        public static function get_product_base_price($product, $quantity) {

        	if(wc_prices_include_tax())
        		$price = wc_get_price_including_tax($product);
        	else $price = wc_get_price_excluding_tax($product);

	        $price = apply_filters('wapf/pricing/base', $price, $product, $quantity);

        	return $price;
        }

	    public static function adjust_addon_price($product, $amount,$type,$for = 'shop') {

		    if($amount === 0)
			    return 0;

		    if($type === 'percent' || $type === 'p')
		    	return $amount;

		    $amount = self::maybe_add_tax($product,$amount,$for);

		    $amount = apply_filters('wapf/pricing/addon',$amount, $product, $type, $for);

		    return $amount;

	    }

	    public static function format_pricing($price) {
		    $price_display_options = Woocommerce_Service::get_price_display_options();

		    return sprintf(
			    $price_display_options['format'],
			    $price_display_options['symbol'],
			    number_format(
				    $price,
				    $price_display_options['decimals'],
				    $price_display_options['decimal'],
				    $price_display_options['thousand']
			    )
		    );
	    }

        public static function format_pricing_hint($type, $amount, $product, $for_page = 'shop') {

	        $format = apply_filters('wapf/html/pricing_hint','(<span class="wapf-addon-price">{x}</span>)',$product, $amount, $type);
			$amount = apply_filters('wapf/html/pricing_hint/amount', $amount,$product,$type);

			$ar_sign = empty($amount) ? '+' : ($amount < 0 ? '' : '+');

			if($type === 'percent' || $type === 'p')
		        return str_replace(
		        	'{x}',
			        sprintf('%s%s%%',$ar_sign,empty($amount) ? 0 : $amount)
			        ,$format
		        );

	        $price_display_options = Woocommerce_Service::get_price_display_options();

	        $price_output = sprintf(
		        $price_display_options['format'],
		        $price_display_options['symbol'],
		        number_format(
			        self::adjust_addon_price($product,empty($amount) ? 0 : $amount,$type,$for_page),
			        $price_display_options['decimals'],
			        $price_display_options['decimal'],
			        $price_display_options['thousand']
		        )
	        );

	        if($type === 'fx')
		        return str_replace('{x}', (empty($amount) ? '...' : sprintf('%s',$price_output)), $format);

            if($type === 'char' || $type == 'charq')
	            return str_replace('{x}',sprintf('%s%s %s', $ar_sign, $price_output, __('per character','sw-wapf')), $format);

            $sign = $type === 'nr' || $type === 'nrq' ? '&times;' : $ar_sign;

	        return str_replace('{x}',sprintf('%s%s', $sign, $price_output), $format);

        }

        #endregion

        #region language functions

	    public static function get_available_languages() {

		    if(function_exists('pll_languages_list')) {
			    $languages = pll_languages_list(array('fields' => null));

			    if(is_array($languages))
			    	return Enumerable::from($languages)->select(function($x){
			    		return array(
			    			'id'    => $x->locale, 
			    			'text'    => $x->name,
					    );
				    })->toArray();
		    }

		    if(function_exists('icl_get_languages')) {
			    $languages = icl_get_languages('skip_missing=0&orderby=code');
			    return Enumerable::from($languages)->select(function($x){
				    return array(
					    'id' => $x['code'],
					    'text' => $x["native_name"]
				    );
			    })->toArray();
		    }

			return array();
	    }

	    public static function get_current_language() {

		    if(function_exists('pll_current_language')) {
		    	return pll_current_language('locale');
		    }

			if(defined('ICL_LANGUAGE_CODE'))
				return ICL_LANGUAGE_CODE;

		    return 'default';
	    }

		#endregion

		public static function closing_bracket_index($str,$from_pos) {
			$arr = str_split($str);
			$openBrackets = 1;
			for($i = $from_pos+1;$i<strlen($str);$i++) {
				if($arr[$i] === '(')
					$openBrackets++;
				if($arr[$i] === ')') {
					$openBrackets--;
					if($openBrackets === 0)
						return $i;
				}
			}
			return sizeof($str)-1;
		}

		public static function replace_in_formula($str,$qty,$base_price,$val,$cart_fields) {
			$str = str_replace( array('[qty]','[price]','[x]'), array($qty,$base_price,$val), $str );
			return preg_replace_callback('/\[field\..+?]/', function($matches) use ($cart_fields) {
				$field_id = str_replace(array('[field.',']'),'',$matches[0]);
				$field = Enumerable::from($cart_fields)->firstOrDefault(function($f) use ($field_id){return $f['id'] === $field_id;});
				return empty($field['values'][0]['label']) ? 0 : $field['values'][0]['label'];
			},$str);

		}

		public static function find_nearest($value, $axis) {

			if(isset($axis[$value]))
				return $value;

			$keys = array_keys($axis);
			$value = floatval($value);

			if($value < floatval($keys[0]))
				return $keys[0];

			for($i=0; $i < count($keys); $i++ ) {
				if($value > floatval($keys[$i]) && $value <= floatval($keys[$i+1]))
					return $keys[$i+1];
			}

            return $keys[$i];

        }

		public static function parse_math_string($str, $cart_fields) {
	    	$formulas = apply_filters('wapf/fx/functions', array('min','max','lookuptable','len'));
	    	$str = strval($str);
	    	for($i=0;$i<sizeof($formulas);$i++) {
	    		$test = $formulas[$i] . '(';
	    		$idx = strpos($str,$test);
	    		if($idx !== false) {
	    			$l = $idx + strlen($test);
	    			$b = self::closing_bracket_index($str,$l);
	    			$split = explode(';',substr($str,$l,$b-$l));
	    			$solution = '';
	    			switch($formulas[$i]) {
					    case 'min':
					    	$solution = min(array_map(function($x) use($cart_fields){ return self::parse_math_string($x,$cart_fields); },$split));
					    	break;
					    case 'max':
						    $solution = max(array_map(function($x) use($cart_fields){ return self::parse_math_string($x,$cart_fields); },$split));
							break;
					    case 'len': $solution = strlen($split[0]); break;
					    case 'lookuptable':
					    	$tables = apply_filters('wapf/lookup_tables', array());

					    	if(!empty($tables) && isset($tables[$split[0]])) {
					    		$table = $tables[$split[0]];
					    		$fieldX = Enumerable::from($cart_fields)->firstOrDefault(function($x) use($split){return $x['id'] === $split[1];});
					    		$fieldY = Enumerable::from($cart_fields)->firstOrDefault(function($x) use($split){return $x['id'] === $split[2];});

					    		if($fieldX && $fieldY) {
								    $xValue = $fieldX['values'][0]['label'];
								    $yValue = $fieldY['values'][0]['label'];
								    if($xValue === '' || $yValue === ''){
								    	$solution = 0;
								    	break;
								    }

								    $table_x_value = self::find_nearest($xValue,$table);
								    $table_y_value = self::find_nearest($yValue,$table[$table_x_value]);

								    $solution = $table[$table_x_value][$table_y_value];
									break;

							    }
						    }
				    }
				    $solution = apply_filters('wapf/fx/solve', $solution,$formulas[$i],$split);
				    $str = self::parse_math_string( substr($str,0,$idx) . $solution . substr($str,$b+1),$cart_fields );
			    }
		    }

	    	return self::evaluate_math_string($str);

		}

		public static function evaluate_math_string($str) {
			$__eval = function ($str) use(&$__eval){
				$error = false;
				$div_mul = false;
				$add_sub = false;
				$result = 0;
				$str = preg_replace('/[^\d.+\-*\/()]/i','',$str);
				$str = rtrim(trim($str, '/*+'),'-');
				if ((strpos($str, '(') !== false &&  strpos($str, ')') !== false)) {
					$regex = '/\(([\d.+\-*\/]+)\)/';
					preg_match($regex, $str, $matches);
					if (isset($matches[1])) {
						return $__eval(preg_replace($regex, $__eval($matches[1]), $str, 1));
					}
				}
				$str = str_replace(array('(',')'), '', $str);
				if ((strpos($str, '/') !== false ||  strpos($str, '*') !== false)) {
					$div_mul = true;
					$operators = array('*','/');
					while(!$error && $operators) {
						$operator = array_pop($operators);
						while($operator && strpos($str, $operator) !== false) {
							if ($error) {
								break;
							}
							$regex = '/([\d.]+)\\'.$operator.'(\-?[\d.]+)/';
							preg_match($regex, $str, $matches);
							if (isset($matches[1]) && isset($matches[2])) {
								if ($operator=='+') $result = (float)$matches[1] + (float)$matches[2];
								if ($operator=='-') $result = (float)$matches[1] - (float)$matches[2];
								if ($operator=='*') $result = (float)$matches[1] * (float)$matches[2];
								if ($operator=='/') {
									if ((float)$matches[2]) {
										$result = (float)$matches[1] / (float)$matches[2];
									} else {
										$error = true;
									}
								}
								$str = preg_replace($regex, $result, $str, 1);
								$str = str_replace(array('++','--','-+','+-'), array('+','+','-','-'), $str);
							} else {
								$error = true;
							}
						}
					}
				}

				if (!$error && (strpos($str, '+') !== false ||  strpos($str, '-') !== false)) {
					$str = str_replace('--', '+', $str);
					$add_sub = true;
					preg_match_all('/([\d\.]+|[\+\-])/', $str, $matches);
					if (isset($matches[0])) {
						$result = 0;
						$operator = '+';
						$tokens = $matches[0];
						$count = count($tokens);
						for ($i=0; $i < $count; $i++) {
							if ($tokens[$i] == '+' || $tokens[$i] == '-') {
								$operator = $tokens[$i];
							} else {
								$result = ($operator == '+') ? ($result + (float)$tokens[$i]) : ($result - (float)$tokens[$i]);
							}
						}
					}
				}
				if (!$error && !$div_mul && !$add_sub) {
					$result = (float)$str;
				}
				return $error ? 0 : $result;
			};
			return $__eval($str);
		}

		public static function is_admin_order() {

			if ( function_exists('get_current_screen') ){
				$screen = get_current_screen();
				if ( $screen && in_array( $screen->id, array( 'edit-shop_order', 'shop_order' ) ) ) {
					return true;
				}
			}

			return false;

		}

	}
}