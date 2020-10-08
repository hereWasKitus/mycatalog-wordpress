<?php

namespace SW_WAPF_PRO\Includes\Classes {

    if (!defined('ABSPATH')) {
        die;
    }

    use stdClass;

    class Licensing
    {
        private $api_url     = '';
        private $slug        = '';
        private $version     = '';
        private $wp_override = false;
        private $name        = '';
        private $key         = '';

        public function __construct( $api_url, $plugin_base ) {

            $this->api_url     = trailingslashit( $api_url );
            $this->slug        = wapf_get_setting('slug');
            $this->version     = wapf_get_setting('version');
            $this->name        = $plugin_base;

            $this->init();
        }

        private function get_key() {
            if(empty($this->key)) {
                $raw = get_option($this->slug.'_license');
                return $raw === false ? false : json_decode(base64_decode($raw))->key;
            }
            return $this->key;
        }

        public function init() {

            add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );
            add_filter( 'plugins_api', array( $this, 'plugins_api_filter' ), 10, 3 );
            remove_action( 'after_plugin_row_' . $this->name, 'wp_plugin_update_row', 10 );
            add_action( 'after_plugin_row_' . $this->name, array( $this, 'show_update_notification' ), 10, 2 );

	        add_action( 'in_plugin_update_message-advanced-product-fields-for-woocommerce-pro/advanced-product-fields-for-woocommerce-pro.php', array( $this, 'in_plugin_update_message' ), 10, 2 );

        }

        public static function in_plugin_update_message($args, $response) {

        	if(!empty($response->upgrade_notice))
	            echo '<div style="padding:12px 0;border-top:1px solid #ffb900;"><strong>Upgrade warning! </strong>' . wp_kses_post($response->upgrade_notice) . '</div><p style="display: none">';
        }

        public static function get_license_info() {
            $raw = get_option( wapf_get_setting('slug') . '_license' );
            return $raw === false ? null : json_decode(base64_decode($raw));
        }

        public function deactivate_license()
        {
            $key = $this->get_key();
            if($key !== false){
                $this->api_request('license/deactivate/'.$key.'/'.$this->slug);
            }
            delete_option($this->slug . '_license');

            return true;
        }

        public function activate_license()
        {
            $key = $_POST['wapf_license'];

            $result = $this->api_request('license/activate/'.$key.'/'.$this->slug);

            if($result === null)
                return "Couldn't connect to license server";

            if($result->status !== 'passed')
                return $result->message;

            update_option($this->slug .'_license', base64_encode(json_encode(
                array(
                    'key' => $key,
                    'expiration' => $result->expiration,
                    'url' => home_url()
                )
            )));
            return true;

        }

        public function plugins_api_filter( $_data, $_action = '', $_args = null ) {

            if ( $_action != 'plugin_information' ) {
                return $_data;
            }
            if ( ! isset( $_args->slug ) || ( $_args->slug != $this->slug ) ) {
                return $_data;
            }

            if ($this->get_key() === false)
                return $_data;

            $api_response = $this->api_request( 'plugin/info/'.$this->get_key().'/'.$this->slug );

            if ( null !== $api_response ) {
                $_data = $api_response;
            }

            if ( isset( $_data->sections ) && !is_array( $_data->sections ) ) {
                $new_sections = array();
                foreach ( $_data->sections as $key => $value ) {
                    $new_sections[ $key ] = $value;
                }
                $_data->sections = $new_sections;
            }

            return $_data;
        }

        public function check_update( $_transient_data ) {

            global $pagenow;

            if ( ! is_object( $_transient_data ) ) {
                $_transient_data = new stdClass;
            }

            if ( 'plugins.php' == $pagenow && is_multisite() ) {
                return $_transient_data;
            }

            if ( ! empty( $_transient_data->response ) && ! empty( $_transient_data->response[ $this->name ] ) && false === $this->wp_override ) {
                return $_transient_data;
            }

            $version_info = $this->wp_override ? null : $this->get_cached_version_info();

            if ( null === $version_info && $this->get_key() !== false) {
                $version_info = $this->api_request( 'plugin/update/'.$this->version.'/'.$this->get_key() . '/'.$this->slug );
                if(isset($version_info->icons))
                	$version_info->icons = json_decode(json_encode($version_info->icons),true);
                $this->set_version_info_cache( $version_info );
            }

            if ( null !== $version_info && is_object( $version_info ) && isset( $version_info->new_version ) && version_compare( $this->version, $version_info->new_version, '<' ) ) {

                $_transient_data->response[ $this->name ] = $version_info;
                $_transient_data->last_checked           = current_time( 'timestamp' );
                $_transient_data->checked[ $this->name ] = $this->version;

            }

            return $_transient_data;
        }

        public function show_update_notification( $file, $plugin ) {

            if ( !is_multisite() || is_network_admin() || !current_user_can('update_plugins') ) {
                return;
            }
            if ( $this->name != $file ) {
                return;
            }

            remove_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ), 10 );
            $update_cache = get_site_transient( 'update_plugins' );
            $update_cache = is_object( $update_cache ) ? $update_cache : new stdClass();

            if ( empty( $update_cache->response ) || empty( $update_cache->response[ $this->name ] ) ) {
                $version_info = $this->get_cached_version_info();
                if ( null === $version_info && $this->get_key() !== false) {
                    $version_info = $this->api_request( 'plugin/info/'.$this->get_key().'/'.$this->slug);
                    $this->set_version_info_cache( $version_info );
                }
                if ( ! is_object( $version_info ) ) {
                    return;
                }

                $update_cache->response[ $this->name ] = $version_info;
                $update_cache->last_checked = current_time( 'timestamp' );
                $update_cache->checked[ $this->name ] = $this->version;
                set_site_transient( 'update_plugins', $update_cache );
            } else {
                $version_info = $update_cache->response[ $this->name ];
            }
            add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );
            if ( ! empty( $update_cache->response[ $this->name ] ) && version_compare( $this->version, $version_info->version, '<' ) ) {
                echo '<tr class="plugin-update-tr" id="' . $this->slug . '-update" data-slug="' . $this->slug . '" data-plugin="' . $this->slug . '/' . $file . '">';
                echo '<td colspan="3" class="plugin-update colspanchange">';
                echo '<div class="update-message notice inline notice-warning notice-alt">';
                $changelog_link = $version_info->changelog;

                if ( empty( $version_info->package ) ) {
                    printf(
                        '<p>' . __( 'There is a new version available. %1$sView version %2$s details%3$s.', $this->slug ) .'</p>',
                        '<a target="_blank" href="' . esc_url( $changelog_link ) . '">',
                        esc_html( $version_info->version ),
                        '</a>'
                    );
                } else {
                    printf(
                        '<p>' . __( 'There is a new version available. %1$sView version %2$s details%3$s or %4$supdate now%5$s.', $this->slug) .'</p>',
                        '<a target="_blank" href="' . esc_url( $changelog_link ) . '">',
                        esc_html( $version_info->version ),
                        '</a>',
                        '<a href="' . esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) ) .'">',
                        '</a>'
                    );
                }
                do_action( "in_plugin_update_message-{$file}", $plugin, $version_info );
                echo '</div></td></tr>';
            }
        }

        public function get_cached_version_info( ) {

            $transient = get_transient($this->slug . '_version_info');
            if($transient === false)
            	return null;

            $decoded = json_decode($transient);
	        if(isset($decoded->icons))
		        $decoded->icons = json_decode(json_encode($decoded->icons),true);

			return $decoded;
        }

        public function set_version_info_cache( $value ) {

            set_transient($this->slug .'_version_info', json_encode($value), HOUR_IN_SECONDS * 5 ); 

        }

        private function api_request( $url ) {
            global $wp_version;

            $api_params = array(
                'wp_version'    => $wp_version,
                'url'           => home_url(),
                'is_ssl'        => is_ssl()
            );

	        $data = array(
		        'timeout' 	=> apply_filters('wapf/licensing/timeout', 5),
		        'body'		=> $api_params
	        );

            $request = wp_remote_post( $this->api_url .$url, $data);

            $return = null;

            if ( is_wp_error( $request ) )
                return $return;

            if ( $request['response']['code'] == 200 )
            {
                $return = json_decode($request['body']);
            }

            return $return;
        }
    }
}