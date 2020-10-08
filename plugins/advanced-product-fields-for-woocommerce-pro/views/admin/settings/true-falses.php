<?php
/* @var $model array */
?>

<div class="wapf-field__setting">
	<div class="wapf-setting__label">
		<label><?php _e($model['label'],'sw-wapf');?></label>
		<?php if(isset($model['description'])) { ?>
			<p class="wapf-description">
				<?php _e($model['description'],'sw-wapf');?>
			</p>
		<?php } ?>
	</div>
	<div class="wapf-setting__input">
		<?php foreach($model['options'] as $key => $sentence) { ?>
            <div style="width: 100%; display: flex;align-items: center;margin-bottom: 20px;" data-setting="<?php echo $key; ?>">
                <div class="wapf-toggle" rv-unique-checkbox>
                <input rv-on-change="onChange" rv-checked="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $key; ?>" type="checkbox" >
                    <label class="wapf-toggle__label" for="wapf-toggle-">
                        <span class="wapf-toggle__inner" data-true="<?php _e('Yes','sw-wapf'); ?>" data-false="<?php _e('No','sw-wapf'); ?>"></span>
                        <span class="wapf-toggle__switch"></span>
                    </label>
                </div>
                <div style="padding-left:15px;"><?php echo $sentence; ?></div>
            </div>
		<?php } ?>
	</div>
</div>