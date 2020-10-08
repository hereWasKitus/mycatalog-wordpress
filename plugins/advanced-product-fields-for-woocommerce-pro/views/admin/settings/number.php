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
        <?php if(!empty($model['postfix'])) { ?>
            <div class="wapf-input-with-append">
        <?php } ?>

        <input
            <?php //if($model['id'] === 'label') echo 'rv-on-change="field.updateKey"'; ?>
            rv-on-keyup="onChange" rv-on-change="onChange"
            <?php if(isset($model['min'])) echo ' min="'.$model['min'].'" '; ?>
            <?php if(isset($model['max'])) echo ' max="'.$model['max'].'" '; ?>
            rv-default="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>" data-default="<?php echo isset($model['default']) ? esc_attr($model['default']) : ''; ?>"
            rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
            type="number"
            step="any"
            placeholder="<?php echo empty($model['placeholder']) ? '' : esc_attr($model['placeholder']); ?>"
        />
        <?php if(!empty($model['postfix'])) { ?>
            <div class="wapf-input-append"><?php echo $model['postfix']; ?></div>
            </div>
        <?php } ?>
    </div>
</div>