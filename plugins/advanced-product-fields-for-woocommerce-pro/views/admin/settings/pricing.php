<?php
/* @var $model array */

?>

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

        <div class="wapf-toggle" rv-unique-checkbox>
            <input rv-on-change="onChange" rv-checked="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.enabled" type="checkbox" >
            <label class="wapf-toggle__label" for="wapf-toggle-">
                <span class="wapf-toggle__inner" data-true="<?php _e('Yes','sw-wapf'); ?>" data-false="<?php _e('No','sw-wapf'); ?>"></span>
                <span class="wapf-toggle__switch"></span>
            </label>
        </div>

        <div class="wapf-setting__pricing" rv-show="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.enabled">
            <div>
                <select class="wapf-pricing-list" rv-on-change="onChange" rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.type">
				    <?php
				    foreach(\SW_WAPF_PRO\Includes\Classes\Fields::get_pricing_options($model['field_type']) as $k => $v) {
					    echo '<option value="'.$k.'">'.$v.'</option>';
				    }
				    ?>
                </select>
            </div>
            <div>
                <input rv-if="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.type | neq 'fx'" placeholder="<?php _e('Amount','sw-wapf');?>" rv-on-change="onChange" type="number" step="any" rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.amount" />
                <input rv-if="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.type | eq 'fx'" placeholder="<?php _e('Enter a formula','sw-wapf');?>" rv-on-change="onChange" type="text" rv-value="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.amount" />
            </div>

        </div>

        <div style="margin-top:10px;" rv-show="<?php echo $model['is_field_setting'] ? 'field' : 'settings'; ?>.pricing.enabled">
            <a href="https://www.studiowombat.com/kb-article/all-pricing-options-explained/?ref=wapf_admin" target="_blank">
		        <?php _e('Help with pricing','sw-wapf'); ?>
            </a>
        </div>

    </div>
</div>