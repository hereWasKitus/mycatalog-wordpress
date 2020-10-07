(function () {

  const CustomCheckbox = function (el) {
    this.checkbox = el;
    this.custom_el = '';
    this.render();
  }

  CustomCheckbox.prototype = {
    render () {
      this.custom_el = document.createElement('div');
      this.custom_el.classList.add('custom-checkbox');
      this.custom_el.addEventListener( 'click', () => this.check() );

      this.checkbox.after( this.custom_el );
      this.custom_el.append(this.checkbox);
    },

    check () {
      this.checkbox.checked = !this.checkbox.checked;
      this.custom_el.classList.toggle('is-checked');
    }
  }

  document.querySelectorAll('input[type=checkbox]')
    .forEach( el => new CustomCheckbox( el ) );

})();