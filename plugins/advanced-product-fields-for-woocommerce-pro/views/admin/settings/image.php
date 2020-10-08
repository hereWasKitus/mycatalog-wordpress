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
		<div class="wapf-media-selector">
			<input rv-mediaselector="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>" rv-on-change="onChange" type="hidden" rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>" />
			<div class="wapf-media-preview" rv-class-wapf-hide="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?> | isEmpty">
				<a class="wapf-btn-add-media"><img rv-src="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>" /></a>
			</div>
			<a rv-class-wapf-hide="choice.image | isNotEmpty" class="wapf-btn-add-media" href="#">
				<?php _e('Select image', 'sw-wapf'); ?>
			</a>
		</div>
	</div>
</div>