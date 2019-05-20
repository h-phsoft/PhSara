$(document).ready(function () {

  $(".slider").slick({
    dots: true,
    center: true,
    infinite: true,
    variableWidth: true,
    mobileFirst: true
  });
  $('#lightgallery').lightGallery({
    share: false,
    download: false,
    counter: false,
    scale: 0.5
  });

});
