/**
 * Multiple file uploader
 */
(function () {
  if (document.querySelector('.js-franchise-form') === null) return;

  var files = [],
    file_container = document.querySelector('.franchise-form-file-list'),
    form = document.querySelector('.js-franchise-form');

  if ( form.querySelector('.js-file-input') ) {
    form.querySelector('.js-file-input').addEventListener('change', onUpload);
  }

  form.addEventListener('submit', onSubmit);

  function onUpload (e) {
    e.preventDefault();
    files = [...files, ...e.currentTarget.files];
    showFiles();
  }

  async function onSubmit (e) {
    e.preventDefault();
    var form_data = new FormData(e.currentTarget);
    form_data.delete('files[]');

    files.forEach(file => {
      form_data.append('files[]', file);
    });

    var resp = await fetch(wp_data.ajax_url, {method: 'POST',body: form_data});
    var data = await resp.json();
    
    if(document.querySelector('input[name="email"]') && document.querySelector('input[name="phone"]'))
    {
      document.querySelector('input[name="email"]').classList.remove("form-field-invalid");
      document.querySelector('input[name="phone"]').classList.remove("form-field-invalid");
    }
    if(data['status']['response']==0){
      if(data['status']['errors']['email']==0){
        document.querySelector('input[name="email"]').classList.add("form-field-invalid");
      }
      if(data['status']['errors']['phone']==0){
        document.querySelector('input[name="phone"]').classList.add("form-field-invalid");
      }
    }
    else{
      window.blockBodyScroll();
      document.querySelector('.brief-popup-container').classList.add('is-active');
    }


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

  /**
   * Add New link field
   */
  document.querySelector('.add_link_field').addEventListener('click', function(){
    var element = document.querySelector('.franchise-form__field-link');
    var clone = element.cloneNode(true);
    var link_field_img = clone.querySelector('.link_field_img');
    clone.querySelector('input').value = '';
    link_field_img.classList.remove('add_link_field');
    link_field_img.classList.add('remove_link_field');

    element.querySelector('.link_field_img').classList.add('blocked_button');

    document.querySelector('.franchise-form__field-link').after(clone);
    
    //Delete extra link field
    document.querySelector('.remove_link_field').addEventListener('click', function(){
        document.querySelectorAll('.franchise-form__field-link')[1].remove();
        document.querySelector('.link_field_img').classList.remove('blocked_button');
    });

  });



  document.querySelectorAll('.brief-popup__close').forEach(btn => btn.addEventListener('click', e => {
    e.preventDefault();
    window.enableBodyScroll();
    document.querySelector('.brief-popup-container').classList.remove('is-active');
  }) );
})();