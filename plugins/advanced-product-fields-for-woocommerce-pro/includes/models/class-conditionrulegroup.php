<?php

namespace SW_WAPF_PRO\Includes\Models {

	use SW_WAPF_PRO\Includes\Classes\Enumerable;

	if (!defined('ABSPATH')) {
        die;
    }

    class ConditionRuleGroup
    {
        public $rules;

        public function __construct()
        {
            $this->rules = [];
        }

        public function get_variation_rules() {
	        return Enumerable::from($this->rules)->where(function($rule) {
		        return $rule->subject === 'product_variation' || $rule->subject === 'var_att';

	        })->toArray();
        }
    }
}