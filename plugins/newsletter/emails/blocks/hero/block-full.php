<style>
    /* Styles which will be removed and injected in the replacing the matching "inline-class" attribute */
    .title {
        font-size: <?php echo $title_font_size ?>px; 
        color: <?php echo $title_font_color ?>; 
        font-family: <?php echo $title_font_family ?>;
        font-weight: <?php echo $title_font_weight ?>; 
        line-height: normal;
        margin: 0;
    }
    .text {
        padding: 20px 0 0 0; 
        font-size: <?php echo $font_size ?>px; 
        line-height: 150%; 
        color: <?php echo $font_color ?>; 
        font-family: <?php echo $font_family ?>; 
        margin: 0;
    }
    .image {
        max-width: 100%!important; 
        display: inline-block;
        border: 0px;
        margin: 0;
    }  
    .image-a {
        display: block;
    }
</style>

<!-- layout: full -->

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php if ($media) { ?>
        <tr>
            <td class="padding-copy tnpc-row-edit" align="center" style="text-align: center; line-height: 0; padding-bottom: 20px;">
                <a href="<?php echo $url ?>" target="_blank" rel="noopener nofollow" inline-class="image-a">
                    <img src="<?php echo $media->url ?>" border="0" alt="<?php echo esc_attr($media->alt) ?>" width="<?php echo $media->width ?>" height="<?php echo $media->height ?>" inline-class="image">
                </a>
            </td>
        </tr>
    <?php } ?>

    <tr>
        <td align="center" inline-class="title">
            <span><?php echo $options['title'] ?></span>
        </td>
    </tr>
    <tr>
        <td align="center" inline-class="text">
            <span><?php echo $options['text'] ?></span>
        </td>
    </tr>

    <tr>
        <td align="center">
            <br>
            <?php echo tnpc_button($options) ?>
        </td>
    </tr>
</table>
