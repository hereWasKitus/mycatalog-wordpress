<?php
use SW_WAPF_PRO\Includes\Classes\Helper;
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

?>

<select <?php echo $model['field_attributes']; ?>>
    <?php
        if(isset($model['field']->options['choices'])) {

            if(!$model['field']->required || ($model['field']->required && !Enumerable::from($model['field']->options['choices'])->any(function($x){
                return isset($x['selected']) && $x['selected'] === true;
	            })))
                echo '<option value="">' . __( 'Choose an option','sw-wapf') . '</option>';

            foreach($model['field']->options['choices'] as $option) {
                $attributes = array(
                    'value' => $option['slug'],
                    'data-wapf-label' => esc_html($option['label'])
                );

                $has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';
	            if($has_pricing) {
		            $attributes['data-wapf-pricetype'] = $option['pricing_type'];
		            $attributes['data-wapf-price'] = $option['pricing_type'] === 'fx' ? $option['pricing_amount'] : Helper::adjust_addon_price($model['product'],$option['pricing_amount'],$option['pricing_type'],'shop');
		            if($option['pricing_type'] === 'fx') {
		                $attributes['data-fx-hint'] = esc_html(Helper::format_pricing_hint('fx','',$model['product'],'shop'));
			            $attributes['data-wapf-tax'] = wc_get_price_to_display( $model['product'], array( 'qty' => 1, 'price' => 1 ) );
		            }
	            }

                if( isset($option['selected']) && $option['selected'] === true )
                    $attributes['selected'] = '';

                echo sprintf(
                    '<option %s>%s</option>',
                    Enumerable::from($attributes)->join(function($value,$key) {
                        if($value)
                            return $key . '="' . esc_attr($value) .'"';
                        else return $key;
                    },' '),
                    esc_html($option['label']) .  ' ' . Html::frontend_option_pricing_hint($option,$model['product'])
                );
            }
        }
    ?>
</select>