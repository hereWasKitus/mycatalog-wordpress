<?php /* @var $model array */ ?>

<div class="wapf-field__setting" data-setting="<?php echo $model['id']; ?>">
	<div class="wapf-setting__label">
		<label><?php _e($model['label'],'sw-wapf');?></label>
		<?php if(isset($model['description'])) { ?>
			<p class="wapf-description">
				<?php _e($model['description'],'sw-wapf');?>
			</p>
		<?php } ?>
	</div>
	<div class="wapf-setting__input">
		<table style="width: 100%;" rv-show="field.choices | isNotEmpty">
			<thead>
			<tr>
				<td style="width:20px;"></td>
				<td style="font-weight:500;text-align: left;"><?php _e('Text','sw-wapf'); ?></td>
				<?php if(isset($model['show_pricing_options']) && $model['show_pricing_options']) { ?>
					<td style="font-weight:500;text-align: left;"><?php _e('Adjust pricing','sw-wapf'); ?></td>
					<td style="font-weight:500;text-align: left;"><?php _e('Pricing amount','sw-wapf'); ?></td>
				<?php } ?>
				<td style="font-weight:500;text-align: right;"><?php _e('Selected', 'sw-wapf'); ?></td>
			</tr>
			</thead>
			<tbody>
			<tr rv-each-choice="field.choices" rv-data-option-slug="choice.slug">
				<td><a href="#" rv-on-click="field.deleteChoice" class="wapf-button--tiny-rounded">&times;</a></td>
				<td><input rv-on-keyup="onChange" rv-on-change="onChange" type="text" class="choice-label" rv-value="choice.label"/></td>
				<?php if(isset($model['show_pricing_options']) && $model['show_pricing_options']) { ?>
					<td>
						<select class="wapf-pricing-list" rv-on-change="onChange" rv-value="choice.pricing_type">
							<option value="none"><?php _e('No price change','sw-wapf'); ?></option>
							<?php
							foreach(\SW_WAPF_PRO\Includes\Classes\Fields::get_pricing_options() as $k => $v) {
								echo '<option value="'.$k.'">'.$v.'</option>';
							}
							?>
						</select>
					</td>
					<td>
						<input rv-if="choice.pricing_type | eq 'fx'" placeholder="<?php _e('Enter a formula','sw-wapf');?>" rv-on-change="onChange" type="text" rv-value="choice.pricing_amount" />
						<input rv-if="choice.pricing_type | neq 'fx'" placeholder="<?php _e('Amount','sw-wapf');?>" rv-on-change="onChange" type="number" step="any" rv-value="choice.pricing_amount" />
					</td>
				<?php } ?>
				<td style="text-align: right;"><input data-multi-option="<?php echo isset($model['multi_option']) ? $model['multi_option'] : '0' ;?>" rv-on-change="field.checkSelected" rv-checked="choice.selected" type="checkbox" /></td>
			</tr>
			</tbody>
		</table>
		<div style="padding-top:12px;text-align: right;width: 100%;">
			<a href="#" rv-on-click="field.addChoice" class="button button-small"><?php _e('Add option','sw-wapf'); ?></a>
		</div>
		<div style="text-align: right;width: 100%;margin-top:10px">
            <a href="https://www.studiowombat.com/kb-article/all-pricing-options-explained/?ref=wapf_admin" target="_blank">
				<?php _e('Help with pricing','sw-wapf'); ?>
            </a>
		</div>
	</div>
</div>