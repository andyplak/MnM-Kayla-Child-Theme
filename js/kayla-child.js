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



  // Uploading files
  var file_frame;
  $('.upload_image_button').live('click', function( event ){

    event.preventDefault();

    var button = $(this);
    var id = button.attr('id').replace('_button', ''); // id of element to be updated

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader-title' ),
      button: {
        text: $( this ).data( 'uploader-button-text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();

      //console.log( attachment );

      // Do something with attachment.id and/or attachment.url here
      $("#"+id).val(attachment.sizes.medium.url);
      $("#"+id+"_id").val(attachment.id);
    });

    // Finally, open the modal
    file_frame.open();
  });


  // Modify the profile form. Remove the "Further Information" header churned out by EM
  var furtherInfo = $('#your-profile h3:contains("Further Information")');
  furtherInfo.remove();

  var emailSubTableRow = $('#your-profile tr:contains("Speed Dating Email Settings")');
  emailSubTableRow.children('th').hide();
  console.log( emailSubTableRow );

  $('.email-subscription-container table').append(emailSubTableRow);
  

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