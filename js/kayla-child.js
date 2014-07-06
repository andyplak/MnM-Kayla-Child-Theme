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
  $('.location-gallery .thumbnails').simpleGal({
      mainImage: '.custom'
  });
});



/*
 * simpleGal -v0.0.1
 * A simple image gallery plugin.
 * https://github.com/steverydz/simpleGal
 *
 * Made by Steve Rydz
 * Under MIT License
 */
(function($){

  $.fn.extend({

    simpleGal: function (options) {

      var defaults = {
        mainImage: ".placeholder"
      };

      options = $.extend(defaults, options);

      return this.each(function () {

        var thumbnail = $(this).find("a"),
            mainImage = $(this).parent().find(options.mainImage),
            lightBoxLink = $(this).parent().find('.overlay_zoom');

        thumbnail.on("click", function (e) {
          e.preventDefault();

          var galleryImage = $(this).attr("href"),
              galleryImageTitle = $(this).data('title');

          mainImage.attr("src", galleryImage);
          lightBoxLink.attr("href", galleryImage);
          lightBoxLink.attr("title", galleryImageTitle);
        });

      });

    }

  });

})(jQuery);