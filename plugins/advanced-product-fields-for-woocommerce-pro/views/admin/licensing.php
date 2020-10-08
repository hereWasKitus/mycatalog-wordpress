<?php
 /** @var array $model */
$nonce = $model['has_license'] ? 'deactivate-pro' : 'activate-pro';
?>
<div class="mabel-wapf-license">
    <table class="form-table">
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="wapf_license"><?php _e('Plugin license key','sw-wapf'); ?></label>
            </th>
            <td class="forminp">
                <input type="hidden" name="_wapfnonce" value="<?php echo wp_create_nonce($nonce); ?>">
                <input class="input-text regular-input"
                       type="text"
                       name="wapf_license"
                       id="wapf_license"
                       value="<?php echo $model['has_license'] ? '***************' : ''; ?>" />
                <?php if(!$model['has_license']){ ?>
                    <span class="description">
                        <button type="submit" class="button-secondary" name="wapf_license_activate" value="wapf" style="margin-left:10px">
                            <?php _e('Activate license','sw-wapf'); ?>
                        </button>
                    </span>
                    <p class="description">
                        <?php _e("Please enter your license key to activate the plugin and click 'Save changes'.",'sw-wapf'); ?>
                    </p>
                <?php } else { ?>
                    <button name="wapf_license_activate" class="button-secondary" type="submit" value="wapf"><?php _e('Deactivate','sw-wapf'); ?></button>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>