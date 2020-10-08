<?php
    /* @var $model array */
    /** @var $list \SW_WAPF_PRO\Includes\Classes\wapf_List_Table */
?>

<div class="wrap">
    <h2 style="display: inline-block;">
        <?php echo $model['title']; ?>

        <?php if($model['can_create'] && $model['is_licensed']){ ?>
            <a href="<?php echo admin_url('post-new.php?post_type=wapf_product'); ?>" class="page-title-action">
                <?php _e('Add New', 'sw-wapf'); ?>
            </a>
        <?php } ?>
    </h2>

    <?php if($model['is_licensed']) { ?>
    <p style="padding-bottom:22px;margin:0 !important;" class="wapf-description">
        <?php _e('A field group is a collection of fields that belong together.','sw-wapf');?></p>
    <div id="nds-wp-list-table-demo">
        <div id="nds-post-body">
            <?php $list->views(); ?>
            <form method="post">
                <?php $list->display(); ?>
            </form>
        </div>
    </div>
    <?php } else { ?>
        <p style="padding-top:50px;font-size:1rem;margin:0 !important;" class="wapf-description">
            <?php _e('Thank you for installing our plugin. Please <a href="'.admin_url( '/admin.php?page=wc-settings&tab=wapf_settings' ).'">activate your license </a> first.','sw-wapf'); ?>
        </p>
    <?php }?>
</div>