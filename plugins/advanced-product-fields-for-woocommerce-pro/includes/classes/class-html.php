<?php

namespace SW_WAPF_PRO\Includes\Classes
{

    use SW_WAPF_PRO\Includes\Models\Field;
    use SW_WAPF_PRO\Includes\Models\FieldGroup;

    class Html
    {
        public static $minimal_allowed_html = array(
            'br'        => array(),
            'hr'        => array('class' => array(), 'style' => array()),
            'a'         => array('href' => array(), 'target' => array(), 'class' => array(), 'style' => array()),
            'i'         => array('class' => array(), 'style' => array()),
            'em'        => array('class' => array(), 'style' => array()),
            'strong'    => array('class' => array(), 'style' => array()),
            'b'         => array('class' => array(), 'style' => array()),
            'span'      => array('class' => array(), 'style' => array()),
            'div'       => array('class' => array(), 'style' => array()),
            'h1'      => array('class' => array(), 'style' => array()),
            'h2'      => array('class' => array(), 'style' => array()),
            'h3'      => array('class' => array(), 'style' => array()),
            'h4'      => array('class' => array(), 'style' => array()),
            'h5'      => array('class' => array(), 'style' => array()),
            'h6'      => array('class' => array(), 'style' => array()),
        );

        #region General views
        public static function partial($view, $model = null)
        {
            ob_start();
            $dir = trailingslashit(wapf_get_setting('path')) . 'views/' . $view;
            include $dir . '.php';
            echo ob_get_clean();
        }

        public static function view($view, $model = null)
        {
            ob_start();
            $dir = trailingslashit(wapf_get_setting('path')) . 'views/' . $view;

            include $dir . '.php';
            return ob_get_clean();
        }

        #endregion

        #region Admin Functions
        public static function setting($model = array()) {

            if(!isset($model['type']))
                return;

            ob_start();
            $dir = trailingslashit(wapf_get_setting('path')) . 'views/admin/settings/' . $model['type'];
            include $dir . '.php';
            echo ob_get_clean();
        }

        public static function admin_field($field = array(), $type = 'wapf_product') {
            ob_start();
            $path = trailingslashit(wapf_get_setting('path')) . 'views/admin/field.php';
            include $path;
            echo ob_get_clean();
        }

        public static function wp_list_table($view_name,$model,$list) {
            ob_start();
            $path = trailingslashit(wapf_get_setting('path')) . 'views/admin/'.$view_name.'.php';
            include $path;
            echo ob_get_clean();
        }

        public static function help_modal($text,$title = '', $button_text = '',$via_icon = false) {
        	$model = array(
        		'content'   => $text,
		        'title'     => $title,
		        'button'    => $button_text,
		        'icon'      => $via_icon
	        );
	        ob_start();
	        $path = trailingslashit(wapf_get_setting('path')) . 'views/admin/help-modal.php';
	        include $path;
	        echo ob_get_clean();
        }
        #endregion

        #region Product-related Functions
        public static function product_totals($product) {

            $data = apply_filters('wapf/html/product_totals/data', array(
            	'product-id'        => $product->get_id(),
	            'product-type'      => $product->get_type() === 'variation' ? 'variable' : $product->get_type(),
	            'product-price'     => apply_filters('wapf/pricing/product',wc_get_price_to_display($product), $product)
            ), $product);

            $data_output = Enumerable::from($data)->join(function($value,$key){
            	return 'data-' . esc_html($key) . '="'.esc_html($value).'"';
            },' ');

            ob_start();
            $path = trailingslashit(wapf_get_setting('path')) . 'views/frontend/product-totals.php';
            include $path;
            $totals_html = ob_get_clean();

            echo apply_filters('wapf/html/product_totals',$totals_html, $product);

        }
        #endregion

        #region Field Groups and Fields

	    public static function display_field_groups($field_groups, $product) {

		    ob_start();

		    do_action('wapf_before_wrapper', $product);

		    echo '<div class="wapf-wrapper">';

		    $group_ids = array();

		    foreach ($field_groups as $field_group) {

			    $group_ids[] = $field_group->id;
			    echo self::field_group($product,$field_group);

		    }

		    echo '<input type="hidden" value="'.implode(',',$group_ids).'" name="wapf_field_groups"/>';

		    echo '</div>';

		    do_action('wapf_before_product_totals', $product);

		    self::product_totals($product);

		    do_action('wapf_after_product_totals', $product);

		    return ob_get_clean();
	    }

        public static function field_group($product, FieldGroup $field_group, $data = array()) {

            if(empty($field_group) || empty($field_group->fields))
                return '';

            ob_start();
            $dir = trailingslashit(wapf_get_setting('path')) . 'views/frontend/field-group.php';
            include $dir;
            return ob_get_clean();

        }

        public static function field($product, Field $field, $fieldgroup_id) {

            $model = array(
            	'product'           => $product,
                'field'             => $field,
                'field_value'       => self::field_value($field),
                'field_attributes'  => self::field_attributes($product,$field,$fieldgroup_id)
            );

            return self::view('frontend/fields/' . $field->type, $model);
        }

        public static function field_description(Field $field) {

        	if(empty($field->description))
        		return '';

            $field_description = '<div class="wapf-field-description">'.wp_kses($field->description,self::$minimal_allowed_html).'</div>';

            return apply_filters('wapf/html/field_description',$field_description,$field);
        }

        public static function section_container_classes(Field $field) {
	        $extra_classes = apply_filters('wapf/section_classes/' . $field->id, array());

	        $classes = array('wapf-section');

	        if(!empty($field->class))
		        $classes[] = $field->class;

	        if($field->has_conditionals())
	        	$classes[] = 'wapf-hide';

	        return implode(' ', array_merge(array_map('sanitize_html_class', $extra_classes), $classes));
        }

        public static function field_container_classes(Field $field,\WC_Product $product) {

            $extra_classes = apply_filters('wapf/html/field_container_classes', array(), $field);
            $classes = array('wapf-field-container','wapf-field-' . $field->type);

            if(!empty($field->class))
                $classes[] = $field->class;

            if($field->has_conditionals() && $product->get_type() !== 'simple')
                $classes[] = 'wapf-hide';

            if(!$field->is_choice_field() && $field->pricing_enabled())
            	$classes[] = 'has-pricing';

            return implode(' ', array_merge(array_map('sanitize_html_class', $extra_classes), $classes));
        }

        public static function field_container_attributes(Field $field){

            $attributes = array('for' => $field->id);

	        if(!empty($field->conditionals)) {
		        $dependencies = Helper::thing_to_html_attribute_string($field->conditionals);
		        $attributes['data-wapf-d'] = $dependencies;
	        }

            if($field->qty_based) {
	            $attributes['data-qty-based'] = '';

	            if($field->type === 'section')
		            $attributes['data-clone-txt'] = empty($field->clone_txt) ? '' : $field->clone_txt;
	            else $attributes['data-clone-txt'] = empty($field->clone_txt) ? ($field->label . ' #{n}') : $field->clone_txt;

            }

            $attributes = apply_filters('wapf/html/field_container_attributes', $attributes, $field);

            return Enumerable::from($attributes)->join(function($value,$key){
                if($value)
                    return $key . '="' . esc_attr($value) .'"';
                else return $key;
            },' ');
        }

        public static function field_label(Field $field, $product, $show_required_symbol = true) {

            $label = '<span>' . wp_kses($field->label, self::$minimal_allowed_html) .'</span>';

            if($show_required_symbol && $field->required)
                $label .= ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';

            if($field->pricing_enabled() && $field->type !== 'true-false' && !$field->is_choice_field() )
                $label .= ' ' . self::frontend_field_pricing_hint($field,$product);

            return apply_filters('wapf/html/field_label',$label,$field,$product);

        }

        public static function multi_choice_attributes(Field $field, $product) {

        	$attributes = array(
		        'data-is-required' => $field->required
	        );

	        $attributes = apply_filters('wapf/html/multi_choice_attributes', $attributes, $field, $product);

	        return Enumerable::from( $attributes )->join( function ( $value, $key ) {
		        if ( isset($value) && strval($value)!='' ) {
			        return $key . '="' . esc_attr( $value ) . '"';
		        } else {
			        return $key;
		        }
	        }, ' ' );

        }

        public static function option_attributes($type,$product, Field $field, $option, $multiple_choice = false) {

	        $prefix = 'data-wapf-';

	        $attributes = array(
				'type'              => $type,
				'id'                => 'wapf_field_' . $field->id .'_' . $option['slug'],
				'name'              => sprintf('wapf[field_%s]' . ($multiple_choice ? '[]' : ''), $field->id),
				'class'             => 'wapf-input',
				'data-field-id'     => $field->id,
				'value'             => $option['slug'],
				$prefix .'label'    => esc_html($option['label']),
			);

	        $attributes['data-is-required'] = $field->required;

	        if($field->required)
		        $attributes['required'] = '';

	        if(isset($option['selected']) && $option['selected'] === true)
		        $attributes['checked'] = '';

	        if(isset($option['pricing_type']) && $option['pricing_type'] !== 'none') {
		        $attributes[$prefix . 'pricetype'] = $option['pricing_type'];
		        $attributes[$prefix . 'price'] = $option['pricing_type'] === 'fx' ? $option['pricing_amount'] : Helper::adjust_addon_price($product,$option['pricing_amount'],$option['pricing_type'],'shop');
		        if($option['pricing_type'] === 'fx')
			        $attributes[$prefix . 'tax'] = wc_get_price_to_display($product, array('qty' => 1, 'price' => 1));
	        }

	        if($multiple_choice ) {
	        	if(isset($field->options['max_choices']))
	        	    $attributes['data-maxc'] = intval($field->options['max_choices']);
		        if(isset($field->options['min_choices']))
			        $attributes['data-minc'] = intval($field->options['min_choices']);
	        }

	        $attributes = apply_filters('wapf/html/option_attributes', $attributes, $field, $product, $option);

	        return $attributes;

        }



        private static function field_attributes($product,Field $field, $field_group_id) {

        	$field_attributes = array(
		        'data-is-required'  => $field->required,
		        'data-field-id'     => $field->id
	        );

	        if($field->required)
		        $field_attributes['required'] = '';

	        if(!$field->is_content_field()) {

		        $extra_classes = apply_filters('wapf/html/field_classes', array(), $field);
		        $classes = array('wapf-input');

		        $field_attributes['name'] = 'wapf[field_'.$field->id.']';
		        $field_attributes['class'] = implode(' ',array_merge(array_map('sanitize_html_class',$extra_classes,$classes)));

		        if ( $field->type !== 'select' ) {
			        if ( $field->pricing_enabled() ) {
				        $field_attributes['data-wapf-price'] = $field->pricing->type === 'fx' ?
					        $field->pricing->amount :
					        Helper::adjust_addon_price( $product, $field->pricing->amount, $field->pricing->type, 'shop' );
				        $field_attributes['data-wapf-pricetype'] = $field->pricing->type;
				        if ( $field->pricing->type === 'fx' ) {
					        $field_attributes['data-wapf-tax'] = wc_get_price_to_display( $product, array( 'qty'   => 1,
					                                                                                       'price' => 1
					        ) );
				        }
			        }
		        }

		        if($field->type === 'file') {
			        $field_attributes['name'] = $field_attributes['name'] . '[]';
			        if(!empty($field->options['multiple']))
						$field_attributes['multiple'] = '';
					if(isset($field->options['accept'])) {
						$accept = '.' . str_replace(array(',','|'),',.',$field->get_option('accept'));
						$field_attributes['accept'] = $accept;
					}
		        }

		        if ( isset( $field->options['placeholder'] ) ) {
			        $field_attributes['placeholder'] = $field->options['placeholder'];
		        }

		        if ( isset( $field->options['minimum'] ) ) {
			        $field_attributes['min'] = $field->options['minimum'];
		        }

		        if ( isset( $field->options['maximum'] ) ) {
			        $field_attributes['max'] = $field->options['maximum'];
		        }

		        if(isset($field->options['number_type']) && $field->options['number_type'] !== 'int')
		        	$field_attributes['step'] = $field->options['number_type'];

		        if ( !empty( $field->options['minlength'] ) ) {
			        $field_attributes['minlength'] = intval($field->options['minlength']);
		        }
		        if ( !empty( $field->options['maxlength'] ) ) {
			        $field_attributes['maxlength'] = intval($field->options['maxlength']);
		        }
		        if ( !empty( $field->options['pattern'] ) ) {
			        $field_attributes['pattern'] = $field->options['pattern'];
		        }

		        if ( $field->type === 'true-false' && isset( $field->options['default'] ) && $field->options['default'] === 'checked' ) {
			        $field_attributes['checked'] = '';
		        }

	        }

	        $field_attributes = apply_filters('wapf/html/field_attributes',$field_attributes, $field, $product, $field_group_id);

	        return Enumerable::from( $field_attributes )->join( function ( $value, $key ) {
		        if ( isset($value) && strval($value)!='' ) {
			        return $key . '="' . esc_attr( $value ) . '"';
		        } else {
			        return $key;
		        }
	        }, ' ' );

        }

        private static function field_value(Field $field) {

        	if($field->type === 'p')
        		return empty($field->options['p_content']) ? '' : wp_kses($field->options['p_content'], self::$minimal_allowed_html);
        	if($field->type === 'img')
		        return empty($field->options['image']) ? '' : $field->options['image'];

	        $value = empty($field->options['default']) ? '' : esc_html($field->options['default']);

            return $value;
        }

	    public static function tooltip(Field $field,$option,$product) {

		    if(empty($field->options['tooltip']) || !$field->options['tooltip'])
			    return '';

		    return sprintf(
			    '<span class="wapf-ttp" style="background:%s;color:%s"><span style="color:%s">%s%s</span></span>',
			    $field->options['tooltip_bg'],
			    $field->options['tooltip_bg'],
			    $field->options['tooltip_fg'],
			    esc_html($option['label']),
			    '  ' . self::frontend_option_pricing_hint($option, $product)
		    );
	    }

	    public static function frontend_option_pricing_hint($option, $product) {

		    if( empty($option['pricing_type']) || $option['pricing_type'] === 'none')
		    	return '';

		    return '<span class="wapf-pricing-hint">' . Helper::format_pricing_hint($option['pricing_type'], $option['pricing_type'] === 'fx' ? '' : $option['pricing_amount'], $product,'shop') . '</span>';
	    }

	    public static function frontend_field_pricing_hint(Field $field, $product) {

		    if(!$field->pricing_enabled())
		    	return '';

		    return '<span class="wapf-pricing-hint">'. Helper::format_pricing_hint($field->pricing->type, $field->pricing->type === 'fx' ? '' : $field->pricing->amount, $product,'shop') .'</span>';
	    }

	    #endregion

    }
}