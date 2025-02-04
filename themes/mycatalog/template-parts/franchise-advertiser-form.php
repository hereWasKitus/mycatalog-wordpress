<form class="franchise-form js-franchise-form" enctype="multipart/form-data">
  <div class="franchise-form__column">
    <input class="franchise-form__field mb-22" type="text" name="name" placeholder="<?= __('Full Name', 'mycatalog') ?>">

    <input class="franchise-form__field mb-22" type="text" name="position" placeholder="<?= __('Your position in the company', 'mycatalog') ?>">

    <div class="franchise-form__textarea mb-22">
      <textarea class="js-custom-textarea" name="message" max-length="600" placeholder="<?= __('Your message', 'mycatalog') ?>"></textarea>
    </div>
  </div>

  <div class="franchise-form__column">
    <input class="franchise-form__field mb-22" type="text" name="company" placeholder="<?= __('Company name', 'mycatalog') ?>">
    <!-- FRANCHISE FORM FILE LINK -->
    <span class='franchise-form__field-link'>
      <input class="franchise-form__field mb-22" type="text" name="links[]" placeholder="<?= __('Link to your web resource', 'mycatalog') ?>">
      <div class="franchise-form__field-link-icon-wrapper">
        <img class="link_field_img add_link_field" src="<?= get_template_directory_uri() .'/assets/images/icon_add_link_field.svg' ?>" alt="">
      </div>
    </span>
    <input type="hidden" name="action" value="send_contact_form">
  </div>

  <!-- FRANCHISE FORM FILE -->
  <div class="franchise-form-file-container mb-22">
    <label class="franchise-form-file franchise-form-square click-animation" for="file">
      <input class="js-file-input" type="file" id="file" name="files[]">
      <img src="<?= get_template_directory_uri() . '/assets/images/clip.svg' ?>">
    </label>

    <div class="franchise-form-file-list"></div>

    <label class="franchise-form-add-file franchise-form-square js-add-file click-animation" for="file">
      <img src="<?= get_template_directory_uri() . '/assets/images/plus.svg' ?>">
    </label>

    <div class="franchise-form-file-formats">
      <p><?= __('You can also attach a file with your presentation or offer (PDF or MP4, up to XMB)', 'mycatalog') ?></p>
    </div>
  </div>
  <div class="franchise-form__row">
    <input class="click-animation" type="submit" value="<?= __('send', 'mycatalog') ?>">
  </div>
</form>