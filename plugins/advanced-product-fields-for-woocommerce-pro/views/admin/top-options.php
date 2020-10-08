<?php
 $import_class = 'wapf--' . uniqid();
 $export_class = 'wapf--' . uniqid();
?>

<!--<div class="wapf-top-options">
	<a class="wapf-import" href="#" data-modal-class="<?php echo $import_class;?>"><?php _e('Import','sw-wapf'); ?></a> |
	<a class="wapf-export" href="#" data-modal-class="<?php echo $export_class;?>"><?php _e('Export','sw-wapf'); ?></a>
</div>

<div class="wapf_modal_overlay <?php echo $export_class; ?>">
	<div class="wapf_modal">
        <div style="margin-bottom: 15px;">
		    <a class="wapf_close" href="javascript:jQuery('.<?php echo $export_class ?>').hide();">&times;</a>
        </div>
		<div>
            <p>
                <?php _e('You can use the JSON code below to import into another field group.','sw-wapf'); ?>
            </p>
			<textarea class="wapf-export-ta" readonly style="width: 100%; height:200px;"></textarea>
		</div>
	</div>
</div>

<div class="wapf_modal_overlay <?php echo $import_class; ?>">
    <div class="wapf_modal">
        <div style="margin-bottom: 15px;">
            <a class="wapf_close" href="javascript:jQuery('.<?php echo $import_class ?>').hide();">&times;</a>
        </div>
        <div>
            <p>
				<?php _e('Paste exported JSON code below to import it into this field group.','sw-wapf'); ?>
            </p>
            <textarea class="wapf-import-ta" style="width: 100%; height:200px;"></textarea>
        </div>
        <div style="margin-top:10px;display: flex;align-items: center;">
            <button class="button btn-wapf-import"><?php _e('Import','sw-wapf');?></button>
            <span class="wapf-import-success" style="display: none;color:green;padding-left:10px;"><?php _e('All done!','sw-wapf'); ?></span>
            <span class="wapf-import-error" style="display: none;color:red;padding-left:10px;"><?php _e('An error occured. Is your JSON formatted correctly?','sw-wapf'); ?></span>
        </div>
    </div>
</div>-->