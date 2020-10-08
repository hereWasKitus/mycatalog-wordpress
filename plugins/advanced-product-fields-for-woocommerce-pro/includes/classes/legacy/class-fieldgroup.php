<?php

namespace SW_WAPF\Includes\Models {

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

        public function __construct()
        {
            $this->type = 'wapf_product';
            $this->rules_groups = [];
            $this->fields = [];

            $this->layout = array(
                'labels_position'       => 'above',
                'instructions_position' => 'field',
                'mark_required'         => true
            );
        }
    }
}