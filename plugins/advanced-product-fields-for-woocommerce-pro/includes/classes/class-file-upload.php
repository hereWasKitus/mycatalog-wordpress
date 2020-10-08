<?php

namespace SW_WAPF_PRO\Includes\Classes {

	use SW_WAPF_PRO\Includes\Models\Field;

	if(!defined('ABSPATH'))
		exit;

	class File_Upload {

		private static $field_for_upload = null;

		public static function can_upload() {
			$needs_login = get_option('wapf_settings_upload_login','no');
			if( $needs_login === 'yes' && ! is_user_logged_in() )
				return false;

			return true;
		}

		public static function get_htaccess_rules() {

			$filetypes = '';
			$restricted_filetypes =  self::get_allowed_filetypes(self::$field_for_upload);
			if( ! empty( $restricted_filetypes ) && is_array( $restricted_filetypes ) ) {
				$filetypes = join( '|', Enumerable::from($restricted_filetypes)->select(function($v,$k){return $k;})->toArray() );
			}
			$rules = "Options -Indexes\n"; 
			$rules .= "<Files ~ '.*\..*'>\n";
			$rules .= "Order Allow,Deny\n";
			$rules .= "Deny from all\n";
			$rules .= "</Files>\n";
			$rules .= "<FilesMatch '\.(" . $filetypes . ")$'>\n";
			$rules .= "Order Deny,Allow\n";
			$rules .= "Allow from all\n";
			$rules .= "</FilesMatch>";

			return $rules;
		}

		public static function get_base_upload_dir() {
			$wp_upload_dir = wp_upload_dir();
			$path = $wp_upload_dir['basedir'] . '/wapf';
			wp_mkdir_p($path);
			return $path;
		}

		public static function create_protection_files($upload) {
			if(!file_exists($upload['parent_path'])) {
				wp_mkdir_p($upload['parent_path']);
				@file_put_contents($upload['parent_path'] . '/index.php', '<?php' . PHP_EOL . '// Silence is golden.');
				@file_put_contents($upload['parent_path'] . '/.htaccess', 'Options -Indexes');
			}

			if(!file_exists($upload['path'])) {
				wp_mkdir_p($upload['path']);
				@file_put_contents($upload['path'] . '/index.php', '<?php' . PHP_EOL . '// Silence is golden.');
			}

			$htaccess = self::get_htaccess_rules();
			@file_put_contents($upload['path'] . '/.htaccess', $htaccess);

		}

		public static function set_upload_dir($upload) {

			$parent = '/wapf';
			$hash = self::$field_for_upload ? md5(self::$field_for_upload->id) : 'no_field';
			$upload['subdir'] = $parent . '/' . $hash;

			if(get_option('uploads_use_yearmonth_folders')){
				$time = current_time( 'mysql' );
				$y = substr( $time, 0, 4 );
				$m = substr( $time, 5, 2 );
				$upload['subdir'] .= "/$y/$m";
			}

			$upload['path']         = $upload['basedir'] . $upload['subdir'];
			$upload['parent_path']  = $upload['basedir'] . $parent;
			$upload['url']          = $upload['baseurl'] . $upload['subdir'];

			self::create_protection_files($upload);
			return $upload;
		}

		public static function handle_files_array($field_groups,$files) {

			$fields = Enumerable::from($field_groups)->merge(function($x){return $x->fields; })->toArray();

			foreach ($files as $key => &$files_arr) {

				$key = explode('_',str_replace('field_','',$key))[0];
				$field = Enumerable::from($fields)->firstOrDefault(function($x) use ($key) {return $x->id === $key;});

				if(!$field)
					continue;

				foreach($files_arr as &$file) {
					if(empty($file['name']) || isset($file['uploaded_file']))
						continue;

					$upload = File_Upload::handle_upload($file, $field);
					if(empty($upload['error'])) {
						$file['uploaded_file'] = $upload['url'];
					} else {
						return sprintf(apply_filters('wapf/message/file_upload_error', __( "Error uploading file \"%s\". %s", 'sw-wapf' )),$file['name'], $upload['error']);
					}
				}
			}

			return $files;
		}

		public static function handle_upload($file, Field $field) {

			if (!function_exists('wp_handle_upload'))
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			include_once(ABSPATH . 'wp-admin/includes/media.php');
			$allowed_types = self::get_allowed_filetypes($field);
			$file_info = wp_check_filetype_and_ext($file['tmp_name'],$file['name'], $allowed_types );

			if(!self::can_upload()) {
				return array('error' => apply_filters('wapf/message/file_upload_logged_in', __( 'You are not authorized to upload files.', 'sw-wapf' )) );
			}

			if(empty($file_info['type'])) {
				return array('error' =>  apply_filters( 'wapf/message/file_not_valid', __( 'The uploaded file type is not allowed.', 'sw-wapf' )));
			}

			self::$field_for_upload = $field;
			add_filter( 'upload_dir', array('SW_WAPF_PRO\Includes\Classes\File_Upload','set_upload_dir') );
			$upload = wp_handle_upload(
				$file,
				array(
					'test_form' => false,
					'mimes'		=> $allowed_types
				)
			);

			remove_filter( 'upload_dir', array('SW_WAPF_PRO\Includes\Classes\File_Upload','set_upload_dir') );

			return $upload;
		}

		public static function create_uploaded_file_array() {

			if(!isset($_FILES['wapf']))
				return array();

			$result = array();

			foreach($_FILES['wapf']['name'] as $key => $content) {

				if(empty($content[0]))
					continue;

				$result[$key] = array();

				for($i=0; $i<count($content); $i++) {
					$result[$key][] = array(
						'name'      => $content[$i],
						'tmp_name'  => $_FILES['wapf']['tmp_name'][$key][$i],
						'size'  => $_FILES['wapf']['size'][$key][$i],
						'error'  => $_FILES['wapf']['error'][$key][$i],
						'type'  => $_FILES['wapf']['type'][$key][$i],
					);
				}

			}

			return $result;

		}

		public static function get_allowed_filetypes(Field $field) {

			$all = self::get_all_allowed_filetypes();

			if(empty($field->options['accept']))
				return $all;

			$types = explode(',', $field->options['accept']);
			$t = array();

			foreach ($types as $type) {
				if(!isset($all[$type]))
					continue;

				$type = sanitize_text_field($type);
				$t[$type] = $all[$type];
			}

			return $t;

		}

		public static function get_all_allowed_filetypes() {
			$all = get_allowed_mime_types();
			return $all;
		}

		public static function validate_files_for_field($files,Field $field,$clone_idx = 0) {
			if(empty($files))
				return true;

			$file_key = 'field_' . $field->id;

			if($clone_idx > 0)
				$file_key .= '_clone_' . $clone_idx;

			if(!isset($files[$file_key]))
				return true;

			if(!self::can_upload()) {
				return apply_filters('wapf/message/file_upload_logged_in', __( 'You are not authorized to upload files.', 'sw-wapf' ));
			}

			$total_files = count($files[$file_key]);

			if(empty($field->options['multiple']) && $total_files> 1) {
				$error = apply_filters('wapf/message/upload_err_too_many', __("You are not allowed to upload multiple files.",'sw-wapf'));
				return $error;
			}

			$max_size = floatval($field->get_option('maxsize',1)) * pow(1024,2); 
			$types = File_Upload::get_allowed_filetypes($field);

			$total_files_without_error = 0;

			for($i=0; $i<$total_files; $i++ ) {
				$name = $files[$file_key][$i]['name'];
				if($name != '') {
					if($files[$file_key][$i]['error'] > 0) {

						switch($files[$file_key][$i]['error']) {
							case 1: $error = apply_filters('wapf/message/upload_err_ini_size', __("The uploaded file exceeds the upload_max_filesize directive in php.ini.",'sw-wapf')); break;
							case 4: $error = apply_filters('wapf/message/upload_err_cant_write', __("Failed to write file to disk.",'sw-wapf')); break;
							case 3: $error = apply_filters('wapf/message/upload_err_partial', __('The uploaded file was only partially uploaded.', 'sw-wapf')); break;
							default: $error = apply_filters('wapf/message/upload_error_code', sprintf(__('Error code: %s','sw-wapf'), $files[$file_key][$i]['error'] )); break;
						}
						return sprintf(apply_filters('wapf/message/file_upload_error', __( "Error uploading file \"%s\". %s", 'sw-wapf' )),$files[$file_key][$i]['name'], $error);
					}

					if($files[$file_key][$i]['size'] > $max_size) {
						$error = apply_filters('wapf/message/upload_err_too_big', __("The filesize is too big.",'sw-wapf'));
						return sprintf(apply_filters('wapf/message/file_upload_error', __( "Error uploading file \"%s\". %s", 'sw-wapf' )),$files[$file_key][$i]['name'], $error);
					}

					if(isset($files[$file_key][$i]['type']) && !in_array($files[$file_key][$i]['type'], array_values($types))) {
						$error = apply_filters('wapf/message/upload_err_type_unsupported', __("This file type is not supported.",'sw-wapf'));
						return sprintf(apply_filters('wapf/message/file_upload_error', __( "Error uploading file \"%s\". %s", 'sw-wapf' )),$files[$file_key][$i]['name'], $error);
					}

					$total_files_without_error++;

				}
			}

			if( $total_files_without_error > intval(ini_get('max_file_uploads'))) {
				$error = apply_filters('wapf/message/upload_err_uploads_exceeded', __("The maximum number of allowed simultanious uploads was exceeded. Please upload less files.",'sw-wapf'));
				return $error;
			}

			return true;

		}

	}

}