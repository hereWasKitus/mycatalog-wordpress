<?php /* @var $model array */ ?>

<div class="wapf-field__setting" data-setting="<?php echo $model['id']; ?>">
    <div class="wapf-setting__label">
        <label><?php _e($model['label'],'sw-wapf');?></label>
        <p class="wapf-description">
            <?php _e($model['description'],'sw-wapf');?>
        </p>
    </div>
    <div class="wapf-setting__input">

        <div style="width:100%;"  class="wapf-field__conditionals">

            <div class="wapf-field__conditionals__container">
                <div rv-if="fields | hasLessThan 2" class="wapf-lighter">
                    <?php _e('You need atleast 2 fields to create conditional rules. Add another field first.','sw-wapf');?>
                </div>
                <div rv-if="fields | hasMoreThan 1">
                    <strong rv-show="field.conditionals|isNotEmpty"><?php _e('Show this field if','sw-wapf'); ?></strong>
                    <div rv-each-conditional="field.conditionals">
                        <table style="padding-bottom:10px;width:100%;" class="wapf-field__conditional">
                            <tr class="conditional__rule" rv-each-rule="conditional.rules">
                                <td style="width: 33%">
                                    <select rv-on-change="onConditionalFieldChange" rv-value="rule.field">
                                        <option rv-each-fieldobj="fields | query 'where' 'group' '==' 'field' 'where' 'id' '!=' field.id" rv-value="fieldobj.id">{fieldobj.label}</option>
                                    </select>
                                </td>
                                <td style="width: 20%">
                                    <select rv-on-change="onChange" rv-value="rule.condition">
                                        <option rv-each-condition="availableConditions | filterConditions rule.field fields" rv-value="condition.value">{ condition.label }</option>
                                    </select>
                                </td>
                                <td>
                                    <input rv-if="rule.condition | conditionNeedsValue availableConditions 'text' fields rule.field" rv-on-keyup="onChange" type="text" rv-value="rule.value" />
                                    <input rv-if="rule.condition | conditionNeedsValue availableConditions 'number' fields rule.field" step="any" rv-on-change="onChange" rv-on-keyup="onChange" type="number" rv-value="rule.value" />
                                    <select rv-if="rule.condition | conditionNeedsValue availableConditions 'options' fields rule.field" rv-on-change="onChange" rv-value="rule.value">
                                        <option rv-each-v="fields | query 'first' 'id' '===' rule.field 'get' 'choices'" rv-value="v.slug">{v.label}</option>
                                    </select>
                                    <input rv-if="rule.condition | conditionDoesntNeedValue availableConditions fields rule.field" disabled type="text"/>
                                </td>
                                <td style="width: 40px">
                                    <a href="#" rv-show="conditional.rules | isLastIteration $index " rv-on-click="addRule" class="button button-small">+ <?php _e('And','sw-wapf'); ?></a>
                                </td>
                                <td style="width: 30px">
                                    <a href="#" title="<?php _e('Delete','sw-wapf');?>" rv-on-click="deleteRule" class="wapf-button--tiny-rounded btn-del">&times;</a>
                                </td>
                            </tr>
                        </table>
                        <div rv-if="$index | lt field.conditionals"><b><?php _e('Or','sw-wapf');?></b></div>
                    </div>
                    <div style="padding-top: 5px;">
                        <a href="#" rv-on-click="addConditional" class="button button-small"><?php _e('Add new rule group','sw-wapf'); ?></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>