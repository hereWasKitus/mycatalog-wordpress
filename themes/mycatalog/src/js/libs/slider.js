(function () {
if ( document.querySelector('.slick-last-products') && window.innerWidth <= 1024 ) {

  $('.slick-last-products').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true
  })

}
})();