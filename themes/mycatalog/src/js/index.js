/**
 * Ajax products search
 */
( function () {

  if ( document.querySelector('.products__search') === null ) return;

  const search_box = document.querySelector('[name="product-query"]');
  const search_category = document.querySelector('[name="products-category"]');
  const trigger = document.querySelector('.products__search-trigger');
  const products_body = document.querySelector('.products__grid');

  trigger.addEventListener('click', search);

  function search () {
    var form_data = new FormData();

    form_data.append('action', 'products_search');
    form_data.append('query', search_box.value);
    form_data.append('category', search_category.value);

    fetch( wp_data.ajax_url, { method: 'POST', body: form_data } )
      .then( resp => resp.json() )
      .then( data => products_body.innerHTML = data.body );
  }

} )();


/**
 * Custom select
 */
( function () {

  if ( document.querySelector('.custom-select') === null ) return;

  function customSelect (el) {
    const root = el;
    const wrapper = document.createElement('div');

    var toggleList = function () {
      wrapper.classList.toggle('is-active');
    }

    var init = function () {
      wrapper.classList.add('custom-select-container');

      var selected = document.createElement('span');
      selected.classList.add('custom-select-selected');

      var list = document.createElement('ul');
      list.classList.add('custom-select-list');

      root.querySelectorAll('option').forEach( (option, index) => {
        var list_item = document.createElement('li');
        list_item.classList.add('custom-select-list__item');
        list_item.textContent = option.textContent;
        list_item.dataset.value = option.value;

        if ( index == root.selectedIndex ) {
          list_item.classList.add('is-active');
          selected.textContent = list_item.textContent;
        }

        list.appendChild(list_item);
      } );

      root.after(wrapper);
      wrapper.appendChild(root);
      wrapper.appendChild(selected);
      wrapper.appendChild(list);

      wrapper.addEventListener('click', toggleList);
    }

    init();
  };

  document.querySelectorAll('.custom-select').forEach(el => customSelect(el));

} )();


/**
 * History hack
 */
(function () {
  if ( document.querySelector('.js-history-back') === null ) return;

  document.querySelectorAll('.js-history-back').forEach(btn => btn.addEventListener('click', goBack));

  function goBack () {
    window.history.back();
  }
})();

/**
 * Multiple file uploader
 */
(function () {
  if ( document.querySelector('.js-add-file') === null ) return;

  var files = [];
  var file_input = document.querySelector('.js-file-input');

  file_input.addEventListener('change', handleUpload);

  function handleUpload (e) {
    e.preventDefault();
    files = [...files, ...this.files];
  }

  // 1. Handle submit and create formdata
  // 2. Go through files array and set files[] key in formdata
  // 3. Send formdata
})();