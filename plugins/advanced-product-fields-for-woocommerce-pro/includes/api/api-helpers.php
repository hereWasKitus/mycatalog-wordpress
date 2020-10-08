<?php
##! BETA - PLEASE USE AT OWN RISK AS API CAN CHANGE IN FUTURE UPDATES!
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Field_Groups;
use SW_WAPF_PRO\Includes\Models\FieldGroup;

#region Plugin-specific

function wapf_has_setting( $name = '' ) {

    return wapf_pro()->has_setting( $name );
}

function wapf_get_setting( $name, $value = null ) {

    if( wapf_has_setting($name) ) {
        $value =  wapf_pro()->get_setting( $name );
    }

    $value = apply_filters( "wapf/setting/{$name}", $value );

    return $value;
}
#endregion

#region Handy Public Functions

function wapf_display_field_groups_for_product($product) {
	$field_groups = wapf_get_field_groups_of_product($product);
	return \SW_WAPF_PRO\Includes\Classes\Html::display_field_groups($field_groups,$product);
}

function wapf_product_has_options($product) {
	return Field_Groups::product_has_field_group($product);
}

function wapf_get_field_groups_of_product($product) {
	return Field_Groups::get_field_groups_of_product($product);
}

function wapf_get_field_groups_by_ids($ids = array()) {
	return Field_Groups::get_by_ids($ids);
}

function wapf_get_options_from_order($order) {

	if(!is_object($order))
		$order = wc_get_order($order);

	$items = $order->get_items();

	$all_metas = array();

	foreach ($items as $item) {

		$wapf_meta = $item->get_meta('_wapf_meta');
		if(empty($wapf_meta))
			continue;

		$product = $item->get_product();
		$qty = $item->get_quantity();

		$result = array(
			'product_id'    => $product->get_id(),
			'quantity'      => $qty,
			'options'       => array()
		);

		$the_felds = isset($wapf_meta['fields']) ? $wapf_meta['fields'] : $wapf_meta;

		foreach($the_felds as $field) {
			$result['options'][] = array(
				'field_id'      => $field['id'],
				'label'         => $field['label'],
				'value'         => $field['value']
			);
		}

		$all_metas[] = $result;

	}

	return $all_metas;

}

function wapf_get_custom_fields_in_cart() {

	if(!function_exists('WC'))
		return array();

	$data = array();

	foreach ( WC()->cart->get_cart() as $cart_item ) {

		if(isset($cart_item['wapf'])) {

			$product = $cart_item['data'];
			$field_groups = Field_Groups::get_field_groups_of_product($product);
			$fields = Enumerable::from($field_groups)->merge(function($x){return $x->fields; })->toArray();

			$options = array();

			foreach ($cart_item['wapf'] as $wapf) {

				$the_field = Enumerable::from($fields)->firstOrDefault(function($x) use ($wapf) {
					return $x->id === $wapf['id'];
				});

				if(!$the_field)
					continue;

				$options[] = array(
					'id'        => $the_field->id,
					'label'     => $the_field->label,
					'value'     => $wapf['value']
				);

			}

			$data[] = array(
				'product_id'    => $product->get_id(),
				'fields'        =>  $options
			);

		}

	}

	return $data;
}

function wapf_fieldgroup_to_array(FieldGroup $fg){
	return $fg->to_array();
}

function wapf_array_to_fieldgroup(array $a) {
	$fg = new FieldGroup();
	return $fg->from_array($a);
}

#endregion