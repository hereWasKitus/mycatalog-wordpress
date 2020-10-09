(function () {
if ( document.querySelector('.slick-last-products') && window.innerWidth <= 1024 ) {

  var is_rtl = wp_data.is_rtl == 1;

  $('.slick-last-products').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    rtl: is_rtl
  })

}
})();