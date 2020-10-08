<?php /* @var $model array */ ?>

<div class="wapf-field__setting" data-setting="<?php echo $model['id']; ?>">
	<div class="wapf-setting__label">
		<label><?php _e($model['label'],'sw-wapf');?></label>
		<?php if(isset($model['description'])) { ?>
			<p class="wapf-description">
				<?php _e($model['description'],'sw-wapf');?>
			</p>
		<?php } ?>
	</div>
	<div class="wapf-setting__input">
		<?php
			$content = '';
			$editor_id = 'editor_content';
			$settings =   array(
				'wpautop' => true, // use wpautop?
				'media_buttons' => false, // show insert/upload button(s)
				'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
				'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
			);
			wp_editor( $content, $editor_id, $settings );

			/*$settings = array(
				'textarea_name' => $model['id'],
				'quicktags'     => array( 'buttons' => 'em,strong,link' ),
				'tinymce'       => array(
					'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink',
					'theme_advanced_buttons2' => '',
				),
				'textarea_rows' => 10
			);
			wp_editor('',$model['id'], $settings);*/
		?>
	</div>
</div>