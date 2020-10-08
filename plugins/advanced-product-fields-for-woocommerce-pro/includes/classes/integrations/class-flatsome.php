<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	class Flatsome
	{
		public function __construct() {
			add_action('wp_footer', array($this, 'add_javascript'));
		}

		public function add_javascript() {
			?>
			<script>

            jQuery(document).ajaxSuccess(function(e,xhr,d){
                if(d && d.type == 'POST' && d.data && typeof d.data === 'string' && d.data.indexOf('action=flatsome_quickview')>-1){
                    new WAPF.Frontend(jQuery('.product-quick-view-container'));
                }
            });
			</script>
			<?php
		}

	}
}