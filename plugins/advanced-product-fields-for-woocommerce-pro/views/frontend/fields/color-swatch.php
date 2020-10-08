<?php
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

if(!empty($model['field']->options['choices'])) {

	echo '<div class="wapf-swatch-wrapper" data-is-required="'. $model['field']->required .'">';
	echo '<input type="hidden" class="wapf-tf-h" data-fid="'.$model['field']->id.'" value="0" name="wapf[field_'.$model['field']->id.']" />';

	foreach ($model['field']->options['choices'] as $option) {

		$attributes = Html::option_attributes('radio',$model['product'],$model['field'],$option, false);

		$has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';

		echo sprintf(
			'<div class="%swapf-swatch wapf--%s wapf-swatch--color%s" style="color:%s;background-color: %s;width:%spx;height:%spx">%s<input %s /></div>',
			$has_pricing ? 'has-pricing ' : '',
			$model['field']->options['layout'],
			isset($attributes['checked']) ? ' wapf-checked' :'',
			$model['field']->options['border'],
			$option['color'],
			$model['field']->options['size'],
			$model['field']->options['size'],
			Html::tooltip($model['field'], $option, $model['product'] ),
			Enumerable::from($attributes)->join(function($value,$key) {
				if($value)
					return $key . '="' . esc_attr($value) .'"';
				else return $key;
			},' ')
		);

	}

	echo '</div>';

}