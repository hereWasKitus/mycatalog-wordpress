<?php
    /** @var \SW_WAPF_PRO\Includes\Models\FieldGroup $field_group */
    /** @var WC_Product $product */
    use \SW_WAPF_PRO\Includes\Classes\Html;
    use \SW_WAPF_PRO\Includes\Classes\Helper;
    $label_position = isset($field_group->layout['labels_position']) ? $field_group->layout['labels_position'] : 'above';
    $instructions_position = isset($field_group->layout['instructions_position']) ? $field_group->layout['instructions_position'] : 'field';
    $mark_required = isset($field_group->layout['mark_required']) && $field_group->layout['mark_required'];

    ?>

<div
    class="wapf-field-group"
    data-group="<?php echo $field_group->id; ?>"
    data-variables="<?php echo Helper::thing_to_html_attribute_string($field_group->variables); ?>"
    <?php if($field_group->has_gallery_image_rules()) { ?>
        data-wapf-st="<?php echo isset($field_group->layout['swap_type']) ? esc_attr($field_group->layout['swap_type']) : 'rules';?>"
        data-wapf-gi="<?php echo Helper::thing_to_html_attribute_string($field_group->get_gallery_image_rules()); ?>"
    <?php } ?>
>
    <?php
    $openSections = 0;
    foreach($field_group->fields as $field) {

	    $hasWidth = true;
	    $width = empty($field->width) ? 100 : floatval($field->width);
	    if($width === 100)
		    $hasWidth = false;

	    if($field->type === 'section') {
	        $openSections++;
		    echo '<div class="'.Html::section_container_classes($field).'" for="'.$field->id.'" style="width: '.$width.'%;" '.(!empty($field->conditionals) ? 'data-wapf-d="'.Helper::thing_to_html_attribute_string($field->conditionals).'"' : '').' '.Html::field_container_attributes($field).'>';
		    continue;
	    }
	    if($field->type === 'sectionend') {
	        $openSections--;
		    echo '</div>';
		    continue;
	    }

	    echo '<div class="'. Html::field_container_classes($field,$product) . ($hasWidth ? ' has-width' : '') . '" style="width:'.$width.'%;" ' . Html::field_container_attributes($field).' >';

	    if(!empty($field->label) && ($label_position === 'above' || $label_position === 'left')) {
		    echo sprintf(
			    '<div class="wapf-field-label wapf--%s"><label>%s</label></div>%s',
			    $label_position,
			    Html::field_label($field,$product,$mark_required),
			    $instructions_position === 'label' ? Html::field_description($field) : ''
		    );
	    }

	    echo '<div class="wapf-field-input">'. Html::field($product,$field,$field_group->id) .'</div>';

	    if($instructions_position === 'field')
		    echo Html::field_description($field);

	    if(!empty($field->label) && ($label_position === 'below' || $label_position === 'right')) {
		    echo sprintf(
			    '<div class="wapf-field-label wapf--%s"><label>%s</label></div>%s',
			    $label_position,
			    Html::field_label($field,$product,$mark_required),
			    $instructions_position === 'label' ? Html::field_description($field) : ''
		    );
	    }

	    echo '</div>'; // Closing the "wapf-field-container"
    }

    for($i=0;$i<$openSections;$i++) {
        echo '</div>'; // closing sections that don't have an "section end" set on the backend.
    }
    ?>

</div>