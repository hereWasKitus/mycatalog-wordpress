<?php

namespace SW_WAPF_PRO\Includes\Models {

    use SW_WAPF_PRO\Includes\Classes\Enumerable;

    if (!defined('ABSPATH')) {
        die;
    }

    class Field
    {

        public $id;

        public $key;

        public $label;

        public $description;

        public $type;

        public $required;

        public $options;

        public $conditionals;

        public $class;

        public $width;

        public $pricing;

        public $qty_based;

        public $parent_qty_based;

        public $clone_txt;

	    public $tax; 

        public function __construct()
        {
            $this->label = '';
            $this->required = false;
            $this->options = [];
            $this->conditionals = [];
            $this->pricing = new FieldPricing();
            $this->qty_based = false;
            $this->parent_qty_based = false;
        }

        public function from_array($a) {

        	$this->id = $a['id'];
        	$this->label = $a['label'];
        	$this->description = $a['description'];
        	$this->type = $a['type'];
        	$this->required = $a['required'];
        	$this->class = $a['class'];
        	$this->width = $a['width'];
        	$this->qty_based = isset($a['qty_based']) ? $a['qty_based'] : false;
        	$this->parent_qty_based = isset($a['parent_qty_based']) ? $a['parent_qty_based'] : false;
        	$this->clone_txt = isset($a['clone_txt']) ? $a['clone_txt'] : '';
        	$this->options = $a['options'];
        	$p = new FieldPricing();
        	$p->type = $a['pricing']['type'];
        	$p->enabled = $a['pricing']['enabled'];
        	$p->amount = $a['pricing']['amount'];
        	$this->pricing = $p;

        	foreach($a['conditionals'] as $c) {
        		$cond = new Conditional();
        		foreach($c['rules'] as $r) {
        			$rule = new ConditionalRule();
        			$rule->condition = $r['condition'];
        			$rule->value = $r['value'];
        			$rule->generated = $r['generated'];
        			$rule->field = $r['field'];
        			$cond->rules[] = $rule;
		        }
        		$this->conditionals[] = $cond;
	        }

        	return $this;

        }

        public function to_array() {
        	$a = array(
        		'id'                => $this->id,
        		'label'             => $this->label,
		        'description'       => $this->description,
		        'type'              => $this->type,
		        'required'          => $this->required,
		        'class'             => $this->class,
		        'width'             => $this->width,
		        'qty_based'         => $this->qty_based,
		        'parent_qty_based'  => $this->parent_qty_based,
		        'clone_txt'         => $this->clone_txt,
		        'options'           => $this->options,
		        'conditionals'      => [],
		        'pricing'           => [
		        	'type'          => $this->pricing->type,
			        'amount'        => $this->pricing->amount,
			        'enabled'       => $this->pricing->enabled
		        ]
	        );

        	foreach ($this->conditionals as $conditional) {
        		$c = ['rules' => [] ];

        		foreach ($conditional->rules as $rule) {
        			$r = [
        				'condition' => $rule->condition,
				        'value'     => $rule->value,
				        'field'     => $rule->field,
				        'generated' => $rule->generated
			        ];
        			$c['rules'][] = $r;
		        }

        		$a['conditionals'][] = $c;

	        }

        	return $a;

        }

        public function get_label() {

        	if(!empty($this->label))
        		return $this->label;

        	if($this->type === 'true-false' && !empty($this->options['message']))
        		return $this->options['message'];

        	return __('N/a','sw-wapf');

        }

        public function get_option($key,$default = null) {
        	if(isset($this->options[$key]))
        		return $this->options[$key];
        	return $default;
        }

        public function is_choice_field(){
            return in_array($this->type, array('select','checkboxes','radio','image-swatch','multi-image-swatch','color-swatch','multi-color-swatch','text-swatch','multi-text-swatch'));
        }

        public function is_multichoice_field() {
	        return in_array($this->type, array('checkboxes','multi-image-swatch','multi-color-swatch','multi-text-swatch'));
        }

        public function is_normal_field() {
        	return !$this->is_content_field() && !$this->is_layout_field();
        }

        public function is_content_field() {
        	return in_array($this->type, array('p','img'));
        }

        public function is_layout_field(){
	        return in_array($this->type, array('section','sectionend'));
        }

        public function has_conditionals() {
        	return count($this->conditionals) > 0;
        }

        public function is_field_or_parent_qty_based() {
        	return $this->qty_based || $this->parent_qty_based;
        }

        public function pricing_enabled() {

            if($this->is_choice_field() && !empty($this->options['choices']))
                return Enumerable::from($this->options['choices'])->any(function($choice){
                    return isset($choice['pricing_type']) && $choice['pricing_type'] !== 'none';
                });

            return $this->pricing->enabled;

        }

    }
}