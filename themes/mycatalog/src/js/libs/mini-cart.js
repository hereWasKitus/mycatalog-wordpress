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