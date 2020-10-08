<?php
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

if(!empty($model['field']->options['choices'])) {

    echo '<div class="wapf-checkboxes" '.Html::multi_choice_attributes($model['field'],$model['product']).'>';

    foreach ($model['field']->options['choices'] as $option) {

        $unique = mt_rand(10000,99999);

	    $attributes = Html::option_attributes('checkbox',$model['product'],$model['field'],$option, true);
	    $attributes['id'] = $unique;

        $wrapper_classes = array('wapf-checkable');
        if(isset($attributes['checked']))
            $wrapper_classes[] = 'wapf-checked';

	    $has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';
	    if($has_pricing)
		    $wrapper_classes[] = 'has-pricing';

        echo sprintf(
            '<div class="%s"><label for="%s" class="wapf-input-label"><input type="hidden" class="wapf-tf-h" data-fid="'.$model['field']->id.'" value="0" name="wapf[field_'.$model['field']->id.'][]" />
<input %s /><span class="wapf-custom"></span><span class="wapf-label-text">%s</span></label></div>',
            join(' ',$wrapper_classes),
            $unique,
            Enumerable::from($attributes)->join(function($value,$key) {
                if($value)
                    return $key . '="' . esc_attr($value) .'"';
                else return $key;
            },' '),
            esc_html($option['label']) . ' ' . Html::frontend_option_pricing_hint($option,$model['product'])
        );

    }

    echo '</div>';

}