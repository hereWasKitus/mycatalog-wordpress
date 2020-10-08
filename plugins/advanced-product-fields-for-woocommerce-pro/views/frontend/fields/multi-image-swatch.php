<?php
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

$cols = isset($model['field']->options['items_per_row']) ? $model['field']->options['items_per_row'] : 3;
$first = true;
if(!empty($model['field']->options['choices'])) {

    echo '<div class="wapf-swatch-wrapper wapf-col--'.$cols.'" data-is-required="'. $model['field']->required .'">';

    foreach ($model['field']->options['choices'] as $option) {

	    $attributes = Html::option_attributes('checkbox',$model['product'],$model['field'],$option,true);
	    $has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';

	    echo sprintf(
            '<div class="%swapf-swatch wapf-swatch--image%s">%s<input %s /><img src="%s"/><div class="wapf-swatch-label">%s</div></div>',
            $has_pricing ? 'has-pricing ' : '',
            isset($attributes['checked']) ? ' wapf-checked' :'',
		    $first ? '<input type="hidden" class="wapf-tf-h" data-fid="'.$model['field']->id.'" value="0" name="wapf[field_'.$model['field']->id.'][]" />' : '',
		    Enumerable::from($attributes)->join(function($value,$key) {
                if($value)
                    return $key . '="' . esc_attr($value) .'"';
                else return $key;
            },' '),
            $option['image'],
            esc_html($option['label']) . ' ' . Html::frontend_option_pricing_hint($option,$model['product'])
        );

	    $first = false;

    }

    echo '</div>';

}