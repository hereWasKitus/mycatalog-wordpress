<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	class Woodmart
	{
		public function __construct() {
			add_action('wp_footer', array($this, 'add_javascript'));
		}

		public function add_javascript() {
			?>
			<script>
                jQuery(document).on('woodmart-quick-view-displayed',function(){
                    new WAPF.Frontend(jQuery('.product-quick-view'));
                });
			</script>
			<?php
		}

	}
}