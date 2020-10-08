<?php

namespace SW_WAPF_PRO\Includes\Models {

    if (!defined('ABSPATH')) {
        die;
    }

    class ConditionalRule
    {

        public $field;

        public $condition;

        public $value;

        public $generated;

        public function __construct() {
            $this->generated = false;
        }

    }
}