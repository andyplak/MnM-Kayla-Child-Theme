jQuery(document).ready(function($){
  
  // Style booking form button
  var bookingFormButton = $('#em-booking-submit');
  if( bookingFormButton.length ) {
    bookingFormButton.addClass('wt_button dark_green');
  }

  // Reposition login form links above booking form
  var bookingLogin = $('.em-booking-login');
  if( bookingLogin.length ) {
    bookingLogin.insertBefore( $('form.em-booking-form') );
  }

  // Create events page thumbnail gallery
  $('.location-gallery .thumbnails').mnmGal();
});



/*
 * mnmGal based on simpleGal
 * A simple image gallery plugin.
 * https://github.com/steverydz/simpleGal
 *
 * Made by Steve Rydz
 * Under MIT License
 */
(function($){

  $.fn.extend({

    mnmGal: function (options) {


      var defaults = {
        galleryDiv: ".location-gallery"
      };


      options = $.extend(defaults, options);

      return this.each(function () {

        var thumbnail = $(this).find("a"),
            galleryDiv = $(this).parent().find(options.galleryDiv);

        thumbnail.on("click", function (e) {
          e.preventDefault();

          var galleryItemIndex = $(this).data('gal-index');

          galleryDiv.find('.gallery_item').hide();
          galleryDiv.find('.gallery_item.'+galleryItemIndex).show();
        });

      });

    }

  });

})(jQuery);