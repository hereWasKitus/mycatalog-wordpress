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
  search_box.addEventListener('keypress', (e) => {
    if ( e.key === 'Enter' ) {
      search();
    }
  })

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
  }

})();