( function () {

  const HeaderMenu = function () {
    this.button = document.querySelector('.menu-button');
    this.menu_wrapper = document.querySelector('.header__menu');

    this.bindEvents();
  }

  HeaderMenu.prototype = {
    bindEvents () {
      this.button.addEventListener( 'click', () => this.toggleMenu() );
    },

    toggleMenu () {
      this.menu_wrapper.classList.toggle('is-active');
    }
  }

  new HeaderMenu();

})();