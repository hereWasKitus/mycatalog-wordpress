/**
 * Multiple file uploader
 */
(function () {
  if (document.querySelector('.js-add-file') === null) return;

  var files = [];
  var file_input = document.querySelector('.js-file-input');

  file_input.addEventListener('change', handleUpload);

  function handleUpload(e) {
    e.preventDefault();
    files = [...files, ...this.files];
  }

  // 1. Handle submit and create formdata
  // 2. Go through files array and set files[] key in formdata
  // 3. Send formdata
})();