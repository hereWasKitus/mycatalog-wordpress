<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	use SW_WAPF_PRO\Includes\Classes\Html;

	class WooCommerce_Bookings{

		public function __construct() {
            add_filter('wapf/admin/tab_classes',                        array($this, 'customfields_tab_classes'));
            add_filter('wapf/admin/allowed_product_types',              array($this, 'allowed_product_types'));
            add_action('wapf/admin/after_additional_field_settings',    array($this, 'add_repeating_setting'));
            add_action('admin_footer',                                  array($this, 'admin_scripts'));

            add_filter('wapf/html/field_container_attributes',          array($this,'add_repeater_attributes'),10,2);
            add_filter('wapf/html/field_container_classes',             array($this,'add_container_classes'),10,2);
            add_action('wp_head',                                       array($this,'frontend_styles'));
            add_action('wp_footer',                                     array($this, 'frontend_scripts'));
		}

		public function frontend_styles() {
		    echo '<style>.wapf-booking-hide{display:none;}</style>';
        }

		public function frontend_scripts() {
		    if(!is_product())
		        return;

		    global $product;
		    if(!$product || $product->get_type() !== 'booking')
		        return;

		    ?>
            <script>
                var wapf_booking_cache = [];
                jQuery(document).on('wapf/init', function(e,$parent) {

                    var $repeaters = $parent.find('.wapf-field-container[data-booking-repeat]');
                    var $inputs = $parent.find('.wc-bookings-booking-form input[name*="wc_bookings_field_persons"]');

                    $inputs.each(function(idx,e) {
                        jQuery(e).data('prevQty',parseInt(jQuery(e).val()) || 0);
                    });

                    $inputs.on('change keyup', function() {
                        var $e = jQuery(this);
                        var previousQty = $e.data('prevQty'); 
                        var qty =  $e.val() == '0' ? 0 : parseInt($e.val()) || previousQty;
                        $e.data('prevQty', qty); 
                        var toDuplicate = qty-previousQty;

                        var personId = jQuery(this).attr('name').split('_');
                        personId = personId[personId.length-1];

                        if(toDuplicate === 0)
                            return;

                        $repeaters.filter('[data-booking-repeat='+personId+']').each(function(idx,el) {
                            var $repeater = jQuery(el);

                            if(toDuplicate > 0) { 
                                if($repeater.hasClass('wapf-booking-hide')) {
                                    $repeater.removeClass('wapf-booking-hide');
                                    toDuplicate--;
                                }
                                for (var i = 0; i < toDuplicate; i++) {
                                    var $cloned = $repeater.clone(true);
                                    $cloned.insertAfter(jQuery('[for='+$repeater.attr('for')+']').last());
                                }
                            } else { 
                                var howMany = Math.abs(toDuplicate);
                                var $repeatersFor = jQuery('[for='+$repeater.attr('for')+']');
                                if(howMany - $repeatersFor.length <= 0) {
                                    $repeater.addClass('wapf-booking-hide');
                                    howMany--;
                                }
                                [].reverse.call($repeatersFor).splice(0,howMany).forEach(function($e){
                                    $e.remove();
                                });
                            }
                        });

                    });

                });
            </script>
            <?php
        }

        public function add_container_classes($classes, $field) {

	        if(isset($field->options['booking_repeat']) && $field->options['booking_repeat']) {
		        $classes[] = 'wapf-booking-hide';
	        }

	        return $classes;
        }

		public function add_repeater_attributes($atts, $field) {

		    if(isset($field->options['booking_repeat']) && $field->options['booking_repeat']) {
		        $atts['data-booking-repeat'] = isset($field->options['booking_repeat_for']) ? $field->options['booking_repeat_for'] : '0';
            }

		    return $atts;

        }


		public function add_repeating_setting() {

		    if(!$this->is_edit_product_screen())
		        return;

		    echo ' <div rv-if="field.type | notin \'p,img,sectionend\'">';

            Html::setting( array(
                'type'              => 'true-false',
                'id'                => 'booking_repeat',
                'label'             => __('Repeat with persons','sw-wapf'),
                'description'       => __('Should this field appear as many times as persons on the booking?','sw-wapf'),
                'is_field_setting'  => true
            ) );
			Html::setting( array(
				'type'              => 'select',
				'id'                => 'booking_repeat_for',
				'show_if'           => 'booking_repeat',
				'default'           => '',
				'label'             => __('Repeat for person type','sw-wapf'),
				'description'       => __('Select which person type this field should repeat for.','sw-wapf'),
				'is_field_setting'  => true,
                'select2'           => true,
                'select2_source'    => 'getPersonTypesFromBooking'
			) );

            echo '</div>';
        }

		public function admin_scripts() {

		    if(!$this->is_edit_product_screen())
		        return;

			?>
			<script>
                window.getPersonTypesFromBooking = function() {

                    if(jQuery('#_wc_booking_has_person_types').is(':checked')) {
                        var types = [];
                        jQuery('#persons-types .woocommerce_booking_person').each(function(idx,e) {
                            var $e = jQuery(e);
                            types.push({
                                id:parseInt( $e.find('[name="person_id['+idx+']"]').val() ),
                                text:$e.find('input.person_name').val()
                            });
                        });
                        return types;
                    }

                    return [{id:'person',text:'Person'}];

                };

                jQuery(function() {

				    var removePricings = function() {
                        jQuery(".wapf-pricing-list option[value=qt]").remove();
                        jQuery(".wapf-pricing-list option[value=percent]").remove();
                        jQuery(".wapf-pricing-list option[value=charq]").remove();
                        jQuery('[data-setting="qty_based"]').remove();
                    };

				    jQuery('#product-type').on('change', function() {
				        var type = jQuery(this).val();
				        if(type !== 'booking')
				            return;

                       removePricings();

                    }).trigger('change');

                    jQuery(document).on('wapf/field/added', removePricings);
                    jQuery(document).on('wapf/field/type_change', removePricings);
                    jQuery(document).on('wapf/field/option_added', removePricings);
				});
			</script>
			<?php
		}

		public function customfields_tab_classes($tab_classes) {
			$tab_classes[] = 'show_if_booking';
			return $tab_classes;
		}

		public function allowed_product_types($product_types) {
			$product_types[] = 'booking';
			return $product_types;
		}

		private function is_edit_product_screen() {

			if(!function_exists('get_current_screen'))
				return false;

			$screen = get_current_screen();
			if($screen->base === 'post' && $screen->post_type === 'product')
				return true;

			return false;

		}

	}

}