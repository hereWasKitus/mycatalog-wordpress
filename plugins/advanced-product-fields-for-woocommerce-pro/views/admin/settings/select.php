<?php /* @var $model array */ ?>

<div <?php if(!empty($model['show_if'])){echo 'rv-show="field.'.$model['show_if'].'"';}?>  class="wapf-field__setting" data-setting="<?php echo $model['id']; ?>">
    <div class="wapf-setting__label">
        <label><?php _e($model['label'],'sw-wapf');?></label>
        <?php if(isset($model['description'])) { ?>
            <p class="wapf-description">
                <?php _e($model['description'],'sw-wapf');?>
            </p>
        <?php } ?>
    </div>
    <div class="wapf-setting__input">
        <select
            <?php echo isset($model['multiple']) && $model['multiple'] ? 'multiple="multiple"' : ''; ?>
                rv-default="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
                data-default="<?php echo isset($model['default']) ? esc_attr($model['default']) : ''; ?>"
                rv-on-change="<?php echo $model['id'] === 'type' ? 'onChangeType' : 'onChange'; ?>"
                rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
            <?php if(isset($model['select2']) && $model['select2']) { ?>
                rv-select2-basic="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.<?php echo $model['id']; ?>"
            <?php } ?>
            <?php if(isset($model['select2_source'])) { ?>
                data-source="<?php echo esc_attr($model['select2_source']); ?>"
	        <?php } ?>
        >
            <?php
                if(isset($model['options']))
                    foreach($model['options'] as $value => $label) {
                        if(is_array($label)) {
                            echo '<optgroup label="' . $value . '">';
                            foreach ($label as $v => $l) {
                                echo '<option value="'.$v.'">'.$l.'</option>';
                            }
                            echo '</optgroup>';
                        } else echo '<option value="'.$value.'">'.$label.'</option>';

                    }
            ?>
        </select>
        <?php if(isset($model['note'])) { ?>
            <div style="padding-top:10px;">
                <?php echo wp_kses($model['note'], array('b' => array(), 'em' => array(), 'i' => array(),'strong' => array())); ?>
            </div>
        <?php } ?>
    </div>
</div>