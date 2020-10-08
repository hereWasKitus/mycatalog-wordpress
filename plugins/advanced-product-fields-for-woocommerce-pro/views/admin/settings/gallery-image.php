<?php
/* @var $model array */
?>

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
        <div class="wapf-flex" style="align-items: center">
            <div class="wapf-toggle" rv-unique-checkbox>
                <input rv-on-change="toggleGalleryImages" rv-checked="settings.enable_gallery_images" type="checkbox" >
                <label class="wapf-toggle__label" for="wapf-toggle-">
                    <span class="wapf-toggle__inner" data-true="<?php _e('Yes','sw-wapf'); ?>" data-false="<?php _e('No','sw-wapf'); ?>"></span>
                    <span class="wapf-toggle__switch"></span>
                </label>
            </div>

            <div style="margin-left:15px;" rv-show="settings.enable_gallery_images">
				<?php _e('How should images be swapped?','sw-wapf'); ?>
            </div>

            <div style="margin-left:15px;" rv-show="settings.enable_gallery_images">
                <select rv-on-change="changeSwapType" rv-value="settings.swap_type">
                    <option value="last"><?php _e('According to the last option changed','sw-wapf');?></option>
                    <option value="rules"><?php _e('According to a combination of option values','sw-wapf');?></option>
                </select>
            </div>
        </div>

        <div class="wapf-gallery_image_items">

        </div>

        <div class="wapf-gallery_image_wrapper" rv-if="settings.enable_gallery_images" rv-productgallery="settings.gallery_images">
            <div class="wapf-gallery_image" rv-each-savedimage="viewableGalleryImages" rv-data-index="$index">
                <div class="wapf-gallery_image_close"><a href="#" rv-on-click="deleteGalleryImage" class="wapf-button--tiny-rounded">×</a></div>
                <div rv-show="settings.swap_type | eq 'rules'" class="wapf-gallery_image_drag">☰</div>

                <div rv-if="settings.swap_type | eq 'rules'">
                    <div class="wapf-gallery_image_item" rv-each-value="savedimage.values">
                        <span class="gallery_image_title" rv-html="value.fieldCache.label"></span>
                        <select rv-value="value.value" rv-on-change="onChange">
                            <option value="*" ><?php _e('Any','sw-wapf');?></option>
                            <option rv-each-choice="value.fieldCache.choices" rv-value="choice.value" rv-text="choice.label"></option>
                        </select>
                    </div>
                </div>

                <div rv-if="settings.swap_type | eq 'last'">
                    <div rv-each-value="savedimage.values" class="wapf-gallery_image_item" >
                        <div class="wapf-flex">
                            <div>
                                <span class="gallery_image_title"><?php _e('Field','sw-wapf');?></span>
                                <select rv-value="value.field" rv-on-change="onChangeField">
                                    <option rv-each-opt="fieldLabels" rv-value="opt.id" rv-text="opt.label"></option>
                                </select>
                            </div>
                            <div style="margin-left: 10px;">
                                <span class="gallery_image_title"><?php _e('Value','sw-wapf');?></span>
                                <select rv-value="value.value" rv-on-change="onChange">
                                    <option rv-each-choice="value.fieldCache.choices" rv-value="choice.value" rv-text="choice.label"></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div rv-show="galleryImages | isNotEmpty">
                        <div style="padding: 8px 0;"><?php _e('Select an image from the product gallery:','sw-wapf'); ?></div>
                        <div rv-on-click="setProductImage" rv-each-image="galleryImages" class="wapf-gallery_img" rv-class-active="savedimage.id | eqloose image.id">
                            <img rv-src="image.url" />
                        </div>
                    </div>
                    <div>
                        <div style="padding:8px 0;" class="wapf-media-selector">
                            <a rv-hide="galleryImages | isNotEmpty" class="wapf-btn-add-media" href="#">
								<?php _e('Select image', 'sw-wapf'); ?>
                            </a>
                            <a rv-hide="galleryImages | isEmpty" class="wapf-btn-add-media" href="#">
								<?php _e('Or select other image', 'sw-wapf'); ?>
                            </a>
                            <div class="wapf-media-preview" rv-class-wapf-hide="savedimage.url | isEmpty" rv-hide="savedimage.source | neq 'upload'">
                                <a class="wapf-btn-add-media"><img rv-src="savedimage.url" /></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div rv-if="needsMoreLess" style="width: 100%;text-align: center">
                <a href="#" rv-show="showAll | eq false" rv-on-click="showAllRules"><?php _e('&darr; Show all rules ({hidden} hidden) &darr;','sw-wapf'); ?></a>
                <a href="#" rv-show="showAll" rv-on-click="hideRules"><?php _e('&uarr; Show less rules &uarr;','sw-wapf'); ?></a>
            </div>
            <div style="padding-top:15px;width: 100%;">
                <div rv-if="showAddNewRule">
                    <p rv-show="settings.swap_type | eq 'rules'">
		                <?php _e('You can add rules below. A rule holds a set of values which have to be true before showing that product image. If two or more rules are true, the last rule will be used.','sw-wapf'); ?>
                    </p>
                    <p rv-show="settings.swap_type | eq 'last'">
		                <?php _e('The product image changes based on the value of the last option changed by your visitor. You can set an image for each option value below.','sw-wapf'); ?>
                    </p>
                    <a href="#" rv-on-click="addGalleryImage" class="button button-small"><?php _e('Add new','sw-wapf'); ?></a>
                </div>
                <div rv-if="showAddNewRule | eq false">
                    <p>
                        <i><?php _e("You can't add any rules yet. Please add at least one of these fields first: true-false, select, swatches, checkboxes, or radio buttons. Make sure option-fields have at least one option added.",'sw-wapf'); ?></i>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

