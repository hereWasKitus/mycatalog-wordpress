<?php

namespace SW_WAPF_PRO\Includes\Controllers {

    use SW_WAPF_PRO\Includes\Classes\Cache;
    use SW_WAPF_PRO\Includes\Classes\Conditions;
    use SW_WAPF_PRO\Includes\Classes\Field_Groups;
    use SW_WAPF_PRO\Includes\Classes\Html;
    use SW_WAPF_PRO\Includes\Classes\Licensing;
    use SW_WAPF_PRO\Includes\Classes\wapf_List_Table;
    use SW_WAPF_PRO\Includes\Classes\Woocommerce_Service;
    use SW_WAPF_PRO\Includes\Models\ConditionRule;
    use SW_WAPF_PRO\Includes\Models\ConditionRuleGroup;
    use SW_WAPF_PRO\Includes\Models\FieldGroup;

    if (!defined('ABSPATH')) {
        die;
    }

    class Admin_Controller{

        private $licensing;
        private $notices = array();

        public function __construct()
        {
            $this->licensing = new Licensing('https://www.studiowombat.com/wp-json/ssp/v1', wapf_get_setting('basename'));

            add_action( 'admin_enqueue_scripts',                                array($this, 'register_assets') );
            add_action('admin_menu',                                            array($this, 'admin_menus'));
            add_filter('plugin_action_links_' . wapf_get_setting('basename'),   array($this, 'add_plugin_action_links'));
            add_action('admin_notices',                                         array($this, 'show_admin_notices'));
            add_action('init',                                                  array($this, 'load'));
	        add_action('admin_init',                                            array($this,'deactivate_free_version'));

            add_action('current_screen',                                        array($this, 'setup_screen'));
            add_action('admin_notices',                                         array($this, 'display_preloader'));
            foreach(wapf_get_setting('cpts') as $cpt) {
                add_action('save_post_' . $cpt,                                 array($this, 'save_post'), 10, 3);
            }

            add_filter('woocommerce_settings_tabs_array',                       array($this,'woocommerce_settings_tab'), 100);
            add_action('woocommerce_settings_tabs_wapf_settings',               array($this,'woocommerce_settings_screen'));
            add_action('woocommerce_update_options_wapf_settings',              array($this, 'update_woo_settings') );

	        add_action('edit_form_before_permalink',                            array($this, 'add_import_export_options'));
            add_filter('woocommerce_product_data_tabs',                         array($this, 'add_product_tab'));
            add_action('woocommerce_product_data_panels',                       array($this, 'customfields_options_product_tab_content') );
            add_action('woocommerce_process_product_meta',                      array($this, 'save_fieldgroup_on_product'));
	        add_action('woocommerce_product_duplicate_before_save',             array($this,'on_product_duplication'),10,2);

            add_action('wp_ajax_wapf_search_products',                          array($this, 'search_woo_products'));
            add_action('wp_ajax_wapf_search_coupons',                           array($this, 'search_woo_coupons'));
            add_action('wp_ajax_wapf_search_tag',                               array($this, 'search_woo_tags'));
            add_action('wp_ajax_wapf_search_cat',                               array($this, 'search_woo_categories'));
            add_action('wp_ajax_wapf_search_variations',                        array($this, 'search_woo_variations'));
            add_action('wp_ajax_wapf_search_attributes',                        array($this, 'search_woo_attributes'));

        }

	    public function deactivate_free_version() {
		    if(function_exists('wapf') && current_user_can('activate_plugins'))
			    deactivate_plugins('advanced-product-fields-for-woocommerce/advanced-product-fields-for-woocommerce.php');
	    }

        #region Basics

        public function register_assets() {

            if(
                (isset($_GET['page']) && $_GET['page'] === 'wapf-field-groups') ||
                $this->is_screen(wapf_get_setting('cpts')) ||
                $this->is_screen('product')
            ) {

                $url =  trailingslashit(wapf_get_setting('url')) . 'assets/';
                $version = wapf_get_setting('version');

                wp_enqueue_style('wapf-admin-css', $url . 'css/admin.min.css', array(), $version);
                wp_enqueue_script('wapf-admin-js', $url . 'js/admin.min.js', array('jquery','wp-color-picker'), $version, false); 
                wp_enqueue_media();
                wp_enqueue_style( 'wp-color-picker' );

                wp_localize_script( 'wapf-admin-js', 'wapf_language',array(
                    'title_required'        => __("Please add a field group title first.", 'sw-wapf'),
                    'fields_required'       => __("Please add some fields first.", 'sw-wapf'),
                ));

                wp_localize_script('wapf-admin-js', 'wapf_config', array(
                    'ajaxUrl'               => admin_url( 'admin-ajax.php' ),
                    'isWooProductScreen'    => $this->is_screen('product')
                ));

                wp_dequeue_script('autosave');
            }

        }

        public function admin_menus() {

            $cap = wapf_get_setting('capability');

            add_submenu_page(
                'woocommerce',
                __('Product Fields','sw-wapf'),
                __('Product Fields','sw-wapf'),
                $cap,
                'wapf-field-groups',
                array($this,'render_field_group_list')
            );

        }

        public function show_admin_notices() {

            foreach( $this->notices as $notice ) {
                echo '<div class="notice is-dismissible notice-' . esc_html($notice['class']) . '"><p>' . esc_html($notice['message']) . '</p></div>';
            }

        }

        public function load() {

            $nonce = isset($_POST['_wapfnonce']) ? $_POST['_wapfnonce'] : false;

            if($nonce){

                if(isset($_REQUEST['wapf_license_activate']) && wp_verify_nonce($nonce,'activate-pro')  ) {
                    $activated = $this->licensing->activate_license();

                    $notice = $activated === true ? __('License activated. You can now add custom fields by going to WooCommerce > Product Fields or by editing a product individually.','sw-wapf') : $activated;
                    $this->notices[] = array(
                        'class' => $activated === true ? 'success' : 'error',
                        'message' => __($notice, 'sw-wapf')
                    );
                }

                if(isset($_REQUEST['wapf_license_activate']) && wp_verify_nonce($nonce,'deactivate-pro')){
                    $deactivated = $this->licensing->deactivate_license();
                    $this->notices[] = array(
                        'class' => 'success',
                        'message' => __('License deactivated','sw-wapf')
                    );
                }
            }

        }

        public function add_plugin_action_links($links) {
            $has_license = Licensing::get_license_info() != null;

            $links = array_merge( array(
                '<a href="' . esc_url( admin_url( '/admin.php?page=wc-settings&tab=wapf_settings' ) ) . '">' . __( $has_license ? 'Settings' : 'Activate license', 'sw-wapf' ) . '</a>',
                '<a href="' . esc_url( admin_url( '/admin.php?page=wapf-field-groups' ) ) . '">' . __( 'Global fields', 'sw-wapf' ) . '</a>'
            ), $links );

            return $links;
        }

        public function maybe_duplicate() {

            if(empty($_GET['wapf_duplicate']))
                return false;

            $post_id = intval($_GET['wapf_duplicate']);
            if($post_id === 0)
                return false;

            $post = get_post($post_id);
            if(!$post)
                return false;

            $fg = Field_Groups::get_by_id($post_id);

            if($fg === null)
                return false;

			$this->make_unique($fg);

            foreach(wapf_get_setting('cpts') as $cpt) {
                remove_action('save_post_' . $cpt, array($this, 'save_post'), 10);
            }

            Field_Groups::save($fg,$post->post_type,null,$post->post_title . ' - '. __('Copy','sw-wapf'), 'publish' );

            foreach(wapf_get_setting('cpts') as $cpt) {
                remove_action( 'save_post_' . $cpt, array($this, 'save_post'),10 );
            }

            return true;
        }

        #endregion

        #region WooCommerce product backend

	    public function on_product_duplication($duplicate, $product) {

		    if($duplicate->meta_exists('_wapf_fieldgroup')) {
			    $field_group =  Field_Groups::process_data($duplicate->get_meta('_wapf_fieldgroup',true,'edit'));

			    $this->make_unique($field_group);
			    $duplicate->update_meta_data('_wapf_fieldgroup',serialize($field_group));

		    }
	    }

	    public function add_import_export_options($post){
        	if($post->post_type !== 'wapf_product')
        		return;

        	Html::partial("admin/top-options");
	    }

        public function add_product_tab($tabs) {
            $tabs['customfields'] = array(
                'label'		=> __( 'Custom fields', 'sw-wapf' ),
                'target'	=> 'customfields_options',
                'class'		=> apply_filters('wapf/admin/tab_classes', array( 'show_if_simple', 'show_if_variable')),
            );
            return $tabs;
        }

        public function customfields_options_product_tab_content() {

	        $this->display_variables_help();

        	echo '<div id="customfields_options" class="panel woocommerce_options_panel">';

            echo '<h4 class="wapf-product-admin-title">' .  __('Fields','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('Add some custom fields to this group.','sw-wapf').'</span>' . '</h4>';

            $is_licensed = Licensing::get_license_info() != null;
            if(!$is_licensed) {
                echo '<p>'. __('Thank you for installing our plugin. Please <a href="' . admin_url('/admin.php?page=wc-settings&tab=wapf_settings') . '">activate your license</a> first.', 'sw-wapf') . '</p>';
                echo '</div>';
                return;
            }
            $this->display_field_group_fields(true);

            echo '<div style="display:none;">';
            $this->display_field_group_conditions(true);
            echo '</div>';

            echo '<h4 class="wapf-product-admin-title">' .  __('Layout','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('Field group layout settings','sw-wapf').'</span>' . '</h4>';
            $this->display_field_group_layout(true);

	        echo '<h4 class="wapf-product-admin-title"><a class="modal_help_icon" style="padding:5px;" href="#" onclick="javascript:event.preventDefault();jQuery(\'.wapf--varaible-help\').show();"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M298.667,416 c0,5.896-4.771,10.667-10.667,10.667h-64c-5.896,0-10.667-4.771-10.667-10.667V256h-10.667c-5.896,0-10.667-4.771-10.667-10.667 v-42.667c0-5.896,4.771-10.667,10.667-10.667H288c5.896,0,10.667,4.771,10.667,10.667V416z M256,170.667 c-23.531,0-42.667-19.135-42.667-42.667S232.469,85.333,256,85.333s42.667,19.135,42.667,42.667S279.531,170.667,256,170.667z"/></svg></a>' .  __('Custom variables','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('Create dynamic variables to use with formula-based pricing','sw-wapf').'</span>' . '</h4>';
	        $this->display_field_group_variable_builder(true);

            echo '</div>';
        }

        public function save_fieldgroup_on_product($post_id) {

        	$product = wc_get_product($post_id);
        	if(!$product)
        		return;

        	if(!in_array($product->get_type(), apply_filters('wapf/admin/allowed_product_types',array('variable','simple'))))
        		return;

            if(empty($_POST['wapf-fields']) ||
                empty($_POST['wapf-conditions']) ||
                empty($_POST['wapf-layout'])) {
                delete_post_meta($post_id,'_wapf_fieldgroup');
                return;
            }

            $this->save($post_id, false);

        }

        #endregion

        #region WooCommerce setting page configuration
        public function update_woo_settings() {
            woocommerce_update_options( $this->get_settings() );
        }

        public function woocommerce_settings_screen() {
            $license_info = Licensing::get_license_info();
            $has_license = $license_info != null;

            echo Html::view('admin/licensing', array(
                'has_license' => $has_license
            ));

            if($has_license)
                woocommerce_admin_fields( $this->get_settings() );
        }

        public function get_settings() {
            $settings = array();

            $settings[] = array(
                'name'      => __( 'Product field settings', 'sw-wapf' ),
                'type'      => 'title',
            );

            $settings[] = array(
                'name'      => __( 'Show in cart', 'sw-wapf' ),
                'id'        => 'wapf_settings_show_in_cart',
                'type'      => 'checkbox',
                'default'   => 'yes',
                'desc'      => __( "Show on customer's cart page.", 'sw-wapf' ),
                'desc_tip'  => __('When a user has filled out your fields, should they be summarized on their cart page after adding the product to their cart?', 'sw-wapf')
            );

            $settings[] = array(
                'name'      => __( 'Show on checkout', 'sw-wapf' ),
                'id'        => 'wapf_settings_show_in_checkout',
                'type'      => 'checkbox',
                'default'   => 'yes',
                'desc'      => __( "Show on the checkout page.", 'sw-wapf' ),
                'desc_tip'  => __('When a user has filled out your fields, should they be summarized on their checkout page?', 'sw-wapf')
            );

	        $settings[] = array(
		        'name'      => __( 'Show in mini cart', 'sw-wapf' ),
		        'id'        => 'wapf_settings_show_in_mini_cart',
		        'type'      => 'checkbox',
		        'default'   => 'no',
		        'desc'      => __( "Show in mini cart.", 'sw-wapf' ),
		        'desc_tip'  => __('When a user has filled out your fields, should they be summarized on the mini (floating) cart?', 'sw-wapf')
	        );

            $settings[] = array(
                'name'      => __( '"Add to cart" button on shop page', 'sw-wapf' ),
                'type'      => 'text',
                'id'        => 'wapf_add_to_cart_text',
                'desc_tip'  => __( 'When a product has custom fields, what should the "add to cart" button say on the shop page?.', 'sw-wapf' ),
                'default'   => __('Select options','sw-wapf')
            );

            $settings[] = array(
                'type'      => 'sectionend',
            );

	        $settings[] = array(
		        'name'      => __( 'File upload settings', 'sw-wapf' ),
		        'type'      => 'title',
	        );

	        $settings[] = array(
		        'name'      => __( 'Must be logged in', 'sw-wapf' ),
		        'id'        => 'wapf_settings_upload_login',
		        'type'      => 'checkbox',
		        'default'   => 'no',
		        'desc'      => __( "Users must be logged in to upload files.", 'sw-wapf' ),
		        'desc_tip'  => __('For security reasons, we advice to turn on this setting. This means your customers need an account before they can upload files.', 'sw-wapf')
	        );

	        $settings[] = array(
		        'name'      => __( '"Must be logged in" text', 'sw-wapf' ),
		        'type'      => 'text',
		        'id'        => 'wapf_settings_upload_msg',
		        'desc_tip'  => __('If users need to log in before uploading files, display a message to let them know.', 'sw-wapf' ),
		        'default'   => __('You need to be logged in to upload files.','sw-wapf')
	        );

	        $settings[] = array(
		        'type'      => 'sectionend',
	        );

            $settings = apply_filters('wapf/settings',$settings);

            return $settings;
        }

        public function woocommerce_settings_tab($tabs) {
            $tabs['wapf_settings'] = __( 'Product fields', 'sw-wapf' );
            return $tabs;
        }
        #endregion

        #region Ajax Functions

        public function search_woo_categories() {

            if( !current_user_can(wapf_get_setting('capability')) ) {
                echo json_encode(array());
                wp_die();
            }

            echo json_encode(Woocommerce_Service::find_category_by_name($_POST['q']));
            wp_die();
        }

        public function search_woo_tags() {

            if( !current_user_can(wapf_get_setting('capability')) ) {
                echo json_encode(array());
                wp_die();
            }

            echo json_encode(Woocommerce_Service::find_tags_by_name($_POST['q']));
            wp_die();
        }

        public function search_woo_coupons() {

            if( !current_user_can(wapf_get_setting('capability')) ) {
                echo json_encode(array());
                wp_die();
            }

            echo json_encode(Woocommerce_Service::find_coupons_by_name($_POST['q']));
            wp_die();
        }

        public function search_woo_variations() {

            if( !current_user_can(wapf_get_setting('capability')) ) {
                echo json_encode(array());
                wp_die();
            }

            echo json_encode(Woocommerce_Service::find_variations_by_name($_POST['q']));
            wp_die();
        }

	    public function search_woo_attributes() {

		    if( !current_user_can(wapf_get_setting('capability')) ) {
			    echo json_encode(array());
			    wp_die();
		    }

		    echo json_encode(Woocommerce_Service::find_attributes_by_name($_POST['q']));
		    wp_die();
	    }

        public function search_woo_products() {

            if( !current_user_can(wapf_get_setting('capability')) ) {
                echo json_encode(array());
                wp_die();
            }

            echo json_encode(Woocommerce_Service::find_products_by_name($_POST['q']));
            wp_die();
        }

        #endregion

        #region Save to Backend

        public function save_post($post_id, $post) {

            if (defined('DOING_AUTOSAVE') || is_int(wp_is_post_autosave($post)) || is_int(wp_is_post_revision($post))) {
                return;
            }

            if (defined('DOING_AJAX') && DOING_AJAX) {
                return;
            }

            if (isset($post->post_status) && $post->post_status === 'auto-draft')
                return;

            if( !current_user_can(wapf_get_setting('capability')) ) {
                return;
            }

            if(wp_verify_nonce($_POST['_wpnonce'],'update-post_' . $post_id) === false)
                return;

          $this->save($post_id, true);

        }

        private function save($post_id, $saving_cpt = true) {

            Cache::clear();

            $raw = array(
                'id'            => $post_id,
                'fields'        => array(),
                'conditions'    => array(),
                'type'          => $_REQUEST['wapf-fieldgroup-type']
            );

            if(isset($_POST['wapf-fields']))
                $raw['fields'] = json_decode(wp_unslash($_POST['wapf-fields']), true);

            if(isset($_POST['wapf-conditions']))
                $raw['conditions'] = json_decode(wp_unslash($_POST['wapf-conditions']), true);

            if(isset($_POST['wapf-layout']))
                $raw['layout'] = json_decode(wp_unslash($_POST['wapf-layout']), true);

	        if(isset($_POST['wapf-variables']))
		        $raw['variables'] = json_decode(wp_unslash($_POST['wapf-variables']), true);


            $fg = Field_Groups::raw_json_to_field_group($raw);

            if($saving_cpt) {
                foreach(wapf_get_setting('cpts') as $cpt) {
                    remove_action('save_post_' . $cpt, array($this, 'save_post'), 10);
                }

                Field_Groups::save($fg,$_REQUEST['wapf-fieldgroup-type'], $post_id);

                foreach(wapf_get_setting('cpts') as $cpt) {
                    remove_action( 'save_post_' . $cpt, array($this, 'save_post'),10 );
                }
            } else { 
                $fg->id = 'p_' . $fg->id; 
                update_post_meta( $post_id, '_wapf_fieldgroup', wp_slash(serialize($fg->to_array())));
            }


        }

        #endregion

        #region Display functions

        public function display_preloader() {

            $cpts = wapf_get_setting('cpts');
            if(!$this->is_screen($cpts))
                return;

            echo '<div class="wapf-preloader" style="position: absolute;z-index: 2000;top:0;left:-20px;right: 0;height: 100%;background-color: rgba(0,0,0,.65);">';
            echo '<svg style="position: fixed;z-index:3000;top:30%;left:50%;margin-left:-23px;" width="45" height="45" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg" stroke="#fff"><g fill="none" fill-rule="evenodd" transform="translate(1 1)" stroke-width="2"><circle cx="22" cy="22" r="6" stroke-opacity="0"><animate attributeName="r" begin="1.5s" dur="3s" values="6;22" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-opacity" begin="1.5s" dur="3s" values="1;0" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-width" begin="1.5s" dur="3s" values="2;0" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="22" cy="22" r="6" stroke-opacity="0"> <animate attributeName="r" begin="3s" dur="3s" values="6;22" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-opacity" begin="3s" dur="3s" values="1;0" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-width" begin="3s" dur="3s" values="2;0" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="22" cy="22" r="8"><animate attributeName="r" begin="0s" dur="1.5s" values="6;1;2;3;4;5;6" calcMode="linear" repeatCount="indefinite" /></circle></g></svg>';
            echo '</div>';

			$this->display_conditions_help();
			$this->display_variables_help();
        }

        public function setup_screen() {

            if($this->is_screen('woocommerce_page_wapf-field-groups')) {
            	if($this->maybe_duplicate()) {
            		wp_safe_redirect(admin_url('admin.php?page=wapf-field-groups'));
            		exit;
	            }
            }

            $cpts = wapf_get_setting('cpts');
            if($this->is_screen($cpts)) {

                add_meta_box(
                    'wapf-field-list',
                    __('Fields','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('Add some custom fields to this group.','sw-wapf').'</span>',
                    array($this, 'display_field_group_fields'),
                    $cpts,
                    'normal',
                    'high'
                );

                add_meta_box(
                    'wapf-field-group-conditions',
	                '<a class="modal_help_icon" style="padding:5px;" href="#" onclick="javascript:event.preventDefault();jQuery(\'.wapf--conditions-help\').show();"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M298.667,416 c0,5.896-4.771,10.667-10.667,10.667h-64c-5.896,0-10.667-4.771-10.667-10.667V256h-10.667c-5.896,0-10.667-4.771-10.667-10.667 v-42.667c0-5.896,4.771-10.667,10.667-10.667H288c5.896,0,10.667,4.771,10.667,10.667V416z M256,170.667 c-23.531,0-42.667-19.135-42.667-42.667S232.469,85.333,256,85.333s42.667,19.135,42.667,42.667S279.531,170.667,256,170.667z"/></svg></a>' . __('Conditions','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('When should this field group be displayed?','sw-wapf').'</span>',
                    array($this, 'display_field_group_conditions'),
                    $cpts,
                    'normal',
                    'high'
                );

                add_meta_box(
                    'wapf-field-group-layout',
                    __('Layout','sw-wapf') .' &mdash; <span style="opacity:.5;">'.__('Field group layout settings','sw-wapf').'</span>',
                    array($this, 'display_field_group_layout'),
                    $cpts,
                    'normal',
                    'high'
                );

                add_meta_box(
                	'wapf-field-group-variables',
	                '<a class="modal_help_icon" style="padding:5px;" href="#" onclick="javascript:event.preventDefault();jQuery(\'.wapf--varaible-help\').show();"><svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M298.667,416 c0,5.896-4.771,10.667-10.667,10.667h-64c-5.896,0-10.667-4.771-10.667-10.667V256h-10.667c-5.896,0-10.667-4.771-10.667-10.667 v-42.667c0-5.896,4.771-10.667,10.667-10.667H288c5.896,0,10.667,4.771,10.667,10.667V416z M256,170.667 c-23.531,0-42.667-19.135-42.667-42.667S232.469,85.333,256,85.333s42.667,19.135,42.667,42.667S279.531,170.667,256,170.667z"/></svg></a>' . __('Custom variables','sw-wapf') . ' &mdash; <span style="opacity:.5;">'. __('Create dynamic variables to use with formula-based pricing','sw-wapf').'</span>',
	                array($this, 'display_field_group_variable_builder'),
	                $cpts,
	                'normal',
	                'low'
                );

            }

        }

        public function display_field_group_variable_builder($for_product_admin = false) {
        	$model = $this->create_variables_model($for_product_admin);
	        echo Html::view("admin/variable-builder", $model);
        }

        public function display_field_group_layout($for_product_admin = false) {

            $model = $this->create_layout_model($for_product_admin);
            echo Html::view("admin/layout", $model);

        }

        public function display_field_group_conditions($for_product_admin = false) {

            $model = $this->create_conditions_model($for_product_admin);
            echo Html::view("admin/conditions", $model);
        }

        public function display_field_group_fields($for_product_admin = false) {

            $model = $this->create_field_group_model($for_product_admin);
            echo Html::view("admin/field-list", $model);

        }


        private function create_variables_model($for_product_admin = false) {

        	$model = array(
        		'variables' => array()
	        );

	        global $post;
	        if(is_bool($for_product_admin) && $for_product_admin)
		        $field_group =Field_Groups::process_data(get_post_meta($post->ID, '_wapf_fieldgroup', true));
	        else $field_group = Field_Groups::get_by_id($post->ID);

	        if(!empty($field_group) && !empty($field_group->variables)) {
	        	$model['variables'] = $field_group->variables;
	        }

	        return $model;
        }

        private function create_layout_model($for_product_admin = false) {

           $fg = new FieldGroup();
           $model = array(
               'layout' => $fg->layout,
               'type'   => $fg->type
           );

            global $post;
            if(is_bool($for_product_admin) && $for_product_admin)
                $field_group = Field_Groups::process_data(get_post_meta($post->ID, '_wapf_fieldgroup', true));
            else $field_group = Field_Groups::get_by_id($post->ID);

            if(isset($field_group->layout)) {
                $model['layout'] = $field_group->layout;
                $model['type'] = $field_group->type;
            }

            return $model;
        }

        private function create_conditions_model($for_product_admin = false) {

            $model = array(
                'condition_options' => Conditions::get_fieldgroup_visibility_conditions(),
                'conditions'        => array(),
                'post_type'         => isset($_GET['post_type']) ? $_GET['post_type'] : 'wapf_product'
            );

            global $post;

            if(is_bool($for_product_admin) && $for_product_admin) {

                $field_group_raw = get_post_meta($post->ID, '_wapf_fieldgroup', true);

                if(empty($field_group_raw)) {
                    $model['post_type'] = 'wapf_product';
                    $field_group = $this->prepare_fieldgroup_for_product($post->ID);
                } else {
                    $field_group = Field_Groups::process_data($field_group_raw);
                }
            } else
                $field_group = Field_Groups::get_by_id($post->ID);

            if(!empty($field_group)) {
                $model['type']          = $field_group->type;
                $model['conditions']    = $field_group->rules_groups;
                $model['post_type']     = $field_group->type;
            }

            return $model;

        }

        private function create_field_group_model($for_product_admin = false) {

            $model = array(
                'fields'            => array(),
                'condition_options' => Conditions::get_field_visibility_conditions(),
                'type'              => 'wapf_product'
            );

            global $post;

            if(is_bool($for_product_admin) && $for_product_admin)
                $field_group =Field_Groups::process_data(get_post_meta($post->ID, '_wapf_fieldgroup', true));
            else $field_group = Field_Groups::get_by_id($post->ID);

            if(!empty($field_group)) {
                $model['fields']    = Field_Groups::field_group_to_raw_fields_json($field_group);
                $model['type']      = $field_group->type;
            }

            return $model;

        }

        public function render_field_group_list() {

            $cap = wapf_get_setting('capability');

            $list = new Wapf_List_Table();
            $list->prepare_items();

            $model = array(
                'title'         => __('Product Field Groups', 'sw-wapf'),
                'can_create'    => current_user_can($cap),
                'is_licensed'   => Licensing::get_license_info() != null
            );

            Html::wp_list_table('cpt-list-table',$model,$list);

        }
        #endregion

        #region Private Helpers

	    private function make_unique(&$fg){
		    $fg->id = null;

		    foreach($fg->fields as $f){
			    $old_id = $f->id;
			    $f->id = uniqid();

			    foreach ($fg->fields as $f2){
				    if($f2->has_conditionals()){
					    foreach($f2->conditionals as $c) {
						    foreach ($c->rules as $r) {
							    if($r->field === $old_id)
								    $r->field = $f->id;
						    }
					    }
				    }
			    }

			    if($fg->has_variables()) {
				    foreach($fg->variables as &$v) {
					    if(isset($v['rules']) && is_array($v['rules'])) {
						    for($i = 0;$i<count($v['rules']);$i++) {
							    if($v['rules'][$i]['type'] === 'field' && $v['rules'][$i]['field'] === $old_id)
								    $v['rules'][$i]['field'] = $f->id;
						    }
					    }
				    }
			    }

		    }
	    }

	    private function display_conditions_help() {

		    echo Html::view('admin/modal', array(
			    'class'     => 'wapf--conditions-help',
			    'title'     => __('Help with conditions', 'sw-wapf'),
			    'content'   => __('In the "conditions" section, you can define on which products your options should be shown. Here are a few examples of what you can do:<ul><li>Only show the options on products from a certain category</li><li>Only show the options to users with a certain role.</li><li>Only show these options on variable products.</li></ul>','sw-wapf')
		    ));
	    }

	    private function display_variables_help() {
		    echo Html::view('admin/modal', array(
			    'class'     => 'wapf--varaible-help',
			    'title'     => __('Help with custom variables', 'sw-wapf'),
			    'content'   => __('You can create dynamic variables which can then be used in formulas. A variable can dynamically change value depending on other values.<br/><br/><a href="https://www.studiowombat.com/kb-article/formulas-and-variables-explained/#variables?ref=wapf_admin" target="_blank">Read more about variables here</a>','sw-wapf')
		    ));
	    }

        private function is_screen( $id = '', $action = '' ) {

            if( !function_exists('get_current_screen') ) {
                return false;
            }

            $current_screen = get_current_screen();

            if( !$current_screen )
                return false;

            if( !empty($action) ) {

                if(!isset($current_screen->action))
                    return false;

                if(is_array($action) && !in_array($current_screen->action, $action))
                    return false;

                if(!is_array($action) && $action !== $current_screen->action)
                    return false;
            }

            if(!empty($id)) {

                if(is_array($id) && !in_array($current_screen->id,$id))
                    return false;

                if(!is_array($id) && $id !== $current_screen->id)
                    return false;
            }

           return true;
        }

        private function prepare_fieldgroup_for_product($post_id) {

            $rule_group = new ConditionRuleGroup();
            $rule = new ConditionRule();
            $rule->subject = 'product';
            $rule->condition = 'product';
            $rule->value = array(array('id' => $post_id, 'text' => ''));
            $rule_group->rules[] = $rule;

            $field_group = new FieldGroup();
            $field_group->type = 'wapf_product';
            $field_group->rules_groups[] = $rule_group;

            return $field_group;
        }

        #endregion

    }

}