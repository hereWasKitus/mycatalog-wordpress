<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

    class Product_Table
    {
	    public function __construct() {
		    add_action('wp_footer', array($this, 'add_javascript'));
	    }

	    public function add_javascript(){
		    ?>
            <script>
                jQuery(document).on('init.wcpt', function(ev,d) {
                    if(d)
                        d.$table.find('tr.product-type-simple,tr.product-type-variable').each(function(i,e){
                            new WAPF.Frontend(jQuery(e));
                        });
                });
            </script>
		    <?php
        }

    }
}