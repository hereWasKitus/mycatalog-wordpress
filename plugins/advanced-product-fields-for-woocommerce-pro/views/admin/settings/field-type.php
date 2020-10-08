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
		<select rv-default="field.<?php echo $model['id']; ?>" rv-on-change="onChangeType" rv-value="field.<?php echo $model['id']; ?>">
			<?php
			foreach($model['options'] as $optgroup => $types) {
				echo '<optgroup label="' . $optgroup . '">';
				foreach($types as $type){
					echo '<option value="'.$type['id'].'">'.esc_html($type['title']).'</option>';
				}
			}
			?>
		</select>
		<div>
			<?php
			foreach($model['options'] as $optgroup => $types) {
				foreach($types as $type){
					echo '<p style="opacity:.7" rv-show="field.type | eq \''.$type['id'].'\'">'.esc_html($type['description']).'</p>';
				}
			}
			?>
		</div>
	</div>
</div>