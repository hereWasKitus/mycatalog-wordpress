<?php

namespace SW_WAPF_PRO\Includes\Models {

	use SW_WAPF_PRO\Includes\Classes\Enumerable;

	if (!defined('ABSPATH')) {
        die;
    }

    class FieldGroup
    {
        public $id;

        public $type;

        public $rules_groups;

        public $fields;

        public $layout;

        public $variables;

        public function __construct()
        {
            $this->type = 'wapf_product';
            $this->rules_groups = [];
            $this->fields = [];
            $this->variables = [];

            $this->layout = array(
                'labels_position'       => 'above',
                'instructions_position' => 'field',
                'mark_required'         => true,
	            'enable_gallery_images' => false,
	            'gallery_images'        => array()
            );
        }

        public function from_array($a) {
			$this->id = $a['id'];
			$this->type = $a['type'];
			$this->layout = isset($a['layout']) ? $a['layout'] : array();
			$this->variables = isset($a['variables']) ? $a['variables'] : array();

			foreach($a['rule_groups'] as $rg) {
				$rulegroup = new ConditionRuleGroup();
				foreach($rg['rules'] as $r) {
					$rule = new ConditionRule();
					$rule->value = $r['value'];
					$rule->condition = $r['condition'];
					$rule->subject = $r['subject'];
					$rulegroup->rules[] = $rule;
				}
				$this->rules_groups[] = $rulegroup;
			}

			foreach($a['fields'] as $f) {
				$field = new Field();
				$this->fields[] = $field->from_array($f);
			}

			return $this;
        }

        public function to_array() {
			$a = [
				'id'            => $this->id,
				'type'          => $this->type,
				'layout'        => $this->layout,
				'variables'     => $this->variables,
				'fields'        => [],
				'rule_groups'   => [],
			];

			foreach($this->fields as $f) {
				$a['fields'][] = $f->to_array();
			}

			foreach($this->rules_groups as $rule_group) {
				$rg = ['rules' => []];
				foreach($rule_group->rules as $rule) {
					$r = [
						'value'     => $rule->value,
						'condition' => $rule->condition,
						'subject'   => $rule->subject
					];
					$rg['rules'][] = $r;
				}
				$a['rule_groups'][] = $rg;
			}

			return $a;
		}

        public function has_gallery_image_rules() {

        	if(!isset($this->layout['enable_gallery_images']))
        		return false;

        	return $this->layout['enable_gallery_images'] === true && count($this->layout['gallery_images']) > 0;
        }

        public function get_field($id){
        	foreach ($this->fields as $field) {
        		if($field->id === $id)
        			return $field;
	        }
        	return null;
        }

        public function has_variables(){
        	return !empty($this->variables);
        }

        public function get_gallery_image_rules() {

        	$result = array(
        		'images'    => array(),
		        'rules'     => array(),
	        );

        	foreach ($this->layout['gallery_images'] as $gallery_image) {

        		if(empty($gallery_image['id']) || empty($gallery_image['values']))
        			continue;

        		$result['rules'][] = array(
        			'values'    => $gallery_image['values'],
			        'image'     => $gallery_image['id']
		        );

        		if($gallery_image['source'] === 'upload' && !Enumerable::from($result['images'])->any(function($x) use ($gallery_image){ return $x['image_id'] === $gallery_image['id']; }))
        			$result['images'][] = array_merge( wc_get_product_attachment_props($gallery_image['id']), array('image_id' => $gallery_image['id']) );

        	}

        	return $result;

        }
    }
}