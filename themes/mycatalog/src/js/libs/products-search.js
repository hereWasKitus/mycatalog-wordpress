/**
 * Ajax products search
 */
(function () {

  if (document.querySelector('.products-search') === null) return;

  const search_box = document.querySelector('[name="product-query"]');
  const search_category = document.querySelector('[name="products-category"]');
  const search_button = document.querySelector('.products-search__trigger');
  const products_body = document.querySelector('.products__grid');
  const hint_list = document.querySelector('.products-search__list');

  var typingTimer;
  const typingInterval = 1000;

  search_button.addEventListener('click', search);
  search_category.addEventListener('change', search );
  search_box.addEventListener('keydown', (e) => {
    clearTimeout(typingTimer);

    if ( e.key === 'Enter' ) {
      hideSearchHints();
      search();
      return;
    }

    if ( e.key === 'Escape' ) {
      hideSearchHints();
      return;
    }

    typingTimer = setTimeout(() => {
      if ( search_box.value == '' ) {
        hideSearchHints();
        return;
      }

      getSearchHints();
    }, typingInterval);
  });

  function search() {
    search_box.parentElement.classList.add('is-loading');
    var form_data = new FormData();

    form_data.append('action', 'products_search');
    form_data.append('query', search_box.value);
    form_data.append('category', search_category.value);

    fetch(wp_data.ajax_url, { method: 'POST', body: form_data })
      .then(resp => resp.json())
      .then(data => {
        products_body.innerHTML = data.body;
        search_box.parentElement.classList.remove('is-loading');
      });
  };

  function getSearchHints () {
    var form_data = new FormData();
    search_box.parentElement.classList.add('is-loading');

    form_data.append('action', 'get_search_hints');
    form_data.append('query', search_box.value);
    form_data.append('category', search_category.value);

    fetch(wp_data.ajax_url, { method: 'POST', body: form_data })
      .then(resp => resp.json())
      .then(data => {
        search_box.parentElement.classList.remove('is-loading');
        showSearchHints( data.body );
      });
  }

  function showSearchHints ( html ) {
    hint_list.innerHTML = html;
    hint_list.classList.add('is-active');

    hint_list.querySelectorAll('li').forEach( el => el.addEventListener('click', (e) => {
      search_box.value = e.currentTarget.textContent;
      search();
      hideSearchHints();
    }) );
  }

  function hideSearchHints () {
    hint_list.classList.remove('is-active');
  }

})();