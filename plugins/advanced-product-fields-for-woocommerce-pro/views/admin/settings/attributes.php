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
        <div style="width:48%;">
            <div class="wapf-input-prepend"><?php _e('Width','sw-wapf'); ?></div>
            <div class="wapf-input-append">%</div>
            <div class="wapf-input-with-prepend-append">
                <input
                    rv-on-keyup="onChange" min="0" max="100"
                    step="any"
                    rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.width"
                    type="number"
                />
            </div>
        </div>
        <div style="width:48%; padding-left:2%;">
            <div class="wapf-input-prepend"><?php _e('Class','sw-wapf'); ?></div>
            <div class="wapf-input-with-prepend-append">
                <input
                    rv-on-keyup="onChange"
                    rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.class"
                    type="text"
                />
            </div>
        </div>
    </div>
</div>