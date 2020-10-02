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