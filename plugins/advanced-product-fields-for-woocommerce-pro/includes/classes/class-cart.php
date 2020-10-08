<?php

namespace SW_WAPF_PRO\Includes\Classes {

	use SW_WAPF_PRO\Includes\Models\Field;

	class Cart {

		public static function calculate_cart_item_options_total($cart_item) {

			if(empty($cart_item['wapf']))
				return false;

			$quantity = isset($cart_item['quantity']) ? $cart_item['quantity'] : 1;
			$product_id = empty($cart_item['variation_id']) ? $cart_item['product_id'] : $cart_item['variation_id'];

			$product = wc_get_product($product_id);
			$base = Helper::get_product_base_price($product, $quantity);

			$data = array(
				'options_total' => 0,
				'base'          => $base,
				'options'       => array()
			);

			$options_total = 0;
			foreach ($cart_item['wapf'] as $field) {
				$prices = array();
				if(!empty($field['values'])) {
					foreach ($field['values'] as $value) {
						if($value['price'] === 0 || $value['price_type'] === 'none')
							continue;

						$v = isset($value['slug']) ? $value['label'] : $field['raw'];
						$price = Fields::do_pricing($field['qty_based'], $value['price_type'], $value['price'], $base, $quantity, $v, $product_id,$cart_item);
						$options_total = $options_total + $price;

						$prices[$v] = array(
							'price' => $price,
							'pricing_hint' => '<span class="wapf-pricing-hint">' . Helper::format_pricing_hint($value['price_type'],$price,$product,'cart') . '</span>',
						);
					}
				}

				if(!empty($prices))
					$data['options'][$field['id']] = $prices;

			}

			$data['options_total'] = $options_total;
			$data['base'] = $base;

			return $data;

		}

		public static function validate_cart_data($field_groups,$passed, $product_id, $qty, $variation_id = null) {

			foreach ( $field_groups as $field_group ) {

				foreach ( $field_group->fields as $field ) {

					$filter = 'wapf/validate/' . $field->id;
					if ( has_filter( $filter ) ) {
						$value = Fields::get_raw_field_value_from_request( $field, 0, true );
						$error = apply_filters( $filter, array( 'error' => !$passed ), $value, $field, $product_id, 1 );
						if ( $error['error'] )
							return $error['message'];

						if ( $qty > 1 && $field->is_field_or_parent_qty_based() ) {
							for ( $i = $qty; $i >= 2; $i -- ) {
								$value = Fields::get_raw_field_value_from_request( $field, $i, true );
								$error = apply_filters( $filter, array( 'error' => ! $passed ), $value, $field, $product_id, $i );

								if ( $error['error'] )
									return $error['message'];

							}
						}

					}

					$files = Cache::get_files();
					if ( $field->type === 'file' ) {
						$file_err = File_Upload::validate_files_for_field( $files, $field );
						if ( is_string( $file_err ) )
							return $file_err;

						if ( $qty > 1 && $field->is_field_or_parent_qty_based() ) {
							for ( $i = $qty; $i >= 2; $i -- ) {
								$file_err = File_Upload::validate_files_for_field( $files, $field, $i );
								if ( is_string( $file_err ) )
									return $file_err;

							}
						}
					}

					if ( ! Fields::should_field_be_filled_out( $field_group, $field, $variation_id === null ? $product_id : $variation_id ) )
						continue;

					$value = Fields::get_raw_field_value_from_request( $field, 0, true );

					if ( $field->required && $field->is_normal_field() && ( $value === '' || $value === null ) )
						return sprintf(__( 'The field "%s" is required.', 'sw-wapf' ), $field->get_label());

					if ( ! empty( $value ) && $field->is_multichoice_field() ) {
						if ( ! empty( $field->options['min_choices'] ) && count( (array) $value ) < intval( $field->options['min_choices'] ) )
							return sprintf(__( 'The field "%s" requires at minimum %s selections.', 'sw-wapf' ), $field->get_label(),$field->options['min_choices']);

						if ( ! empty( $field->options['max_choices'] ) && count( (array) $value ) > intval( $field->options['max_choices'] ) )
							return sprintf(__( 'The field "%s" requires at maximum %s selections.', 'sw-wapf' ), $field->get_label(), $field->options['max_choices'] );
					}

					if ( $qty > 1 && $field->is_field_or_parent_qty_based() ) {
						for ( $i = $qty; $i >= 2; $i -- ) {
							$value = Fields::get_raw_field_value_from_request( $field, $i, true );

							if ( $field->required && $field->is_normal_field() && ( $value === '' || $value === null ) )
								return sprintf(__( 'The field "%s" is required.', 'sw-wapf' ), $field->get_label());

							if ( ! empty( $value ) && $field->is_multichoice_field() ) {
								if ( ! empty( $field->options['min_choices'] ) && count( (array) $value ) < intval( $field->options['min_choices'] ) )
									return sprintf(__( 'The field "%s" requires at minimum %s selections.', 'sw-wapf' ), $field->get_label(),$field->options['min_choices']);

								if ( ! empty( $field->options['max_choices'] ) && count( (array) $value ) > intval( $field->options['max_choices'] ) )
									return sprintf(__( 'The field "%s" requires at maximum %s selections.', 'sw-wapf' ), $field->get_label(), $field->options['max_choices'] );

							}

						}
					}
				}
			}

			return $passed;

		}

		public static function to_cart_item_field(Field $field, $clone_idx = 0,$values = null) {

			$raw_value = null;
			if(!$values) {
				$raw_value = Fields::get_raw_field_value_from_request($field, $clone_idx);
				$values = Fields::raw_to_cartfield_values($field, $raw_value,$clone_idx);
			} else { 
				if(count($values) === 1)
					$raw_value = $values[0]['label'];
				else
					foreach($values as $v) {
						$raw_value[] = $v;
					}
			}

			return array(
				'id'            => $field->id,
				'raw'           => $raw_value,
				'values'        => $values,
				'qty_based'     => $field->is_field_or_parent_qty_based(),
				'label'         => esc_html( $field->get_label() ),
				'hide_cart'     => isset($field->options['hide_cart']) && $field->options['hide_cart'],
				'hide_checkout' => isset($field->options['hide_checkout']) && $field->options['hide_checkout'],
				'hide_order'    => isset($field->options['hide_order']) && $field->options['hide_order'],
			);

		}

	}
}