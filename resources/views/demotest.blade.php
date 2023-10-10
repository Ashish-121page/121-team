<!DOCTYPE html>
<html>

<head>
    <title>Upload Files using normal form and PHP</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/imgareaselect.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js">
    <script type="text/javascript" src="https://hammerjs.github.io/dist/hammer.min.js">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js">
    </script>
 

</head>

<body>

  
    <div class="container">
      
      <!-- default start -->
      <section id="default" class="padding-top0">
      <div class="row">
        <div class="large-12 column"><h3>Product Zooming</h3></div>
          <hr>
        <div class="large-5 column">
          <div class="xzoom-container">
            <img class="xzoom" id="xzoom-default" src="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/preview/01_b_car.jpg" xoriginal="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/original/01_b_car.jpg" />
            <div class="xzoom-thumbs">
              <a href="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/original/01_b_car.jpg"><img class="xzoom-gallery" width="80" src="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/thumbs/01_b_car.jpg"  xpreview="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/preview/01_b_car.jpg" title="The description goes here"></a>
                
              <a href="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/original/02_o_car.jpg"><img class="xzoom-gallery" width="80" src="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/preview/02_o_car.jpg" title="The description goes here"></a>
                
              <a href="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/original/03_r_car.jpg"><img class="xzoom-gallery" width="80" src="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/preview/03_r_car.jpg" title="The description goes here"></a>
                
              <a href="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/original/04_g_car.jpg"><img class="xzoom-gallery" width="80" src="http://www.jqueryscript.net/demo/Feature-rich-Product-Gallery-With-Image-Zoom-xZoom/images/gallery/preview/04_g_car.jpg" title="The description goes here"></a>
            </div>
          </div>        
        </div>
      </div>
      </section>
    </div>

  <footer>
    <hr>

  </footer>

    <script>
      (function ($) {
        $(document).ready(function() {
              $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 400, title: true, tint: '#333', Xoffset: 15});
              $('.xzoom2, .xzoom-gallery2').xzoom({position: '#xzoom2-id', tint: '#ffa200'});
              $('.xzoom3, .xzoom-gallery3').xzoom({position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden'});
              $('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
              $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});

              //Integration with hammer.js
              var isTouchSupported = 'ontouchstart' in window;

              if (isTouchSupported) {
                  //If touch device
                  $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function(){
                      var xzoom = $(this).data('xzoom');
                      xzoom.eventunbind();
                  });
                  
                  $('.xzoom, .xzoom2, .xzoom3').each(function() {
                      var xzoom = $(this).data('xzoom');
                      $(this).hammer().on("tap", function(event) {
                          event.pageX = event.gesture.center.pageX;
                          event.pageY = event.gesture.center.pageY;
                          var s = 1, ls;
          
                          xzoom.eventmove = function(element) {
                              element.hammer().on('drag', function(event) {
                                  event.pageX = event.gesture.center.pageX;
                                  event.pageY = event.gesture.center.pageY;
                                  xzoom.movezoom(event);
                                  event.gesture.preventDefault();
                              });
                          }
          
                          xzoom.eventleave = function(element) {
                              element.hammer().on('tap', function(event) {
                                  xzoom.closezoom();
                              });
                          }
                          xzoom.openzoom(event);
                      });
                  });

              $('.xzoom4').each(function() {
                  var xzoom = $(this).data('xzoom');
                  $(this).hammer().on("tap", function(event) {
                      event.pageX = event.gesture.center.pageX;
                      event.pageY = event.gesture.center.pageY;
                      var s = 1, ls;

                      xzoom.eventmove = function(element) {
                          element.hammer().on('drag', function(event) {
                              event.pageX = event.gesture.center.pageX;
                              event.pageY = event.gesture.center.pageY;
                              xzoom.movezoom(event);
                              event.gesture.preventDefault();
                          });
                      }

                      var counter = 0;
                      xzoom.eventclick = function(element) {
                          element.hammer().on('tap', function() {
                              counter++;
                              if (counter == 1) setTimeout(openfancy,300);
                              event.gesture.preventDefault();
                          });
                      }

                      function openfancy() {
                          if (counter == 2) {
                              xzoom.closezoom();
                              $.fancybox.open(xzoom.gallery().cgallery);
                          } else {
                              xzoom.closezoom();
                          }
                          counter = 0;
                      }
                  xzoom.openzoom(event);
                  });
              });
              
              $('.xzoom5').each(function() {
                  var xzoom = $(this).data('xzoom');
                  $(this).hammer().on("tap", function(event) {
                      event.pageX = event.gesture.center.pageX;
                      event.pageY = event.gesture.center.pageY;
                      var s = 1, ls;

                      xzoom.eventmove = function(element) {
                          element.hammer().on('drag', function(event) {
                              event.pageX = event.gesture.center.pageX;
                              event.pageY = event.gesture.center.pageY;
                              xzoom.movezoom(event);
                              event.gesture.preventDefault();
                          });
                      }

                      var counter = 0;
                      xzoom.eventclick = function(element) {
                          element.hammer().on('tap', function() {
                              counter++;
                              if (counter == 1) setTimeout(openmagnific,300);
                              event.gesture.preventDefault();
                          });
                      }

                      function openmagnific() {
                          if (counter == 2) {
                              xzoom.closezoom();
                              var gallery = xzoom.gallery().cgallery;
                              var i, images = new Array();
                              for (i in gallery) {
                                  images[i] = {src: gallery[i]};
                              }
                              $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                          } else {
                              xzoom.closezoom();
                          }
                          counter = 0;
                      }
                      xzoom.openzoom(event);
                  });
              });

              } else {
                  //If not touch device

                  //Integration with fancybox plugin
                  $('#xzoom-fancy').bind('click', function(event) {
                      var xzoom = $(this).data('xzoom');
                      xzoom.closezoom();
                      $.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
                      event.preventDefault();
                  });
                
                  //Integration with magnific popup plugin
                  $('#xzoom-magnific').bind('click', function(event) {
                      var xzoom = $(this).data('xzoom');
                      xzoom.closezoom();
                      var gallery = xzoom.gallery().cgallery;
                      var i, images = new Array();
                      for (i in gallery) {
                          images[i] = {src: gallery[i]};
                      }
                      $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                      event.preventDefault();
                  });
              }
            });
      })(jQuery);

    </script>
</body>

</html>
