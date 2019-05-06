$(document).ready(function () {
  $('.gallery-items').click(function () {
    var imgSrc = this.src;
    var highResolutionImage = $(this).data('big');
    var viewer = ImageViewer();
    viewer.show(imgSrc, highResolutionImage);
  });
  $(".variable").slick({
    dots: true,
    infinite: true,
    variableWidth: true
  });
  var social_sharing_links = document.querySelectorAll('#social_sharing_links a');
  for (var i = social_sharing_links.length - 1; i >= 0; i--) {
    social_sharing_links[i].addEventListener('click', function () {
      return false;
    });
  }
  /*
   $('#artWork').click(function () {
   var original_image_width = $('artWork').width();
   var original_image_height = $('artWork').height();
   var width = $('artWork').width();
   var height = $('artWork').height();
   $('.powerzoom-highres').powerzoom($('#artWork'), {
   zoom: 5,
   maxZoom: 10,
   zoomTouch: 40,
   maxZoomTouch: 2,
   image_width: original_image_width,
   image_height: original_image_height,
   width: window.width,
   height: window.height,
   controls: '<span style="display:none;"></span>'
   });
   });
   */

});
