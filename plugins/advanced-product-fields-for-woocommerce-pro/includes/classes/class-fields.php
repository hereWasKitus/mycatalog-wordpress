<?php

namespace SW_WAPF_PRO\Includes\Classes {


    use SW_WAPF_PRO\Includes\Models\Field;
	use SW_WAPF_PRO\Includes\Models\FieldGroup;

	class Fields
    {

        public static function get_field_types($how = false) {

        	$fields = array(
        		array(
        			'id'            => 'text',
			        'title'         => __('Text','sw-wapf'),
			        'description'   => __('A single-line input field.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="18" width="18" viewBox="0 0 16 16"><path d="M16 5c0-0.6-0.4-1-1-1h-14c-0.6 0-1 0.4-1 1v6c0 0.6 0.4 1 1 1h14c0.6 0 1-0.4 1-1v-6zM15 11h-14v-6h14v6z" ></path><path d="M2 6h1v4h-1v-4z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'textarea',
			        'title'         => __('Text Area','sw-wapf'),
			        'description'   => __('A multi-line text field.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M2 2h1v4h-1v-4z" ></path><path d="M1 0c-0.6 0-1 0.4-1 1v14c0 0.6 0.4 1 1 1h15v-16h-15zM13 15h-12v-14h12v14zM15 15v0h-1v-1h1v1zM15 13h-1v-10h1v10zM15 2h-1v-1h1v1z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'number',
			        'title'         => __('Number','sw-wapf'),
			        'description'   => __('A number input field', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M15 6v-2h-2.6l0.6-2.8-2-0.4-0.7 3.2h-3l0.7-2.8-2-0.4-0.7 3.2h-3.3v2h2.9l-0.9 4h-3v2h2.6l-0.6 2.8 2 0.4 0.7-3.2h3l-0.7 2.8 2 0.4 0.7-3.2h3.3v-2h-2.9l0.9-4h3zM9 10h-3l1-4h3l-1 4z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'email',
			        'title'         => __('E-mail','sw-wapf'),
			        'description'   => __('An email input field.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M0 3h16v2.4l-8 4-8-4z" ></path><path d="M0 14l5.5-4.8 2.5 1.4 2.5-1.4 5.5 4.8z" ></path><path d="M4.6 8.8l-4.6-2.3v6.5z" ></path><path d="M11.4 8.8l4.6-2.3v6.5z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'url',
			        'title'         => __('URL','sw-wapf'),
			        'description'   => __('An input field only accepting URLs.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M14.9 1.1c-1.4-1.4-3.7-1.4-5.1 0l-4.4 4.3c-1.4 1.5-1.4 3.7 0 5.2 0.1 0.1 0.3 0.2 0.4 0.3l1.5-1.5c-0.1-0.1-0.3-0.2-0.4-0.3-0.6-0.6-0.6-1.6 0-2.2l4.4-4.4c0.6-0.6 1.6-0.6 2.2 0s0.6 1.6 0 2.2l-1.3 1.3c0.4 0.8 0.5 1.7 0.4 2.5l2.3-2.3c1.5-1.4 1.5-3.7 0-5.1z" ></path><path d="M10.2 5.1l-1.5 1.5c0 0 0.3 0.2 0.4 0.3 0.6 0.6 0.6 1.6 0 2.2l-4.4 4.4c-0.6 0.6-1.6 0.6-2.2 0s-0.6-1.6 0-2.2l1.3-1.3c-0.4-0.8-0.1-1.3-0.4-2.5l-2.3 2.3c-1.4 1.4-1.4 3.7 0 5.1s3.7 1.4 5.1 0l4.4-4.4c1.4-1.4 1.4-3.7 0-5.1-0.2-0.1-0.4-0.3-0.4-0.3z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'select',
			        'title'         => __('Select list','sw-wapf'),
			        'description'   => __('A dropdown list where the user selects one option.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M15 4h-14c-0.6 0-1 0.4-1 1v6c0 0.6 0.4 1 1 1h14c0.6 0 1-0.4 1-1v-6c0-0.6-0.4-1-1-1zM10 11h-9v-6h9v6zM13 8.4l-2-1.4h4l-2 1.4z"></path></svg>',
		        ),
		        array(
			        'id'            => 'true-false',
			        'title'         => __('True/False','sw-wapf'),
			        'description'   => __('One checkbox indicating true ("yes") or false ("no").', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M14 6.2v7.8h-12v-12h10.5l1-1h-12.5v14h14v-9.8z" ></path><path d="M7.9 10.9l-4.2-4.2 1.5-1.4 2.7 2.8 6.7-6.7 1.4 1.4z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'checkboxes',
			        'title'         => __('Checkboxes','sw-wapf'),
			        'description'   => __('A series of checkboxes. The user can select multiple.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M14 6.2v7.8h-12v-12h10.5l1-1h-12.5v14h14v-9.8z" ></path><path d="M7.9 10.9l-4.2-4.2 1.5-1.4 2.7 2.8 6.7-6.7 1.4 1.4z" ></path></svg>',
		        ),
		        array(
			        'id'            => 'radio',
			        'title'         => __('Radio buttons','sw-wapf'),
			        'description'   => __('A series of radio buttons. The user can select one.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="16" width="16" viewBox="0 0 16 16"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path><path d="M8 1c3.9 0 7 3.1 7 7s-3.1 7-7 7-7-3.1-7-7 3.1-7 7-7zM8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8v0z"></path></svg>',
		        ),
		        array(
			        'id'            => 'image-swatch',
			        'title'         => __('Image swatches','sw-wapf'),
			        'description'   => __('A series of image options. The user can select only one.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg viewBox="0 0 58 58" width="16" height="16" stroke-width="2" stroke="#828282"><path d="M57 6H1a1 1 0 0 0-1 1v44a1 1 0 0 0 1 1h56a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1zm-1 44H2V8h54v42z"/><path d="M16 28.138a5.575 5.575 0 0 0 5.569-5.568c0-3.072-2.498-5.57-5.569-5.57s-5.569 2.498-5.569 5.569A5.575 5.575 0 0 0 16 28.138zM16 19c1.968 0 3.569 1.602 3.569 3.569S17.968 26.138 16 26.138s-3.569-1.601-3.569-3.568S14.032 19 16 19zM7 46c.234 0 .47-.082.66-.249l16.313-14.362L34.275 41.69a.999.999 0 1 0 1.414-1.414l-4.807-4.807 9.181-10.054 11.261 10.323a1 1 0 0 0 1.351-1.475l-12-11a1.031 1.031 0 0 0-.72-.262 1.002 1.002 0 0 0-.694.325l-9.794 10.727-4.743-4.743a1 1 0 0 0-1.368-.044L6.339 44.249A1 1 0 0 0 7 46z"></path></svg>',
		        ),
		        array(
			        'id'            => 'multi-image-swatch',
			        'title'         => __('Multi-select image swatches','sw-wapf'),
			        'description'   => __('A series of image options. The user can select multiple.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg viewBox="0 0 58 58" width="16" height="16" stroke-width="2" stroke="#828282"><path d="M57 6H1a1 1 0 0 0-1 1v44a1 1 0 0 0 1 1h56a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1zm-1 44H2V8h54v42z"/><path d="M16 28.138a5.575 5.575 0 0 0 5.569-5.568c0-3.072-2.498-5.57-5.569-5.57s-5.569 2.498-5.569 5.569A5.575 5.575 0 0 0 16 28.138zM16 19c1.968 0 3.569 1.602 3.569 3.569S17.968 26.138 16 26.138s-3.569-1.601-3.569-3.568S14.032 19 16 19zM7 46c.234 0 .47-.082.66-.249l16.313-14.362L34.275 41.69a.999.999 0 1 0 1.414-1.414l-4.807-4.807 9.181-10.054 11.261 10.323a1 1 0 0 0 1.351-1.475l-12-11a1.031 1.031 0 0 0-.72-.262 1.002 1.002 0 0 0-.694.325l-9.794 10.727-4.743-4.743a1 1 0 0 0-1.368-.044L6.339 44.249A1 1 0 0 0 7 46z"></path></svg>',
	            ),
		        array(
			        'id'            => 'color-swatch',
			        'title'         => __('Color swatches','sw-wapf'),
			        'description'   => __('A series of color options. The user can select only one.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="14" width="14" viewBox="0 0 14 14"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg><svg height="14" width="14" viewBox="0 0 14 14" style="margin-left: -4px;"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg><svg height="14" width="14" viewBox="0 0 14 14" style="display: block;margin-left: 6px; margin-top: -8px;"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg>',
		        ),
		        array(
			        'id'            => 'multi-color-swatch',
			        'title'         => __('Multi-select color swatches','sw-wapf'),
			        'description'   => __('A series of color options. The user can select multiple.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="14" width="14" viewBox="0 0 14 14"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg><svg height="14" width="14" viewBox="0 0 14 14" style="margin-left: -4px;"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg><svg height="14" width="14" viewBox="0 0 14 14" style="display: block;margin-left: 6px; margin-top: -8px;"><path d="M8 4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4z"></path></svg>',
		        ),
		        array(
			        'id'            => 'text-swatch',
			        'title'         => __('Text swatches','sw-wapf'),
			        'description'   => __('A series of text badges. The user can select only one.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="14" width="14" stroke-width="2" stroke="#828282" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><path d="M0,0.5v59h60v-59H0z M58,57.5H2v-55h56V57.5z"/><path d="M6.658,47.439C6.771,47.48,6.887,47.5,7,47.5c0.408,0,0.792-0.252,0.939-0.658L12.064,35.5h13.873l4.124,11.342 C30.208,47.248,30.592,47.5,31,47.5c0.113,0,0.229-0.02,0.342-0.061c0.519-0.188,0.787-0.762,0.598-1.281l-12-33 c-0.005-0.014-0.017-0.023-0.022-0.036c-0.027-0.066-0.07-0.122-0.111-0.181c-0.034-0.049-0.062-0.101-0.104-0.143 c-0.042-0.042-0.094-0.07-0.143-0.104c-0.059-0.041-0.115-0.083-0.181-0.11c-0.014-0.006-0.023-0.017-0.037-0.023 c-0.044-0.016-0.089-0.01-0.133-0.02c-0.07-0.015-0.137-0.031-0.21-0.031c-0.07,0-0.134,0.016-0.201,0.03 c-0.047,0.01-0.093,0.004-0.139,0.021c-0.015,0.005-0.024,0.017-0.038,0.023c-0.064,0.026-0.118,0.068-0.175,0.107 c-0.051,0.035-0.105,0.064-0.148,0.107c-0.041,0.041-0.069,0.092-0.102,0.141c-0.042,0.06-0.084,0.116-0.112,0.183 c-0.006,0.013-0.017,0.022-0.022,0.036l-12,33C5.871,46.678,6.14,47.251,6.658,47.439z M12.791,33.5L19,16.425L25.209,33.5H12.791z" transform="translate(10)"/></svg><svg height="14" width="14" stroke-width="2" stroke="#828282" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><path d="M0,0.5v59h60v-59H0z M58,57.5H2v-55h56V57.5z"/><path d="M6.658,47.439C6.771,47.48,6.887,47.5,7,47.5c0.408,0,0.792-0.252,0.939-0.658L12.064,35.5h13.873l4.124,11.342 C30.208,47.248,30.592,47.5,31,47.5c0.113,0,0.229-0.02,0.342-0.061c0.519-0.188,0.787-0.762,0.598-1.281l-12-33 c-0.005-0.014-0.017-0.023-0.022-0.036c-0.027-0.066-0.07-0.122-0.111-0.181c-0.034-0.049-0.062-0.101-0.104-0.143 c-0.042-0.042-0.094-0.07-0.143-0.104c-0.059-0.041-0.115-0.083-0.181-0.11c-0.014-0.006-0.023-0.017-0.037-0.023 c-0.044-0.016-0.089-0.01-0.133-0.02c-0.07-0.015-0.137-0.031-0.21-0.031c-0.07,0-0.134,0.016-0.201,0.03 c-0.047,0.01-0.093,0.004-0.139,0.021c-0.015,0.005-0.024,0.017-0.038,0.023c-0.064,0.026-0.118,0.068-0.175,0.107 c-0.051,0.035-0.105,0.064-0.148,0.107c-0.041,0.041-0.069,0.092-0.102,0.141c-0.042,0.06-0.084,0.116-0.112,0.183 c-0.006,0.013-0.017,0.022-0.022,0.036l-12,33C5.871,46.678,6.14,47.251,6.658,47.439z M12.791,33.5L19,16.425L25.209,33.5H12.791z" transform="translate(10)"/></svg>',
		        ),
		        array(
			        'id'            => 'multi-text-swatch',
			        'title'         => __('Multi-select text swatches','sw-wapf'),
			        'description'   => __('A series of text badges. The user can select multiple.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg height="14" width="14" stroke-width="2" stroke="#828282" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><path d="M0,0.5v59h60v-59H0z M58,57.5H2v-55h56V57.5z"/><path d="M6.658,47.439C6.771,47.48,6.887,47.5,7,47.5c0.408,0,0.792-0.252,0.939-0.658L12.064,35.5h13.873l4.124,11.342 C30.208,47.248,30.592,47.5,31,47.5c0.113,0,0.229-0.02,0.342-0.061c0.519-0.188,0.787-0.762,0.598-1.281l-12-33 c-0.005-0.014-0.017-0.023-0.022-0.036c-0.027-0.066-0.07-0.122-0.111-0.181c-0.034-0.049-0.062-0.101-0.104-0.143 c-0.042-0.042-0.094-0.07-0.143-0.104c-0.059-0.041-0.115-0.083-0.181-0.11c-0.014-0.006-0.023-0.017-0.037-0.023 c-0.044-0.016-0.089-0.01-0.133-0.02c-0.07-0.015-0.137-0.031-0.21-0.031c-0.07,0-0.134,0.016-0.201,0.03 c-0.047,0.01-0.093,0.004-0.139,0.021c-0.015,0.005-0.024,0.017-0.038,0.023c-0.064,0.026-0.118,0.068-0.175,0.107 c-0.051,0.035-0.105,0.064-0.148,0.107c-0.041,0.041-0.069,0.092-0.102,0.141c-0.042,0.06-0.084,0.116-0.112,0.183 c-0.006,0.013-0.017,0.022-0.022,0.036l-12,33C5.871,46.678,6.14,47.251,6.658,47.439z M12.791,33.5L19,16.425L25.209,33.5H12.791z" transform="translate(10)"/></svg><svg height="14" width="14" stroke-width="2" stroke="#828282" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><path d="M0,0.5v59h60v-59H0z M58,57.5H2v-55h56V57.5z"/><path d="M6.658,47.439C6.771,47.48,6.887,47.5,7,47.5c0.408,0,0.792-0.252,0.939-0.658L12.064,35.5h13.873l4.124,11.342 C30.208,47.248,30.592,47.5,31,47.5c0.113,0,0.229-0.02,0.342-0.061c0.519-0.188,0.787-0.762,0.598-1.281l-12-33 c-0.005-0.014-0.017-0.023-0.022-0.036c-0.027-0.066-0.07-0.122-0.111-0.181c-0.034-0.049-0.062-0.101-0.104-0.143 c-0.042-0.042-0.094-0.07-0.143-0.104c-0.059-0.041-0.115-0.083-0.181-0.11c-0.014-0.006-0.023-0.017-0.037-0.023 c-0.044-0.016-0.089-0.01-0.133-0.02c-0.07-0.015-0.137-0.031-0.21-0.031c-0.07,0-0.134,0.016-0.201,0.03 c-0.047,0.01-0.093,0.004-0.139,0.021c-0.015,0.005-0.024,0.017-0.038,0.023c-0.064,0.026-0.118,0.068-0.175,0.107 c-0.051,0.035-0.105,0.064-0.148,0.107c-0.041,0.041-0.069,0.092-0.102,0.141c-0.042,0.06-0.084,0.116-0.112,0.183 c-0.006,0.013-0.017,0.022-0.022,0.036l-12,33C5.871,46.678,6.14,47.251,6.658,47.439z M12.791,33.5L19,16.425L25.209,33.5H12.791z" transform="translate(10)"/></svg>',
		        ),
		        array(
			        'id'            => 'file',
			        'title'         => __('File upload','sw-wapf'),
			        'description'   => __('Allows users to upload a file, or multiple files.', 'sw-wapf'),
			        'type'          => 'field',
			        'icon'          => '<svg width="14" stroke="#828282" stroke-width="5" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="-53 1 511 512"><path d="M 276.410156 3.957031 C 274.0625 1.484375 270.84375 0 267.507812 0 L 67.777344 0 C 30.921875 0 0.5 30.300781 0.5 67.152344 L 0.5 444.84375 C 0.5 481.699219 30.921875 512 67.777344 512 L 338.863281 512 C 375.71875 512 406.140625 481.699219 406.140625 444.84375 L 406.140625 144.941406 C 406.140625 141.726562 404.65625 138.636719 402.554688 136.285156 Z M 279.996094 43.65625 L 364.464844 132.328125 L 309.554688 132.328125 C 293.230469 132.328125 279.996094 119.21875 279.996094 102.894531 Z M 338.863281 487.265625 L 67.777344 487.265625 C 44.652344 487.265625 25.234375 468.097656 25.234375 444.84375 L 25.234375 67.152344 C 25.234375 44.027344 44.527344 24.734375 67.777344 24.734375 L 255.261719 24.734375 L 255.261719 102.894531 C 255.261719 132.945312 279.503906 157.0625 309.554688 157.0625 L 381.40625 157.0625 L 381.40625 444.84375 C 381.40625 468.097656 362.113281 487.265625 338.863281 487.265625 Z M 338.863281 487.265625"/><path d="M305.101562 401.933594L101.539062 401.933594C94.738281 401.933594 89.171875 407.496094 89.171875 414.300781 89.171875 421.101562 94.738281 426.667969 101.539062 426.667969L305.226562 426.667969C312.027344 426.667969 317.59375 421.101562 317.59375 414.300781 317.59375 407.496094 312.027344 401.933594 305.101562 401.933594zM140 268.863281L190.953125 214.074219 190.953125 349.125C190.953125 355.925781 196.519531 361.492188 203.320312 361.492188 210.125 361.492188 215.6875 355.925781 215.6875 349.125L215.6875 214.074219 266.640625 268.863281C269.113281 271.457031 272.332031 272.820312 275.667969 272.820312 278.636719 272.820312 281.730469 271.707031 284.078125 269.480469 289.027344 264.78125 289.398438 256.988281 284.699219 252.042969L212.226562 174.253906C209.875 171.78125 206.660156 170.296875 203.199219 170.296875 199.734375 170.296875 196.519531 171.78125 194.171875 174.253906L121.699219 252.042969C117 256.988281 117.371094 264.902344 122.316406 269.480469 127.511719 274.179688 135.300781 273.808594 140 268.863281zM140 268.863281"/></svg>',
		        ),
	        );

            $content = array(
	            array(
		            'id'            => 'p',
		            'title'         => __('Paragraph','sw-wapf'),
		            'description'   => __('A text paragraph. Some HTML is allowed.', 'sw-wapf'),
		            'type'          => 'content',
		            'icon'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 179 179"><path d="M0,3.416h143.082v36.929l-22.313-0.064v-9.083c0-4.645-3.609-8.447-8.235-8.699H84.061V145.17	c0.199,5.258,4.458,9.365,9.727,9.365h7.896l0.065,20.299h-60.38l0.067-20.299h7.894c5.192,0,9.442-4.038,9.72-9.21V22.498h-28.5c-4.626,0.252-8.235,4.055-8.235,8.699v9.083L0,40.345V3.416z M163.541,175.125h15V3.416h-15V175.125z"/></svg>',
	            ),
	            array(
		            'id'            => 'img',
		            'title'         => __('Image','sw-wapf'),
		            'description'   => __('An image.', 'sw-wapf'),
		            'type'          => 'content',
		            'icon'          => '<svg viewBox="0 0 58 58" width="16" height="16" stroke-width="2" stroke="#828282"><path d="M57 6H1a1 1 0 0 0-1 1v44a1 1 0 0 0 1 1h56a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1zm-1 44H2V8h54v42z"/><path d="M16 28.138a5.575 5.575 0 0 0 5.569-5.568c0-3.072-2.498-5.57-5.569-5.57s-5.569 2.498-5.569 5.569A5.575 5.575 0 0 0 16 28.138zM16 19c1.968 0 3.569 1.602 3.569 3.569S17.968 26.138 16 26.138s-3.569-1.601-3.569-3.568S14.032 19 16 19zM7 46c.234 0 .47-.082.66-.249l16.313-14.362L34.275 41.69a.999.999 0 1 0 1.414-1.414l-4.807-4.807 9.181-10.054 11.261 10.323a1 1 0 0 0 1.351-1.475l-12-11a1.031 1.031 0 0 0-.72-.262 1.002 1.002 0 0 0-.694.325l-9.794 10.727-4.743-4.743a1 1 0 0 0-1.368-.044L6.339 44.249A1 1 0 0 0 7 46z"></path></svg>',
	            ),
            );

            $layout = array(
	            array(
		            'id'            => 'section',
		            'title'         => __('Section','sw-wapf'),
		            'description'   => __('A wrapper for fields. Can be used to apply styling or duplicate quantity-based fields in group.','sw-wapf'),
		            'type'          => 'layout',
		            'icon'          => '<svg width="16" height="16" viewBox="0 0 298 298"><path d="M264.833,215.417h33L297,215.583v48.333c0,0.57,0.402,1.138,0.374,1.7c-0.057,1.125,0.163,2.237-0.004,3.329	c-0.417,2.731-1.128,5.356-2.171,7.823c-0.417,0.987-0.861,1.957-1.369,2.892c-0.254,0.468-0.509,0.944-0.784,1.398	c-1.654,2.722-3.685,5.216-6.029,7.347c-0.391,0.355-0.787,0.763-1.195,1.1c-1.222,1.009-2.517,2.056-3.878,2.883c-4.99,3.032-10.845,5.028-17.11,5.028H215v-33h49v-48.833L264.833,215.417z M264.833,0.417H215v33h49v49.167l0.833-0.167h33L297,82.583V32.917C297,14.691,283.059,0.417,264.833,0.417z M115,33.417h67v-33h-67V33.417z M0,32.917v49.667l0.833-0.167h33	L33,82.583V33.417h49v-33H33.833C15.608,0.417,0,14.691,0,32.917z M264,182.417h33v-67h-33V182.417z M33,115.417H0v67h33V115.417z M33,215.583l0.833-0.167h-33L0,215.583v48.333c0,0.57,0.431,1.136,0.46,1.698c0.057,1.125,0.379,2.235,0.546,3.327	c0.417,2.731,1.274,5.352,2.317,7.82c0.417,0.987,0.934,1.949,1.442,2.885c0.254,0.468,0.545,0.928,0.821,1.382	c1.654,2.722,3.703,5.185,6.047,7.315c0.391,0.355,0.796,0.701,1.204,1.037c1.222,1.009,2.522,2.181,3.883,3.008c4.99,3.032,10.85,5.028,17.115,5.028H82v-33H33V215.583z M115,297.417h67v-33h-67V297.417z"/></svg>'
	            ),
	            array(
		            'id'            => 'sectionend',
		            'title'         => __('Section end','sw-wapf'),
		            'description'   => __('Ends a previously started section.','sw-wapf'),
		            'type'          => 'layout',
		            'icon'          => '<svg width="18" height="18" viewBox="0 0 64 64"><path d="M54 8c-1.104 0-2 .896-2 2v12h-40v-12c0-1.104-.896-2-2-2s-2 .896-2 2v12c0 2.206 1.794 4 4 4h40c2.206 0 4-1.794 4-4v-12c0-1.104-.896-2-2-2zM52 38h-40c-2.206 0-4 1.794-4 4v12c0 1.104.896 2 2 2s2-.896 2-2v-12h40v12c0 1.104.896 2 2 2s2-.896 2-2v-12c0-2.206-1.794-4-4-4zM11 34h2c1.104 0 2-.896 2-2s-.896-2-2-2h-2c-1.104 0-2 .896-2 2s.896 2 2 2zM23 34c1.104 0 2-.896 2-2s-.896-2-2-2h-2c-1.104 0-2 .896-2 2s.896 2 2 2zM33 34c1.104 0 2-.896 2-2s-.896-2-2-2h-2c-1.104 0-2 .896-2 2s.896 2 2 2zM43 34c1.104 0 2-.896 2-2s-.896-2-2-2h-2c-1.104 0-2 .896-2 2s.896 2 2 2zM53 34c1.104 0 2-.896 2-2s-.896-2-2-2h-2c-1.104 0-2 .896-2 2s.896 2 2 2z"/></svg>',
	            ),
            );

            $types = apply_filters('wapf/field_types', array(
            	__('Fields','sw-wapf') => $fields,
	            __('Content','sw-wapf') => $content,
	            __('Layout','sw-wapf') => $layout
            ));

            if($how && $how === 'short') {
            	$new = array();
            	foreach($types as $group => $_types) {
            		foreach($_types as $type) {
            			$x = $type;
            			unset($x['icon']);
            			$new[] = $x;
		            }
	            }
            	return $new;
            }
            return $types;

        }

        public static function get_field_options() {

        	$all_file_type = File_Upload::get_all_allowed_filetypes();

        	$allowed_file_types = array();
	        foreach ($all_file_type as $k => $v) {
		        $allowed_file_types[$k] = $k;
	        }
	        ksort($allowed_file_types);

            $options =  array(

                'true-false' => array(
                    array(
                        'type'          => 'text',
                        'id'            => "message",
                        'label'         => __('Message','sw-wapf'),
                        'description'   => __('Displays text alongside the checkbox.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'select',
                        'options'       => array(
                            'checked'   => __('Checked','sw-wapf'),
                            'unchecked' => __('Unchecked', 'sw-wapf')
                        ),
                        'default'       => 'unchecked',
                        'id'            => "default",
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                    	'type'          => 'text',
	                    'id'            => 'label_true',
	                    'label'         => __("Label for 'true'", 'sw-wapf'),
	                    'description'   => __('The text shown instead of "true" on cart, checkout, and order summary.'),
	                    'default'       => __('true', 'sw-wapf')
                    ),
	                array(
		                'type'          => 'text',
		                'id'            => 'label_false',
		                'label'         => __("Label for 'false'", 'sw-wapf'),
		                'description'   => __('The text shown instead of "false" on cart, checkout, and order summary.'),
		                'default'       => __('false','sw-wapf')
	                ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    )
                ),

                'text'      => array(
                    array(
                        'type'          => 'text',
                        'id'            => 'default',
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'text',
                        'id'            => 'placeholder',
                        'label'         => __('Placeholder text','sw-wapf'),
                        'description'   => __('Appears within the input field','sw-wapf')
                    ),
	                array(
		                'type'          => 'number',
		                'id'            => 'minlength',
		                'min'           => 1,
		                'label'         => __('Minimum length','sw-wapf'),
		                'description'   => __('The minimum length the input should have. Leave blank if there is no restriction.','sw-wapf')
	                ),
	                array(
		                'type'          => 'number',
		                'id'            => 'maxlength',
		                'min'           => 1,
		                'label'         => __('Maximum length','sw-wapf'),
		                'description'   => __('The maximum length the input should have. Leave blank if there is no restriction.','sw-wapf')
	                ),
	                array(
		                'type'          => 'text',
		                'id'            => 'pattern',
		                'label'         => __('HTML5 validation regex','sw-wapf'),
		                'description'   => __('You can restrict the input by adding a valid <a href="http://html5pattern.com/" target="_blank">HTML5 regex pattern</a>  here.','sw-wapf')
	                ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    ),
                ),

                'textarea'      => array(
                    array(
                        'type'          => 'textarea',
                        'id'            => 'default',
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'text',
                        'id'            => 'placeholder',
                        'label'         => __('Placeholder text','sw-wapf'),
                        'description'   => __('Appears within the input field','sw-wapf')
                    ),
	                array(
		                'type'          => 'number',
		                'id'            => 'minlength',
		                'min'           => 1,
		                'label'         => __('Minimum length','sw-wapf'),
		                'description'   => __('The minimum length the input should have. Leave blank if there is no restriction.','sw-wapf')
	                ),
	                array(
		                'type'          => 'number',
		                'id'            => 'maxlength',
		                'min'           => 1,
		                'label'         => __('Maximum length','sw-wapf'),
		                'description'   => __('The maximum length the input should have. Leave blank if there is no restriction.','sw-wapf')
	                ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    ),
                ),

                'number'      => array(
	                array(
		                'type'          => 'select',
		                'id'            => 'number_type',
		                'label'         => __('Number type','sw-wapf'),
		                'description'   => __('Allow integers (whole numbers) or decimals.','sw-wapf'),
		                'options'       => array(
			                'int'       => __('Integer','sw-wapf'),
			                'any'       => __('Integer & decimals','sw-wapf')
		                ),
		                'default'       => 'int'
	                ),
                    array(
                        'type'          => 'number',
                        'id'            => 'default',
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'text',
                        'id'            => 'placeholder',
                        'label'         => __('Placeholder text','sw-wapf'),
                        'description'   => __('Appears within the input field','sw-wapf')
                    ),
                    array(
                        'type'          => 'number',
                        'id'            => 'minimum',
                        'label'         => __('Minimum value','sw-wapf'),
                        'placeholder'   => __('No minimum','sw-wapf')
                    ),
                    array(
                        'type'          => 'number',
                        'id'            => 'maximum',
                        'label'         => __('Maximum value','sw-wapf'),
                        'placeholder'   => __('No maximum','sw-wapf')
                    ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    ),
                ),

                'email'     => array(
                    array(
                        'type'          => 'email',
                        'id'            => 'default',
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'text',
                        'id'            => 'placeholder',
                        'label'         => __('Placeholder text','sw-wapf'),
                        'description'   => __('Appears within the input field','sw-wapf')
                    ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    ),
                ),

                'url'       => array(
                    array(
                        'type'          => 'url',
                        'id'            => 'default',
                        'label'         => __('Default value','sw-wapf'),
                        'description'   => __('The pre-set value of the field when the page loads.','sw-wapf'),
                    ),
                    array(
                        'type'          => 'text',
                        'id'            => 'placeholder',
                        'label'         => __('Placeholder text','sw-wapf'),
                        'description'   => __('Appears within the input field','sw-wapf')
                    ),
                    array(
                        'type'          => 'pricing',
                        'id'            => "pricing",
                        'label'         => __('Adjust pricing','sw-wapf'),
                        'description'   => __('Should the price of the product or cart change when the user interacts with this field?','sw-wapf'),
                    ),
                ),

                'select'    => array(
                    array(
                        'type'                  => 'options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Add the options for this select list.','sw-wapf'),
                        'multi_option'          => false,
                        'show_pricing_options'  => true
                    ),
                ),

                'checkboxes'  => array(
                    array(
                        'type'                  => 'options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Each option is a checkbox.','sw-wapf'),
                        'multi_option'          => true,
                        'show_pricing_options'  => true
                    ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'min_choices',
		                'min'                   => '1',
		                'label'                 => __('Minimum choices needed','sw-wapf'),
		                'description'           => __('Set the minimum number of choices needed.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'max_choices',
		                'min'                   => '1',
		                'label'                 => __('Maximum choices allowed','sw-wapf'),
		                'description'           => __('Set the maximum number of choices allowed.','sw-wapf'),
	                ),
                ),

                'radio'  => array(
                    array(
                        'type'                  => 'options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Each option is a radio button.','sw-wapf'),
                        'multi_option'          => false,
                        'show_pricing_options'  => true
                    ),
                ),

                'image-swatch'   => array(
                    array(
                        'type'                  => 'imageswatch-options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Define your image swatches here. Note: for best quality, upload images that are square and a minimum of 250px by 250px.','sw-wapf'),
                        'show_pricing_options'  => true
                    ),
                    array(
                        'type'                  => 'select',
                        'id'                    => 'items_per_row',
                        'label'                 => __('Items per row','sw-wapf'),
                        'description'           => __('How many swatches can appear next to each other before starting a new row?','sw-wapf'),
                        'options'               => array(
                            1   => '1',
                            2   => '2',
                            3   => '3',
                            4   => '4',
                            5   => '5',
                        ),
                        'default'               => 3
                    ),

                ),

                'multi-image-swatch'   => array(
                    array(
                        'type'                  => 'imageswatch-options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Define your image swatches here. Note: for best quality, upload images that are square and a minimum of 250px by 250px.','sw-wapf'),
                        'show_pricing_options'  => true,
                        'multi_option'          => true,
                    ),
                    array(
                        'type'                  => 'select',
                        'id'                    => 'items_per_row',
                        'label'                 => __('Items per row','sw-wapf'),
                        'description'           => __('How many swatches can appear next to each other before starting a new row?','sw-wapf'),
                        'options'               => array(
                            1   => '1',
                            2   => '2',
                            3   => '3',
                            4   => '4',
                            5   => '5',
                        ),
                        'default'               => 3
                    ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'min_choices',
		                'min'                   => '1',
		                'label'                 => __('Minimum choices needed','sw-wapf'),
		                'description'           => __('Set the minimum number of choices needed.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'max_choices',
		                'min'                   => '1',
		                'label'                 => __('Maximum choices allowed','sw-wapf'),
		                'description'           => __('Set the maximum number of choices allowed.','sw-wapf'),
	                ),
                ),

                'color-swatch'  => array(
                    array(
                        'type'                  => 'colorswatch-options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Define your color swatches here.','sw-wapf'),
                        'show_pricing_options'  => true,
                        'multi_option'          => false,
                    ),
	                array(
		                'type'                  => 'select',
		                'id'                    => 'layout',
		                'label'                 => __('Swatch layout','sw-wapf'),
		                'default'               => 'circle',
		                'options'               => array(
			                'square'            => __('Square','sw-wapf'),
			                'rounded'           => __('Rounded corners','sw-wapf'),
			                'circle'            => __('Circle', 'sw-wapf')
		                ),
		                'description'           => __('How should the swatch look like?','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'border',
		                'label'                 => __('Selected border color','sw-wapf'),
		                'default'               => '#353c4e',
		                'description'           => __('The swatch border color when it is selected.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'size',
		                'min'                   => '5',
		                'max'                   => "500",
		                'postfix'               => 'px',
		                'default'               => 30,
		                'label'                 => __('Size (in pixels)','sw-wapf'),
		                'description'           => __('How big should the color swatch be?','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'true-false',
		                'id'                    => 'tooltip',
		                'label'                 => __('Show tooltip','sw-wapf'),
		                'default'               => true,
		                'description'           => __('Show the label in a tooltip when hovering the color.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'tooltip_bg',
		                'show_if'               => 'tooltip',
		                'default'               => '#353c4e',
		                'label'                 => __('Tooltip background color','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'tooltip_fg',
		                'default'               => '#ffffff',
		                'show_if'               => 'tooltip',
		                'label'                 => __('Tooltip text color','sw-wapf'),
	                )
                ),

                'multi-color-swatch'  => array(
                    array(
                        'type'                  => 'colorswatch-options',
                        'id'                    => 'options',
                        'label'                 => __('Options','sw-wapf'),
                        'description'           => __('Define your color swatches here.','sw-wapf'),
                        'show_pricing_options'  => true,
                        'multi_option'          => true,
                    ),
	                array(
		                'type'                  => 'select',
		                'id'                    => 'layout',
		                'label'                 => __('Swatch layout','sw-wapf'),
		                'default'               => 'circle',
		                'options'               => array(
			                'square'            => __('Square','sw-wapf'),
			                'rounded'           => __('Rounded corners','sw-wapf'),
			                'circle'            => __('Circle', 'sw-wapf')
		                ),
		                'description'           => __('How should the swatch look like?','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'border',
		                'label'                 => __('Selected border color','sw-wapf'),
		                'default'               => '#353c4e',
		                'description'           => __('The swatch border color when it is selected.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'size',
		                'min'                   => '5',
		                'max'                   => "500",
		                'postfix'               => 'px',
		                'default'               => 30,
		                'label'                 => __('Size (in pixels)','sw-wapf'),
		                'description'           => __('How big should the color swatch be?','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'true-false',
		                'id'                    => 'tooltip',
		                'label'                 => __('Show tooltip','sw-wapf'),
		                'default'               => true,
		                'description'           => __('Show the label in a tooltip when hovering the color.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'tooltip_bg',
		                'show_if'               => 'tooltip',
		                'default'               => '#353c4e',
		                'label'                 => __('Tooltip background color','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'colorpicker',
		                'id'                    => 'tooltip_fg',
		                'default'               => '#ffffff',
		                'show_if'               => 'tooltip',
		                'label'                 => __('Tooltip text color','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'min_choices',
		                'min'                   => '1',
		                'label'                 => __('Minimum choices needed','sw-wapf'),
		                'description'           => __('Set the minimum number of choices needed.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'max_choices',
		                'min'                   => '1',
		                'label'                 => __('Maximum choices allowed','sw-wapf'),
		                'description'           => __('Set the maximum number of choices allowed.','sw-wapf'),
	                ),
                ),
                'text-swatch'  => array(
	                array(
		                'type'                  => 'textswatch-options',
		                'id'                    => 'options',
		                'label'                 => __('Options','sw-wapf'),
		                'description'           => __('Define your swatches here.','sw-wapf'),
		                'show_pricing_options'  => true,
		                'multi_option'          => false,
	                ),
                ),
                'multi-text-swatch'  => array(
	                array(
		                'type'                  => 'textswatch-options',
		                'id'                    => 'options',
		                'label'                 => __('Options','sw-wapf'),
		                'description'           => __('Define your swatches here.','sw-wapf'),
		                'show_pricing_options'  => true,
		                'multi_option'          => true,
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'min_choices',
		                'min'                   => '1',
		                'label'                 => __('Minimum choices needed','sw-wapf'),
		                'description'           => __('Set the minimum number of choices needed.','sw-wapf'),
	                ),
	                array(
		                'type'                  => 'number',
		                'id'                    => 'max_choices',
		                'min'                   => '1',
		                'label'                 => __('Maximum choices allowed','sw-wapf'),
		                'description'           => __('Set the maximum number of choices allowed.','sw-wapf'),
	                ),
                ),
	            'file' => array(
	            	array(
	            		'type'                  => 'true-false',
			            'id'                    => 'multiple',
			            'label'                 => __('Allow multiple','sw-wapf'),
			            'description'           => __('Allow multiple files to be uploaded', 'sw-wapf')
		            ),
		            array(
		            	'type'                  => 'select',
			            'multiple'              => true,
			            'id'                    => 'accept',
			            'label'                 => __('Accepted file types','sw-wapf'),
			            'description'           => __('Which file types can the user upload? You can select multiple here.','sw-wapf'),
			            'note'                  => __('<b>Please note: </b>for security reasons, you should limit the file types allowed to be uploaded. You should select as little as possible, but select at least 1.'),
			            'options'               => $allowed_file_types,
			            'select2'               => true,
		            ),
	                array(
			            'type'                  => 'number',
			            'id'                    => 'maxsize',
			            'default'               => 1,
			            'label'                 => __('Maximum file size (MB)','sw-wapf'),
			            'description'           => __('The maximum allowed filesize of 1 file in megabytes.', 'sw-wapf')
		            ),
		            array(
			            'type'          => 'pricing',
			            'id'            => "pricing",
			            'label'         => __('Adjust pricing','sw-wapf'),
			            'description'   => __('Should the price of the product or cart change when the user uploads at least 1 file?','sw-wapf'),
		            ),
	            ),
	            'p' => array(
		            array(
			            'type'                  => 'textarea',
			            'id'                    => 'p_content',
			            'label'                 => __("Content",'sw-wapf'),
			            'description'           => __('Can contain some basic HTML.', 'sw-wapf')
		            )
	            ),
                'img' => array(
	                array(
		                'type'                  => 'image',
		                'id'                    => 'image',
		                'label'                 => __("Image",'sw-wapf'),
	                )
                )
            );

            $options = apply_filters('wapf/field_options', $options);

            foreach($options as &$group) {
                foreach($group as &$option) {
                    $option['is_field_setting'] = true;
                }
            }

            return $options;

        }

        public static function get_pricing_options($field_type = '') {

	        $options = array(
		        'fixed'     => __('Flat fee', 'sw-wapf'),
		        'qt'        => __('Quantity based flat fee', 'sw-wapf'),
		        'p'         => __('Percentage based fee','sw-wapf'),
		        'percent'   => __('Quantity based percentage fee', 'sw-wapf'),
	        );

	        if($field_type === 'file')
	        	return $options;

	        $options['fx'] = __('Formula based pricing', 'sw-wapf');

	        $allowed = array('text','textarea','email','url');
	        if(in_array($field_type, $allowed)) {
		        $options['char'] =  __('Amount &times; character count','sw-wapf');
		        $options['charq'] =  __('Amount &times; character count &times; qty','sw-wapf');
	        }

	        if($field_type === 'number'){
		        $options['nr'] =  __('Amount &times; field value','sw-wapf');
		        $options['nrq'] =  __('Amount &times; field value &times; qty','sw-wapf');
	        }

	        return apply_filters('wapf/admin/pricing_options',$options, $field_type);

        }

		public static function sanitize_raw_value(Field $field,$value) {
			switch($field->type) {
				case 'checkboxes'   :
				case 'radio'        :
				case 'select'       :
				case 'multi-image-swatch' :
				case 'image-swatch' :
				case 'multi-color-swatch' :
				case 'color-swatch' :
				case 'text-swatch' :
				case 'multi-text-swatch':
				return Enumerable::from((array)$value)->select(function($x){
						return sanitize_text_field($x);
					})->toArray();
				case 'true-false'   : return sanitize_text_field($value);
				default             : return self::sanitize_value($field,$value);
			}
		}

        public static function sanitize_value(Field $field,$value) {

            switch($field->type) {
                case 'checkboxes'   :
                case 'radio'        :
                case 'select'       :
                case 'multi-image-swatch' :
                case 'image-swatch' :
                case 'multi-color-swatch' :
                case 'color-swatch' :
	            case 'text-swatch' :
	            case 'multi-text-swatch':
                    return join(', ', Enumerable::from((array) $value)->select(function($v) use ($field) {
                        $choice = Enumerable::from($field->options['choices'])->firstOrDefault(function($choice) use($v) {
                            return $choice['slug'] === $v;
                        });

                        if($choice)
                            return esc_html($choice['label']);

                            return '';
                    })->toArray());
                case 'textarea'     : return sanitize_textarea_field(trim($value));
                case 'number'       : return filter_var(Helper::normalize_string_decimal($value), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                case 'true-false'   :
                	if($value == '1')
                		return isset($field->options['label_true']) ? sanitize_text_field($field->options['label_true']) : 'true';
	                return isset($field->options['label_false']) ? sanitize_text_field($field->options['label_false']) : 'false';
                case 'email'        : return sanitize_email(trim($value));
                default             : return sanitize_text_field(trim($value));
            }
        }

        public static function get_raw_field_value_from_request(Field $for_field, $clone_index = 0, $return_null = false) {
	        $field_name = 'field_' . $for_field->id . ($clone_index > 0 ? ('_clone_'.$clone_index):'');

            if($for_field->type === 'file') {
            	$files = Cache::get_files();
            	if(empty($files))
            		return $return_null ? null : '';

            	if(!isset($files[$field_name]))
            		return $return_null ? null : '';

            	return Enumerable::from($files[$field_name])
                     ->where(function($x){return $x['name'] !== '';})
                     ->join(function($x){return $x['name'];},', ');

            }

	        if(!isset($_REQUEST['wapf']) || !isset($_REQUEST['wapf'][$field_name]))
                return $return_null ? null : '';

            if($for_field->is_choice_field()){
            	$value = Enumerable::from((array) $_REQUEST['wapf'][$field_name])->where(function($x){return $x !== "0" && $x !== '';})->toArray();

            	if(empty($value))
		            return $return_null ? null : '';
            	return $value;
            }

            if($for_field->type === 'true-false' && $_REQUEST['wapf'][$field_name] === '0')
                return $return_null ? null : '';

	        return is_string($_REQUEST['wapf'][$field_name]) ? stripslashes($_REQUEST['wapf'][$field_name]) : $_REQUEST['wapf'][$field_name];
        }

        public static function raw_to_cartfield_values(Field $field, $raw_value,$clone_idx = 0) {

        	$values = array();

        	if($field->type === 'file') {
        		$files = Cache::get_files();
        		$key = 'field_' . $field->id;
        		if($clone_idx > 0)
        			$key .= '_clone_'.$clone_idx;

        		if(isset($files[$key])) {

			        $price = $field->pricing_enabled() ? $field->pricing->amount : 0;
			        $values[] = array(
				        'label' =>  Enumerable::from( $files[$key] )->join( function ( $x ) {
					        return '<a href="'. esc_url($x['uploaded_file']). '" target="_blank">'.esc_html($x['name']).'</a>';
				        }, ', ' ),
				        'price' => $price,
				        'price_type' => $field->pricing_enabled() ? $field->pricing->type : 'none'
			        );
		        }

        		return $values;
	        }

        	if($field->is_choice_field()) {

		        foreach ((array) $raw_value as $rv) {

		        	if(empty($rv))
		        		continue;

			        $choice = Enumerable::from($field->options['choices'])->firstOrDefault(function($choice) use($rv) {
				        return $choice['slug'] === $rv;
			        });

			        if(!$choice)
				        continue;

			        $values[] = array (
			        	'label' => esc_html($choice['label']),
				        'price' => $choice['pricing_type'] === 'none' ? 0 : $choice['pricing_amount'],
				        'price_type' => $choice['pricing_type'],
				        'slug' => $choice['slug']
			        );
		        }
	        }
        	else {

        		$price = $field->pricing_enabled() ? $field->pricing->amount : 0;

        		if(empty($raw_value) || ($field->type === 'true-false' && $raw_value == '0'))
        			$price = 0;

        		$values[] = array(
			        'label' => self::sanitize_value($field,$raw_value),
			        'price' => $price,
			        'price_type' => $field->pricing_enabled() ? $field->pricing->type : 'none'
		        );
	        }

        	return $values;

        }

        public static function do_pricing($is_qty_based_field, $pricing_type, $amount, $base_price, $qty, $val, $product_id, $cart_item ) {
            switch($pricing_type) {
                case 'percent':
	                $percent = $base_price * ($amount / 100);
                	return (float) $is_qty_based_field ? ($percent*$qty) : $percent;
	            case 'p':
	            	$percent = $base_price * ($amount / 100);
		            return (float) $is_qty_based_field ? $percent : $percent/$qty;
                case 'qt': return (float) ($is_qty_based_field ? ($amount*$qty) : $amount);
	            case 'nr':
	            	$v = floatval($val) * $amount;
	            	return $is_qty_based_field ? (float) $v : (float) $v/$qty;
	            case 'nrq': return (floatval($val) * $amount); 
	            case 'char':
	            	$v = strlen($val) * $amount;
	            	return $is_qty_based_field ? (float)$v : (float) $v/$qty;
	            case 'charq': return strlen($val) * $amount; 
	            case 'fx':

		            $clone_idx = 0;
		            if(isset($cart_item['wapf_clone']))
		            	$clone_idx = $cart_item['wapf_clone'];
		            $cart_fields = $cart_item['wapf'];
		            $field_groups = Field_Groups::get_by_ids($cart_item['wapf_field_groups']);
		            $variables = Enumerable::from($field_groups)->merge(function($x){return $x->variables;})->toArray();

		            $math = Helper::replace_in_formula($amount,$qty,$base_price,$val,$cart_fields);

	            	if(!empty($variables)) {
			            $fields = Enumerable::from($field_groups)->merge(function($x){return $x->fields; })->toArray();

			            $math = preg_replace_callback( '/\[var_.+?]/', function ( $matches ) use ( $variables,$fields,$product_id, $clone_idx, $base_price, $cart_item, $val, $qty) {
				            $var_name = str_replace( array( '[var_', ']' ), '', $matches[0] );

				            $var = Enumerable::from( $variables )->firstOrDefault( function ( $x ) use ( $var_name ) {
					            return $x['name'] === $var_name;
				            });
				            if($var) {
					            $valu = $var['default'];

					            foreach ( $var['rules'] as $rule ) {
					            	if(self::is_valid_rule($fields,$rule['field'],$rule['condition'],$rule['value'],$product_id,$cart_item,$clone_idx,$qty)){
							           $valu = $rule['variable'];
						           	    break;
						           }
								}

					            return Helper::parse_math_string(Helper::replace_in_formula($valu,$qty,$base_price,$val,$cart_item['wapf']),$cart_item['wapf']);
				            }

				            return '0';
			            }, $math );

		            }

	            	$x = Helper::parse_math_string($math,$cart_fields);
	            	return (float)($is_qty_based_field ? $x : ($x/$qty));  
                default: 
                    return $is_qty_based_field ? (float) $amount : (float) $amount/$qty;
            }
        }

        public static function is_field_value_valid(Field $field, $value = null) {

	        if($field->required) {

        		if($value === null)
        			return true;

		        if(empty($value))
		        	return false;

			}

			return true;
        }

        public static function get_field_state(FieldGroup $group, Field $field, $product_id, $clone_index = 0) {

	        if(!$field->has_conditionals())
		        return 'visible';

	        foreach ($field->conditionals as $conditional) {
		        if(self::validate_rules($group,$conditional->rules, $product_id, $clone_index)) 
			        return 'visible';
	        }

	        return 'invisible';
        }

        public static function should_field_be_filled_out(FieldGroup $group, Field $field, $product_id, $clone_index = 0) {

        	if(!$field->has_conditionals())
        		return true;

			foreach ($field->conditionals as $conditional) {
				if(self::validate_rules($group,$conditional->rules, $product_id, $clone_index)) 
					return true;
			}

			return false;

        }

        private static function validate_rules(FieldGroup $group, $rules, $product_id, $clone_index = 0) {

	       foreach ($rules as $rule) {

	       	    if(!self::is_valid_rule($group->fields,$rule->field,$rule->condition,$rule->value,$product_id,null,$clone_index))
			       return false;

	       }

	       return true;
        }

        private static function is_valid_rule($fields,$subject, $condition, $rule_value,$product_id,$cart_item = null,$clone_index = 0, $qty = 1){
	        if($subject === 'qty')
		        $value = $qty;
	        else {
		        $field = Enumerable::from( $fields )->firstOrDefault( function ( $x ) use ( $subject ) {
			        return $x->id === $subject;
		        } );

		        if ( ! $field ) {
			        return false;
		        }

		        if ( strpos( $condition, 'product_var' ) !== false ) {
			        if ( $condition === 'product_var' )
				        return in_array( $product_id, explode( ',', $rule_value ) );
			        else
				        return ! in_array( $product_id, explode( ',', $rule_value ) );
		        }
		        if(strpos($condition,'patts') !== false) {
		        	$product = wc_get_product($product_id);

		        	if($condition === 'patts')
						return Conditions::product_has_attribute_values($product,explode(',',$rule_value));
		        	else return !Conditions::product_has_attribute_values($product,explode(',',$rule_value));
		        }

		        if($cart_item) {
			        $value = Enumerable::from( $cart_item['wapf'] )->firstOrDefault( function ( $x ) use ( $subject ) {
				        return $x['id'] === $subject;
			        } );
			        if($value != null)
			        	$value = $value['raw'];
		        }
		        else
		        	$value = Fields::get_raw_field_value_from_request( $field, $clone_index, true );

		        if ($value === null ) {
			        return false;
		        }

	        }

	        switch($condition) {
		        case "check"     : return $value === '1';
		        case "!check"    : return $value === '0';
		        case '=='        : return in_array($rule_value, (array) $value);
		        case '!='        : return !in_array($rule_value, (array) $value);
		        case 'empty'     : return empty($value);
		        case '!empty'    : return !empty($value);
		        case '==contains': return is_array($value) ? in_array($rule_value, $value) : strpos($value,$rule_value) !== false;
		        case '!=contains': return is_array($value) ? !in_array($rule_value, $value) : strpos($value,$rule_value) === false;
		        case 'lt'        : return floatval($value) < floatval($rule_value);
		        case 'gt'        : return floatval($value) > floatval($rule_value);
	        }

	        return false;

        }

    }
}