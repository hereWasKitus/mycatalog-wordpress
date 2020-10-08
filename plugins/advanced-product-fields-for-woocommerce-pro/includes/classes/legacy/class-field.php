<?php

namespace SW_WAPF\Includes\Models {

    use SW_WAPF\Includes\Classes\Enumerable;
    use SW_WAPF\Includes\Classes\Helper;

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

        public function __construct()
        {
            $this->label = '';
            $this->options = [];
            $this->conditionals = [];
            $this->pricing = new FieldPricing();
        }

        public function is_choice_field(){
            return in_array($this->type, array('select','checkboxes','radio'));
        }

        public function pricing_enabled() {

            if(!empty($this->options['choices']))
                return Enumerable::from($this->options['choices'])->any(function($choice){
                    return isset($choice['pricing_type']) && $choice['pricing_type'] !== 'none';
                });

            return $this->pricing->enabled;

        }

    }
}