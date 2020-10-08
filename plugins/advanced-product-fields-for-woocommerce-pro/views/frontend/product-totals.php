<?php
 /** @var string $data_output */
 ?>
<div class="wapf-product-totals" <?php echo $data_output ?>>
    <div class="wapf--inner">
        <div>
            <span><?php _e('Product total','sw-wapf'); ?></span>
            <span class="wapf-total wapf-product-total price amount"></span>
        </div>
        <div>
            <span><?php _e('Options total','sw-wapf'); ?></span>
            <span class="wapf-total wapf-options-total price amount"></span>
        </div>
        <div>
            <span><?php _e('Grand total','sw-wapf'); ?></span>
            <span class="wapf-total wapf-grand-total price amount"></span>
        </div>
    </div>
</div>