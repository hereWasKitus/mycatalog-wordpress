<?php
/* @var $model array */
use SW_WAPF_PRO\Includes\Classes\Helper;
use SW_WAPF_PRO\Includes\Classes\Html;
use SW_WAPF_PRO\Includes\Classes\Field_Groups;
?>

<div rv-controller="LayoutCtrl" data-layout-options="<?php echo Helper::thing_to_html_attribute_string($model['layout']); ?>"
>

    <input type="hidden" name="wapf-layout" rv-value="layoutJson" />

    <div class="wapf-layout-list">

        <div class="wapf-conditions-list__body">

            <?php

                Html::setting(array(
                    'type'              => 'select',
                    'id'                => 'labels_position',
                    'label'             => __('Label position','sw-wapf'),
                    'description'       => __('Where should the label be positioned in relation to the field?','sw-wapf'),
                    'options'           => array(
                        'above'         => __('Above the field', 'sw-wapf'),
                        'below'         => __('Below the field', 'sw-wapf'),
                        /*'left'          => __('Left from the field', 'sw-wapf'),
                        'right'         => __('Right from the field', 'sw-wapf'),*/
                    ),
                    'is_field_setting'  => false
                ));

                Html::setting(array(
                    'type'              => 'select',
                    'id'                => 'instructions_position',
                    'label'             => __('Instruction position','sw-wapf'),
                    'description'       => __('Where should the instructions be positioned?','sw-wapf'),
                    'options'           => array(
                        'label'         => __('Below the label', 'sw-wapf'),
                        'field'         => __('Below the field', 'sw-wapf'),
                    ),
                    'is_field_setting'  => false
                ));

                Html::setting(array(
                    'type'              => 'true-false',
                    'id'                => 'mark_required',
                    'label'             => __('Mark required fields','sw-wapf'),
                    'description'       => __('Add a *-symbol next to required fields.','sw-wapf'),
                    'is_field_setting'  => false
                ));

            Html::setting(array(
	            'type'              => 'gallery-image',
	            'id'                => 'gallery_images',
	            'label'             => __('Change product image','sw-wapf'),
	            'description'       => __('Should the main product image change on your product page when options are selected?','sw-wapf'),
            ));

            ?>

        </div>

    </div>
</div>