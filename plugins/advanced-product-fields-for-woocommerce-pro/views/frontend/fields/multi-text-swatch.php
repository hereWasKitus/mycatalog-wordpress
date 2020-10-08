<?php
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

if(!empty($model['field']->options['choices'])) {

	echo '<div class="wapf-swatch-wrapper" data-is-required="'. $model['field']->required .'">';
	echo '<input type="hidden" class="wapf-tf-h" data-fid="'.$model['field']->id.'" value="0" name="wapf[field_'.$model['field']->id.'][]" />';

	foreach ($model['field']->options['choices'] as $option) {

		$attributes = Html::option_attributes('checkbox',$model['product'],$model['field'],$option, true);

		$has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';

		echo sprintf(
			'<div class="%swapf-swatch wapf-swatch--text%s">%s<input %s /></div>',
			$has_pricing ? 'has-pricing ' : '',
			isset($attributes['checked']) ? ' wapf-checked' :'',
			wp_kses($option['label'],\SW_WAPF_PRO\Includes\Classes\Field_Groups::$allowed_html_minimal) . ' ' . Html::frontend_option_pricing_hint($option, $model['product']),
			Enumerable::from($attributes)->join(function($value,$key) {
				if($value)
					return $key . '="' . esc_attr($value) .'"';
				else return $key;
			},' ')
		);

	}

	echo '</div>';

}