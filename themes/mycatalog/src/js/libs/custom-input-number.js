/**
 * Custom input number
 */
(function () {

  if ( document.querySelector('.quantity input[type="number"]') === null ) return;

  const CustomNumber = function (el) {
    this.root = el;
    this.custom_root = '';
    this.render();
    this.native_event = new Event('change', {bubbles: true});
  }

  CustomNumber.prototype = {
    render() {
      this.root.classList.add('custom-number__value');

      var custom_el = document.createElement('div');
      custom_el.classList.add('custom-number');

      var minus_el = document.createElement('div');
      minus_el.classList.add('custom-number__action', 'custom-number__action--minus');
      minus_el.textContent = '-';
      minus_el.addEventListener( 'click', this.updateValue.bind(this, -1) );

      var plus_el = document.createElement('div');
      plus_el.classList.add('custom-number__action', 'custom-number__action--plus');
      plus_el.textContent = '+';
      plus_el.addEventListener( 'click', this.updateValue.bind(this, 1) );

      this.root.after(custom_el);
      custom_el.append(minus_el, this.root, plus_el);
    },

    updateValue ( num ) {
      if ( parseInt(this.root.value) + num < 0 ) return;

      // fire native event to fix woocommerce update cart button behavior
      this.root.dispatchEvent( this.native_event );
      this.root.value = parseInt(this.root.value) + num;
    }
  };

  var inputs = document.querySelectorAll('.quantity input[type="number"]');
  inputs.forEach(element => {
    new CustomNumber(element);
  });

  jQuery('body').on('updated_wc_div', () => {
    var inputs = document.querySelectorAll('.quantity input[type="number"]');
    inputs.forEach(element => {
      new CustomNumber(element);
    });
  });

})();