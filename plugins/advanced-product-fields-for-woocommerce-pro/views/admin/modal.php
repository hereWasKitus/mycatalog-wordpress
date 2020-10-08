<?php
/* @var $model array */
?>

<div class="wapf_modal_overlay <?php echo $model['class']; ?>">
	<div class="wapf_modal">
		<a class="wapf_close" href="javascript:jQuery('.<?php echo $model['class'] ?>').hide();">&times;</a>
		<?php
		if(!empty($model['title']))
			echo '<h3>' . $model['title'] . '</h3>';
		?>
		<div style="line-height: 1.5;">
			<?php echo $model['content']; ?>
		</div>
	</div>
</div>
