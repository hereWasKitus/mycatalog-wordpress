/**
 * Gallery popup
 */
(function () {

  if (document.querySelector('.js-gallery-popup') === null ) return;

  const GalleryPopup = function () {
    this.popup = document.querySelector('.js-gallery-popup');
    this.triggers = document.querySelectorAll('.c-product-images img');
    this.arrows = this.popup.querySelectorAll('.gallery-popup__arrow');
    this.active = 0;

    this.bindEvents();
  }

  GalleryPopup.prototype = {
    open (e) {
      window.blockBodyScroll();
      this.activate( e.currentTarget.dataset.index );
      this.popup.classList.add('is-active');
    },

    close (e) {
      this.popup.classList.remove('is-active');
      window.enableBodyScroll();
    },

    bindEvents () {
      this.triggers.forEach( trigger => trigger.addEventListener('click', this.open.bind(this)) );

      this.arrows.forEach( arrow => arrow.addEventListener('click', (e) => {
        e.preventDefault();
        let index = parseInt(this.active) + parseInt(e.currentTarget.dataset.direction);
        this.activate(index);
      }) );

      this.popup.addEventListener('click', (e) => {
        if ( !e.target.classList.contains('js-gallery-popup') ) return;
        this.close();
      });

      this.popup.querySelector(".gallery-popup__button-close").addEventListener('click', (e) =>{
        this.close();
      });

      this.popup.querySelectorAll('.gallery-popup__small-image').forEach(img => img.addEventListener('click', e => {
        let index = parseInt(e.currentTarget.dataset.index);
        this.activate(index);
      }));
    },

    activate ( index ) {
      var new_active = this.popup.querySelector(`[data-index="${index}"]`);

      if ( new_active === null ) return;

      [this.active, index].forEach(i => {
        this.popup.querySelectorAll(`[data-index="${i}"]`).forEach(img => img.classList.toggle('is-active'));
      });

      new_active.animate([
        {opacity: '0'},
        {opacity: '1'},
      ], {
        fill: 'forwards',
        duration: 300
      });

      this.active = index;
    }
  }

  new GalleryPopup();

})();