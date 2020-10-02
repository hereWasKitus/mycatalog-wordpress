(function () {

  if ( document.querySelector('.js-brief-popup') === null ) return;

  const BriefPopup = function () {
    this.popup = document.querySelector('.js-brief-popup');
    this.close_btns = this.popup.querySelectorAll('.brief-popup__close');

    this.bindEvents();
  }

  BriefPopup.prototype = {
    open () {
      this.popup.querySelector('form').classList.add('is-active');
      this.popup.querySelector('.brief-popup__thanks').classList.remove('is-active');
      this.popup.classList.add('is-active');
      window.blockBodyScroll();
      this.animate();
    },

    close () {
      window.enableBodyScroll();
      this.animate( 'reverse' );
      this.popup.classList.remove('is-active');
    },

    async onSubmit (e) {
      e.preventDefault();

      var form_data = new FormData( e.currentTarget );

      var resp = await fetch(wp_data.ajax_url, {body: form_data,method: 'POST'});
      var data = await resp.json();

      this.popup.querySelector('.brief-popup__header__title').textContent = data.message.header;
      this.popup.querySelector('form').classList.remove('is-active');
      this.popup.querySelector('.brief-popup__thanks').classList.add('is-active');
    },

    bindEvents () {
      this.close_btns.forEach( btn => btn.addEventListener('click', this.close.bind(this)) );
      this.popup.querySelector('form').addEventListener('submit', this.onSubmit.bind(this));
    },

    animate ( direction = 'normal' ) {
      this.popup.querySelector('.modal').animate([
        { transform: 'translateY(-100%)', opacity: '0' },
        { transform: 'translateY(0)', opacity: '1' }
      ], { fill: 'forwards', duration: 300, easing: 'ease', direction: direction });
    }
  }

  const brief = new BriefPopup();

  if ( document.querySelector('.franchise-button') !== null ) {
    document.querySelector('.franchise-button').addEventListener('click', function (e) {
      e.preventDefault();
      brief.open();
    });
  }

})();