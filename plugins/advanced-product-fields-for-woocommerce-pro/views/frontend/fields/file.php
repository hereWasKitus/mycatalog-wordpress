<?php
    if(\SW_WAPF_PRO\Includes\Classes\File_Upload::can_upload()) {
?>
<input type="file" <?php echo $model['field_attributes']; ?> />
<?php } else {
    echo esc_html(get_option('wapf_settings_upload_msg'));
} ?>