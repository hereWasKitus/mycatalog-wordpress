<?php
/* @var $model array */
use SW_WAPF_PRO\Includes\Classes\Helper;
?>

<div rv-controller="ConditionsCtrl"
     data-raw-conditions="<?php echo Helper::thing_to_html_attribute_string($model['conditions']); ?>"
     data-fieldgroup-conditions="<?php echo Helper::thing_to_html_attribute_string($model['condition_options']); ?>"
     data-wapf-type="<?php echo $model['post_type']; ?>"
>

    <input type="hidden" name="wapf-conditions" rv-value="conditionsJson" />
    <input type="hidden" name="wapf-fieldgroup-type" value="<?php echo $model['post_type'];?>" />

    <div class="wapf-conditions-list">

        <div class="wapf-conditions-list__body">

            <div class="wapf-field__setting">
                <div class="wapf-setting__label">
                    <label><?php _e('Rules','sw-wapf');?></label>
                    <p class="wapf-description">
                        <?php _e("Add a set of rules to determine when this field group should appear.",'sw-wapf');?>
                    </p>
                </div>
                <div class="wapf-setting__input">
                    <div rv-show="rulegroups | isEmpty" class="wapf-list--empty" style="display: <?php echo empty($model['conditions']) ? 'block' : 'none';?>;">
                        <a href="#" class="button button-primary button-large" rv-on-click="addRuleGroup"><?php _e('Add your first rule','sw-wapf'); ?></a>
                        <div style="text-align: center;padding-top:10px">
                            <?php _e('If you don\'t add any rules, this field group will display on every product.','sw-wapf'); ?>
                        </div>
                    </div>

                    <div style="width: 100%;" rv-each-group="rulegroups" rv-cloak rv-class="$index | prefix 'wapf-rulegroup-'">

                        <div style="padding:5px;" rv-if="$index | gt 0"><b><?php _e('Or','sw-wapf');?></b></div>

                        <table style="width: 100%">
                            <tr rv-each-rule="group.rules" rv-class="$index | prefix 'wapf-rulegroup-rule-'">
                                <td style="width: 21%;">
                                    <select rv-on-change="onChangeRuleSubject" rv-value="rule.subject">
                                        <optgroup rv-each-group="activeConditionOptions" rv-label="group.group">
                                            <option rv-each-option="group.children" rv-value="option.id">{option.label}</option>
                                        </optgroup>
                                    </select>
                                </td>
                                <td style="width:24%;">
                                    <select rv-on-change="setSelectedCondition" rv-value="rule.condition">
                                        <option rv-each-condition="rule.options.conditions" rv-value="condition.id">{condition.label}</option>
                                    </select>
                                </td>
                                <td style="width:40%;max-width: 450px;">
                                    <div rv-if="rule.selectedCondition.value.type | eq 'text'">
                                        <input rv-on-change="onChange" type="text" rv-value="rule.value" />
                                    </div>
                                    <div rv-if="rule.selectedCondition.value.type | eq 'number'">
                                        <input rv-on-change="onChange" type="number" step="1" rv-value="rule.value" />
                                    </div>
                                    <div rv-if="rule.selectedCondition.value.type | eq 'select'">
                                        <select rv-on-change="onChange" rv-value="rule.value">
                                            <option rv-each-option="rule.selectedCondition.value.data" rv-value="option.id">{option.text}</option>
                                        </select>
                                    </div>
                                    <div rv-if="rule.selectedCondition.value.type | eq 'select2'">
                                        <select
                                            rv-select2options="rule.value"
                                            rv-on-change="onChange"
                                            rv-select2="rule.value"
                                            class="wapf-select2"
                                            multiple="multiple"
                                            rv-data-select2-placeholder="rule.selectedCondition.value.placeholder"
                                            rv-data-select2-action="rule.selectedCondition.value.action"
                                            rv-data-select2-prefill="rule.selectedCondition.value.data|tostring"
                                            rv-data-select2-single="rule.selectedCondition.value.single"
                                        >
                                        </select>
                                    </div>

                                </td>
                                <td style="width:15%; text-align: right;">
                                    <a href="#" rv-show="group.rules | isLastIteration $index " rv-on-click="addRule" class="button button-small"><?php _e('And','sw-wapf'); ?></a>
                                    <a href="#" rv-on-click="deleteRule" class="button button-small">x</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div rv-cloak style="width:100%;">
                        <div class="wapf-conditions-list__footer" rv-show="rulegroups | isNotEmpty">
                            <a href="#" class="button button-primary button-large" rv-on-click="addRuleGroup"><?php _e('Or','sw-wapf'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>