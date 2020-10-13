/**
 * Custom textarea
 */
(function () {

  const CustomTextarea = function ( el ) {
    this.textarea = el;
    this.data = {
      max_length: this.textarea.getAttribute('max-length'),
    },
    this.counter_el = '';

    this.render();
    this.bindEvents();
  }

  CustomTextarea.prototype = {
    render () {
      var wrapper = document.createElement('div');
      wrapper.classList.add('custom-textarea');

      this.counter_el = document.createElement('span');
      this.counter_el.classList.add('custom-textarea__counter');
      this.counter_el.textContent = this.renderCounterContent( this.textarea.textLength );

      this.textarea.after( wrapper );
      wrapper.append( this.textarea, this.counter_el );
    },

    renderCounterContent( length ) {
      return `${length}\\${this.data.max_length}`;
    },

    updateCounter () {
      this.counter_el.textContent = this.renderCounterContent( this.textarea.textLength );
    },

    validateLength () {
      if ( this.textarea.textLength > this.data.max_length ) {
        this.textarea.value = this.textarea.value.substring(0, this.data.max_length);
      }
    },

    bindEvents () {
      this.textarea.addEventListener( 'input', (e) => {
        this.validateLength();
        this.updateCounter();
      } );
    }
  };

  var textareas = document.querySelectorAll('.js-custom-textarea');

  if ( textareas.length ) {
    textareas.forEach(el => new CustomTextarea( el ) );
  }

})();