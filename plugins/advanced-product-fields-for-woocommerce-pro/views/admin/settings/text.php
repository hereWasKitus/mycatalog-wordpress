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
        <input
            <?php //if($model['id'] === 'label') echo 'rv-on-change="field.updateKey"'; ?>
            rv-on-keyup="<?php echo $model['id'] === 'label' ? 'onLabelChange' :'onChange'; ?>"
            rv-on-change="<?php echo $model['id'] === 'label' ? 'onLabelChange' :'onChange'; ?>"
            rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
            type="text"
            <?php if(isset($model['placeholder'])) echo 'placeholder="'.$model['placeholder'].'"'; ?>
            rv-default="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>" data-default="<?php echo isset($model['default']) ? esc_attr($model['default']) : ''; ?>"
        />
    </div>
</div>