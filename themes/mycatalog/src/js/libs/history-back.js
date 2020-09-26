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