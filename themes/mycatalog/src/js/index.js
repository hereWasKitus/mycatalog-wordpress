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
/**
 * Custom input number
 */
// (function () {

//   if (document.querySelector('input[type="number"]') === null) return;

//   const InputNumber = function( el ) {
//     this.root = el;
//   }

//   InputNumber.prototype = {
//     render () {
//       const wrapper = document.createElement('div');
//       wrapper.classList.add('custom-input-number-container');

//       const btnUp = document.createElement('div');
//       btnUp.classList.add('custom-input-number__up');
//       btnUp.textContent = '+';
//       btnUp.addEventListener('click', this.set(1));

//       const btnDown = document.createElement('div');
//       btnDown.classList.add('custom-input-number__down');
//       btnDown.textContent = '-';
//       btnUp.addEventListener('click', this.set(-1));
//     },

//     set ( num ) {
//       this.root.value += num;
//     }
//   }
// })();
/**
 * Custom select
 */
(function () {

  if (document.querySelector('.custom-select') === null) return;

  function customSelect(el) {
    const root = el;
    const wrapper = document.createElement('div');

    function toggleList () {
      wrapper.classList.toggle('is-active');
    }

    function render () {
      wrapper.classList.add('custom-select-container');

      var selected = document.createElement('span');
      selected.classList.add('custom-select-selected');

      var list = document.createElement('ul');
      list.classList.add('custom-select-list');

      root.querySelectorAll('option').forEach((option, index) => {
        var list_item = document.createElement('li');
        list_item.classList.add('custom-select-list__item');
        list_item.textContent = option.textContent;
        list_item.dataset.value = option.value;
        list_item.dataset.index = index;

        if (index == root.selectedIndex) {
          list_item.classList.add('is-active');
          selected.textContent = list_item.textContent;
        }

        list_item.addEventListener('click', select.bind(this, list_item.dataset.index));
        list.appendChild(list_item);
      });

      root.after(wrapper);
      wrapper.appendChild(root);
      wrapper.appendChild(selected);
      wrapper.appendChild(list);

      wrapper.addEventListener('click', toggleList);
    }

    function select (index) {
      root.selectedIndex = index;

      wrapper.querySelector('.custom-select-selected').textContent = wrapper.querySelectorAll('.custom-select-list__item')[index].textContent;
      wrapper.querySelector('.is-active').classList.remove('is-active');
      wrapper.querySelectorAll('.custom-select-list li')[index].classList.add('is-active');
    }

    render();
  };

  document.querySelectorAll('.custom-select').forEach(el => customSelect(el));
})();
/**
 * Multiple file uploader
 */
(function () {
  if (document.querySelector('.js-add-file') === null) return;

  var files = [],
    file_container = document.querySelector('.franchise-form-file-list'),
    form = document.querySelector('.js-franchise-form');

  form.querySelector('.js-file-input').addEventListener('change', onUpload);
  form.addEventListener('submit', onSubmit);

  function onUpload (e) {
    e.preventDefault();
    files = [...files, ...e.currentTarget.files];
    showFiles();
  }

  function onSubmit (e) {
    e.preventDefault();
    var form_data = new FormData(e.currentTarget);
    form_data.delete('files[]');

    files.forEach(file => {
      form_data.append('files[]', file);
    });

    fetch(wp_data.ajax_url, {
      method: 'POST',
      body: form_data
    })
      .then( resp => resp.json() )
      .then( data => console.log(data) );
  }

  function showFiles () {
    file_container.innerHTML = '';

    files.forEach((file, index) => {
      var name_array = file.name.split('.');
      var ext = name_array[name_array.length - 1];

      var file_item = document.createElement('div');
      file_item.classList.add('franchise-form-file-item', 'franchise-form-square');

      var file_item_text = document.createElement('span');
      file_item_text.textContent = ext;

      var file_item_close_btn = document.createElement('div');
      file_item_close_btn.classList.add('close');
      file_item_close_btn.dataset.index = index;
      file_item_close_btn.addEventListener('click', onDelete);

      file_item.append(file_item_text, file_item_close_btn);

      file_container.append(file_item);
    });
  }

  function removeFile(index, file_list) {
    file_list.splice(index, 1);
    showFiles();
  }

  function onDelete (e) {
    var duration = 300,
      frames = [{ transform: 'scale(1)' }, { transform: 'scale(0)' }],
      options = { duration, fill: 'forwards' },
      index = e.currentTarget.dataset.index;

    e.currentTarget
      .parentElement
      .animate(frames, options);

    setTimeout(() => {
      removeFile(index, files);
    }, duration + 100);
  }

  // 1. Handle submit and create formdata
  // 2. Go through files array and set files[] key in formdata
  // 3. Send formdata
})();
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
/**
 * History hack
 */
(function () {
  if (document.querySelector('.js-history-back') === null) return;

  document.querySelectorAll('.js-history-back').forEach(btn => btn.addEventListener('click', goBack));

  function goBack() {
    window.history.back();
  }
})();
/**
 * Custom mini cart
 */
(function () {

  if ( document.querySelector('.js-mini-cart') === null ) return;

  const mini_cart = document.querySelector('.js-mini-cart'),
        trigger = mini_cart.querySelector('.mini-cart__icon');

  trigger.addEventListener('click', toggleList);

  if ( close !== null ) {
    mini_cart
      .querySelectorAll('.mini-cart-item__remove')
      .forEach( el => el.addEventListener('click', removeItem) );
  }

  function toggleList (e) {
    mini_cart.classList.toggle('is-active');
  }

  function removeItem (e) {
    e.preventDefault();
    var current_target = e.currentTarget;

    var form_data = new FormData();
    var data = {
      action: 'product_remove',
      product_id: current_target.dataset.product_id,
      cart_item_key: current_target.dataset.cart_item_key
    };

    for (let key in data) {
      form_data.append(key, data[key]);
    }

    fetch(wp_data.ajax_url, {
      method: 'POST',
      body: form_data
    })
    .then(resp => resp.json() )
    .then(data => {
      if ( data.fragments.cart_count == 0 ) {
        mini_cart.querySelector('.mini-cart-container').innerHTML = data.fragments.empty_message_fragment;
        return;
      } else {
        delete data.fragments.cart_count;
        delete data.fragments.empty_message_fragment;
      }

      for (const key in data.fragments) {
        document.querySelector(key).outerHTML = data.fragments[key];
      }

      var frames = [ { opacity: '1', transform: 'translateX(0)' }, { opacity: '0', transform: 'translateX(100%)' } ];
      var options = { duration: 300, fill: 'forwards' };

      current_target.parentElement.animate(frames, options);

      setTimeout(() => {
        current_target.parentElement.remove();
      }, 400);
    })
  }
})();
( function () {

  if ( document.querySelector('.js-newsletter-form') === null ) return;

  const form = document.querySelector('.js-newsletter-form');

  form.addEventListener('submit', subscribe);

  function subscribe (e) {
    e.preventDefault();

    var formData = new FormData( e.currentTarget );

    fetch(wp_data.ajax_url, {method: 'POST',body: formData})
      .then( resp => resp.json() )
      .then( data => {
        if ( data.success ) {
          form.outerHTML = `<p class="footer__success-message">${data.message}</p>`
        }
      } );
  }

} )();
/**
 * Ajax products search
 */
(function () {

  if (document.querySelector('.products__search') === null) return;

  const search_box = document.querySelector('[name="product-query"]');
  const search_category = document.querySelector('[name="products-category"]');
  const trigger = document.querySelector('.products__search-trigger');
  const products_body = document.querySelector('.products__grid');

  trigger.addEventListener('click', search);

  function search() {
    var form_data = new FormData();

    form_data.append('action', 'products_search');
    form_data.append('query', search_box.value);
    form_data.append('category', search_category.value);

    fetch(wp_data.ajax_url, { method: 'POST', body: form_data })
      .then(resp => resp.json())
      .then(data => products_body.innerHTML = data.body);
  }

})();
window.scrollPosition = 0;
window.blockBodyScroll = function () {
  window.scrollPosition = window.pageYOffset;
  document.body.style.overflow = 'hidden';
  document.body.style.position = 'fixed';
  document.body.style.top = `-${window.scrollPosition}px`;
  document.body.style.width = '100%';
}

window.enableBodyScroll = function () {
  document.body.style.removeProperty('overflow');
  document.body.style.removeProperty('position');
  document.body.style.removeProperty('top');
  document.body.style.removeProperty('width');
  window.scrollTo(0, window.scrollPosition);
}