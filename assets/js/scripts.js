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

  $('#lightgallery').lightGallery({
    share: false,
    download: false,
    counter: false
  });

});
