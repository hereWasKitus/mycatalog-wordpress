<form class="franchise-form js-franchise-form">
  <div class="franchise-form__column">
    <input class="franchise-form__field mb-22" type="text" name="name" placeholder="<?= __('Full Name', 'mycatalog') ?>">
    <input class="franchise-form__field mb-22" type="text" name="company" placeholder="<?= __('Company/Brand name', 'mycatalog') ?>">
    <input class="franchise-form__field" type="text" name="link" placeholder="<?= __('Link to your web resource', 'mycatalog') ?>">
    <input class="click-animation" type="submit" value="send">
  </div>
  <div class="franchise-form__column">
    <input class="franchise-form__field mb-22" type="email" name="email" placeholder="<?= __('Email', 'mycatalog') ?>">
    <input class="franchise-form__field mb-22" type="tel" name="phone" placeholder="<?= __('Phone number', 'mycatalog') ?>">
    <div class="franchise-form__textarea">
      <textarea class="franchise-form__field" name="message" max-length="600" placeholder="Your message"></textarea>
    </div>
  </div>
</form>