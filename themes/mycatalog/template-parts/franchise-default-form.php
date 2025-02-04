<form class="franchise-form js-franchise-form">
  <div class="franchise-form__column">
    <input class="franchise-form__field mb-22" type="text" name="name" placeholder="<?= __('Full Name', 'mycatalog') ?>">
    <input class="franchise-form__field mb-22" type="text" name="company" placeholder="<?= __('Company/Brand name', 'mycatalog') ?>">
    <input class="franchise-form__field" type="text" name="link" placeholder="<?= __('Link to your web resource', 'mycatalog') ?>">
    <input class="click-animation" type="submit" value="<?= __('send', 'mycatalog') ?>">
  </div>
  <div class="franchise-form__column">
    <input type="hidden" name="action" value="send_contact_form">
    <input class="franchise-form__field mb-22" type="email" name="email" placeholder="<?= __('Email', 'mycatalog') ?>" required>
    <input class="franchise-form__field mb-22" type="tel" name="phone" placeholder="<?= __('Phone number', 'mycatalog') ?>" required>
    <div class="franchise-form__textarea">
      <textarea class="js-custom-textarea" name="message" max-length="600" placeholder="<?= __('Your message', 'mycatalog') ?>"></textarea>
    </div>
  </div>
  <input class="click-animation" type="submit" value="<?= __('send', 'mycatalog') ?>">
</form>