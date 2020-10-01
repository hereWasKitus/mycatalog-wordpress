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