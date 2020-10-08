<?php /* @var $model array */ ?>

<div <?php if(!empty($model['show_if'])){echo 'rv-show="field.'.$model['show_if'].'"';}?> class="wapf-field__setting" data-setting="<?php echo $model['id']; ?>">
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
            rv-on-change="onChange"
            rv-colorpicker="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
            type="text"
            data-default-color="<?php echo isset($model['default']) ? esc_attr($model['default']) : ''; ?>"
        />
    </div>
</div>