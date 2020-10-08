<?php
/* @var $model array */
use SW_WAPF_PRO\Includes\Classes\Helper;
?>
<div rv-controller="VariablesCtrl" data-variables="<?php echo Helper::thing_to_html_attribute_string($model['variables']); ?>">
    <input type="hidden" name="wapf-variables" rv-value="json" />

    <div style="padding:0 25px;" rv-show="variables|isNotEmpty">
        <div rv-each-variable="variables" class="variable__wrapper" rv-data-variable-id="variable.name">
            <div class="variable__header" rv-on-click="setActiveVariable">
                <div class="variable__icon">
                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95 95"><path d="M93.779,63.676c-0.981-1.082-2.24-1.653-3.639-1.653c-1.145,0-3.953,0.396-5.318,4.062 c-0.344,0.922-0.443,1.413-0.907,1.363c-0.786-0.078-3.845-3.346-4.845-8.145l-2.482-11.6c1.961-3.177,3.977-5.629,5.988-7.292 c1.08-0.882,2.314-1.349,3.808-1.43c3.815-0.26,5.203-0.74,6.14-1.399c1.547-1.115,2.397-2.728,2.397-4.542 c0-1.596-0.604-3.019-1.75-4.115c-1.106-1.059-2.581-1.618-4.26-1.618c-2.468,0-5.239,1.142-8.474,3.49 c-1.91,1.388-3.935,3.406-6.121,6.111c-0.711-2.653-1.319-3.889-1.771-4.628c-1.396-2.303-3.664-2.303-4.41-2.303l-0.813,0.013 l-23.045,0.544l1.297-5.506c0.828-3.593,1.915-6.436,3.226-8.45c0.638-0.98,1.614-2.148,2.638-2.148 c0.387,0,1.152,0.063,2.582,0.36c3.978,0.86,5.465,0.959,6.239,0.959c1.708,0,3.21-0.571,4.347-1.651 c1.176-1.119,1.797-2.583,1.797-4.233c0-1.29-0.424-3.156-2.445-4.722c-1.396-1.081-3.311-1.629-5.691-1.629 c-3.568,0-7.349,1.141-11.241,3.39c-3.862,2.232-7.038,5.317-9.438,9.171c-2.105,3.379-3.929,8.124-5.555,14.459H21.877 l-2.238,8.831h10.186l-7.74,31.116c-1.603,6.443-2.777,8.028-3.098,8.361c-0.875,0.904-2.68,1.094-4.04,1.094 c-1.683,0-3.477-0.121-5.349-0.361c-1.286-0.157-2.265-0.234-2.991-0.234c-1.878,0-3.423,0.488-4.59,1.448 C0.716,81.858,0,83.403,0,85.14c0,1.357,0.44,3.309,2.539,4.895c1.434,1.08,3.389,1.628,5.813,1.628 c6.069,0,11.725-2.411,16.813-7.165c4.947-4.624,8.571-11.413,10.773-20.195l6.119-24.935l20.87,0.354l2.244,9.64l-4.573,6.748 c-0.824,1.209-2.051,2.701-3.658,4.441c-0.84,0.92-1.398,1.426-1.721,1.689c-1.316-1.608-2.809-2.424-4.432-2.424 c-1.525,0-2.91,0.625-4.002,1.804c-1.036,1.116-1.583,2.514-1.583,4.038c0,1.83,0.783,3.459,2.264,4.709 c1.357,1.146,3.034,1.728,4.981,1.728c2.414,0,4.884-0.921,7.344-2.737c2.053-1.519,4.697-4.526,8.074-9.189 c2.17,6.24,5.248,10.252,6.714,11.927c2.313,2.644,6.049,4.22,9.993,4.22c3.348,0,5.244-1.402,6.916-2.641l0.148-0.109 c2.926-2.164,3.54-4.545,3.54-6.166C95.174,65.965,94.691,64.679,93.779,63.676z"/></svg>
                </div>
                <div class="variable__name">
                    var_{variable.name}
                </div>
                <div class="variable__actions">
                    <div class="wapf__action_icon" rv-on-click="deleteVariable" title="<?php _e('Delete variable','sw-wapf');?>">
                        <svg height="16" width="16" viewBox="0 0 16 16"><path d="M13 3s0-0.51-2-0.8v-0.7c-0.017-0.832-0.695-1.5-1.53-1.5-0 0-0 0-0 0h-3c-0.815 0.017-1.47 0.682-1.47 1.5 0 0 0 0 0 0v0.7c-0.765 0.068-1.452 0.359-2.007 0.806l-0.993-0.006v1h12v-1h-1zM6 1.5c0.005-0.274 0.226-0.495 0.499-0.5l3.001-0c0 0 0.001 0 0.001 0 0.282 0 0.513 0.22 0.529 0.499l0 0.561c-0.353-0.042-0.763-0.065-1.178-0.065-0.117 0-0.233 0.002-0.349 0.006-0.553-0-2.063-0-2.503 0.070v-0.57z" ></path><path d="M2 5v1h1v9c1.234 0.631 2.692 1 4.236 1 0.002 0 0.003 0 0.005 0h1.52c0.001 0 0.003 0 0.004 0 1.544 0 3.002-0.369 4.289-1.025l-0.054-8.975h1v-1h-12zM6 13.92q-0.51-0.060-1-0.17v-6.75h1v6.92zM9 14h-2v-7h2v7zM11 13.72c-0.267 0.070-0.606 0.136-0.95 0.184l-0.050-6.904h1v6.72z" ></path></svg>
                    </div>

                </div>
            </div>
            <div class="variable__body">
                <div class="wapf-field__setting">
                    <div class="wapf-setting__label">
                        <label>
                            <?php _e('Variable name','sw-wapf');?>
                        </label>
                        <p class="wapf-description">
                            <?php _e('A unique key to identify your variable. Use this key in pricing formulas.','sw-wapf'); ?>
                        </p>
                    </div>
                    <div class="wapf-setting__input">
                        <div>
                            <div class="wapf-input-prepend">var_</div>
                            <div class="wapf-input-with-prepend-append">
                                <input type="text" rv-value="variable.name" rv-on-keyup="onChangeVariableName"  />
                            </div>
                        </div>
                        <p style="opacity:.7;width: 100%"><?php _e('Should only contain letters, numbers, or underscores.','sw-wapf'); ?></p>
                    </div>
                </div>
                <div class="wapf-field__setting">
                    <div class="wapf-setting__label">
                        <label>
                            <?php _e('Standard value','sw-wapf');?>
                        </label>
                        <p class="wapf-description">
                            <?php _e('The default value of your variable.','sw-wapf'); ?>
                        </p>
                    </div>
                    <div class="wapf-setting__input">
                        <input type="text" rv-value="variable.default" rv-on-change="onChange"  />
                        <p style="opacity:.7"><?php _e('This should be a number or a formula.','sw-wapf'); ?></p>
                    </div>
                </div>
                <div class="wapf-field__setting">
                    <div class="wapf-setting__label">
                        <label>
                            <?php _e('Value changes','sw-wapf');?>
                        </label>
                        <p class="wapf-description">
                            <?php _e('Add rules when the value of this variable should change.','sw-wapf'); ?>
                        </p>
                    </div>
                    <div class="wapf-setting__input">
                        <div class="variable_rule__wrapper">

                            <table>
                                <tr rv-each-variablerule="variable.rules">
                                    <td>
                                        <strong><?php _e('If this happens','sw-wapf'); ?></strong>
                                        <select rv-on-change="onVariableRuleTypeChange" rv-value="variablerule.type">
                                            <option rv-disabled="canAddFieldToVariableRule|neq true" value="field"><?php _e('Field value changes','sw-wapf');?></option>
                                            <option value="qty"><?php _e('Product quantity changes','sw-wapf');?></option>
                                        </select>
                                    </td>
                                    <td rv-show="variablerule.type|eq 'qty'">
                                        <strong><?php _e('And quantity','sw-wapf'); ?></strong>
                                        <select rv-value="variablerule.condition" rv-on-change="onChange">
                                            <option value="=="><?php _e(' is equal to','sw_wapf'); ?></option>
                                            <option value="!="><?php _e('is not equal to','sw_wapf'); ?></option>
                                            <option value="gt"><?php _e('is greater than','sw_wapf'); ?></option>
                                            <option value="lt"><?php _e('is lesser than','sw_wapf'); ?></option>
                                        </select>
                                    </td>
                                    <td rv-show="variablerule.type|eq 'qty'">
                                        <input step="any" min="1" rv-on-change="onChange" rv-on-keyup="onChange" type="number" rv-value="variablerule.value" />
                                    </td>
                                    <td rv-show="variablerule.type|eq 'qty'">&nbsp;</td>
                                    <td rv-show="variablerule.type |eq 'field'" style="width: 20%;">
                                        <strong><?php _e('This field changes','sw-wapf'); ?></strong>
                                        <select rv-value="variablerule.field" rv-on-change="onChange" >
                                            <option rv-each-field="fields" rv-value="field.id">{field.label}</option>
                                        </select>
                                    </td>
                                    <td rv-show="variablerule.type |eq 'field'" style="width: 20%">
                                        <select rv-value="variablerule.condition" rv-on-change="onChange" >
                                            <option rv-each-condition="availableConditions | filterConditions variablerule.field fields" rv-value="condition.value">{ condition.label }</option>
                                        </select>
                                    </td>
                                    <td rv-show="variablerule.type |eq 'field'" style="width: 20%;">
                                        <input rv-if="variablerule.condition | conditionNeedsValue availableConditions 'text' fields variablerule.field" rv-on-keyup="onChange" type="text" rv-value="variablerule.value" />
                                        <input rv-if="variablerule.condition | conditionNeedsValue availableConditions 'number' fields variablerule.field" step="any" rv-on-change="onChange" rv-on-keyup="onChange" type="number" rv-value="variablerule.value" />
                                        <select rv-if="variablerule.condition | conditionNeedsValue availableConditions 'options' fields variablerule.field" rv-on-change="onChange" rv-value="variablerule.value">
                                            <option rv-each-v="fields | query 'first' 'id' '===' variablerule.field 'get' 'choices'" rv-value="v.slug">{v.label}</option>
                                        </select>
                                        <input rv-if="variablerule.condition | conditionDoesntNeedValue availableConditions fields variablerule.field" disabled type="text"/>
                                    </td>
                                    <td>
                                        <strong><?php _e('Variable value is','sw-wapf');?></strong>
                                        <input type="text" rv-value="variablerule.variable" rv-on-change="onChange"/>
                                    </td>
                                    <td style="width: 30px">
                                        <a href="#" title="<?php _e('Delete','sw-wapf');?>" rv-on-click="deleteVariableRule" class="wapf-button--tiny-rounded btn-del">&times;</a>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div style="padding-top:15px;">
                            <a href="#" rv-on-click="addVariableRule" class="button button-small"><?php _e('Add new rule','sw-wapf'); ?></a>
                            <div style="padding-top:10px;" rv-hide="canAddFieldToVariableRule">
                                <?php _e('If you add some fields to this field group first, you can also change this variable when a field value changes!','sw-wapf'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wapf-list--empty">
        <a href="#" class="button button-primary button-large" rv-on-click="addEmptyVariable"><?php _e('Add new variable','sw-wapf'); ?></a>
        <div rv-show="variables|isEmpty" style="text-align: center;padding-top:13px">
            <?php _e('Dynamic variables can make complex pricing easier.','sw-wapf'); ?>
        </div>
    </div>

</div>