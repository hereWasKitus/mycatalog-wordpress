<?php

namespace SW_WAPF_PRO\Includes\Classes {

    if (!defined('ABSPATH')) {
        die;
    }

    class l10n
    {

        protected $language_folder = 'languages';

        public function __construct()
        {
            add_action('plugins_loaded', array($this, 'load_text_domain'));
        }

        public function load_text_domain()
        {
            load_plugin_textdomain(
                'sw-wapf',
                false,
                trailingslashit(wapf_get_setting('slug')) . trailingslashit($this->language_folder)
            );
        }
    }
}
