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
        <div style="width: 100%;" rv-show="field.choices | isNotEmpty">
            <div class="wapf-options__header">
                <div class="wapf-option__sort"></div>
                <div class="wapf-option__flex"><?php _e('Option label','sw-wapf'); ?></div>
                <!--<td style="font-weight:500;text-align: left;"><?php _e('Unique key','sw-wapf'); ?></td>-->
                <?php if(isset($model['show_pricing_options']) && $model['show_pricing_options']) { ?>
                    <div class="wapf-option__flex"><?php _e('Adjust pricing','sw-wapf'); ?></div>
                    <div class="wapf-option__flex"><?php _e('Pricing amount','sw-wapf'); ?></div>
                <?php } ?>
                <div class="wapf-option__selected"><?php _e('Selected', 'sw-wapf'); ?></div>
                <div  class="wapf-option__delete"></div>
            </div>
            <div rv-sortable-options="field.choices" class="wapf-options__body">
                <div class="wapf-option" rv-each-choice="field.choices" rv-data-option-slug="choice.slug">
                    <div class="wapf-option__sort"><span rv-sortable-option class="wapf-option-sort">☰</span></div>
                    <div class="wapf-option__flex"><input rv-on-keyup="onChange" rv-on-change="onChange" type="text" class="choice-label" rv-value="choice.label"/></div>
                    <?php if(isset($model['show_pricing_options']) && $model['show_pricing_options']) { ?>
                        <div class="wapf-option__flex">
                            <select class="wapf-pricing-list" rv-on-change="onChange" rv-value="choice.pricing_type">
                                <option value="none"><?php _e('No price change','sw-wapf'); ?></option>
                                <?php
                                foreach(\SW_WAPF_PRO\Includes\Classes\Fields::get_pricing_options() as $k => $v) {
                                    echo '<option value="'.$k.'">'.$v.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="wapf-option__flex">
                            <input rv-if="choice.pricing_type | eq 'fx'" placeholder="<?php _e('Enter a formula','sw-wapf');?>" rv-on-change="onChange" type="text" rv-value="choice.pricing_amount" />
                            <input rv-if="choice.pricing_type | neq 'fx'" placeholder="<?php _e('Amount','sw-wapf');?>" rv-on-change="onChange" type="number" step="any" rv-value="choice.pricing_amount" />
                        </div>
                    <?php } ?>
                    <div class="wapf-option__selected" style="text-align: right;"><input data-multi-option="<?php echo isset($model['multi_option']) ? $model['multi_option'] : '0' ;?>" rv-on-change="field.checkSelected" rv-checked="choice.selected" type="checkbox" /></div>
                    <div class="wapf-option__delete"><a href="#" rv-on-click="field.deleteChoice" class="wapf-button--tiny-rounded">&times;</a></div>
                </div>
            </div>
        </div>

        <div style="padding-top:12px;text-align: right;width: 100%;">
            <a href="#" rv-on-click="field.addChoice" class="button button-small"><?php _e('Add option','sw-wapf'); ?></a>
        </div>
        <div style="text-align: right;width: 100%;margin-top:10px;">
            <a href="https://www.studiowombat.com/kb-article/all-pricing-options-explained/?ref=wapf_admin" target="_blank">
                <?php _e('Help with pricing','sw-wapf'); ?>
            </a>
        </div>
    </div>
</div>