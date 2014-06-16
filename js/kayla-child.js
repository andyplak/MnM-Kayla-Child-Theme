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
});