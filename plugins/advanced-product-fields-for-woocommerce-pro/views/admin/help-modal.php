<?php
/* @var $model array */
$class = 'wapf--' . uniqid();
$model['class'] = $class;
?>
<?php if($model['icon'] === false){ ?>
<a style="padding-top:15px;display: inline-block;" href="#" onclick="javascript:event.preventDefault();jQuery('.<?php echo $class;?>').show();">
    <?php
        if(empty($model['button']))
            _e('View help','sw-wapf');
        else echo $model['button'];
    ?>
</a>
<?php }else{ ?>
    <a class="modal_help_icon" style="padding:5px;" href="#" onclick="javascript:event.preventDefault();jQuery('.<?php echo $class;?>').show();">
        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.844,0,0,114.844,0,256s114.844,256,256,256s256-114.844,256-256S397.156,0,256,0z M298.667,416 c0,5.896-4.771,10.667-10.667,10.667h-64c-5.896,0-10.667-4.771-10.667-10.667V256h-10.667c-5.896,0-10.667-4.771-10.667-10.667 v-42.667c0-5.896,4.771-10.667,10.667-10.667H288c5.896,0,10.667,4.771,10.667,10.667V416z M256,170.667 c-23.531,0-42.667-19.135-42.667-42.667S232.469,85.333,256,85.333s42.667,19.135,42.667,42.667S279.531,170.667,256,170.667z"/></svg>
    </a>
<?php } ?>
<?php  \SW_WAPF_PRO\Includes\Classes\Html::partial('admin/modal',$model ) ?>