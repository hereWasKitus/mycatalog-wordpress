<?php

namespace SW_WAPF_PRO\Includes\Models {

    if (!defined('ABSPATH')) {
        die;
    }

    class Conditional
    {
        public $rules;

        public function __construct()
        {
            $this->rules = [];
        }
    }
}