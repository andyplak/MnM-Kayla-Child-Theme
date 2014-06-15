<?php

/**
 * Enqueue style sheet, as parent Kayla theme doesn't use style.css
 */
function mnm_kayla_print_styles() {
  wp_enqueue_style( 'mnm-kayla-style', get_stylesheet_uri() );
}
add_action('wp_print_styles', 'mnm_kayla_print_styles', 50);

/**
 * Based on ticket availability show themed statement to suit
 */
function mnm_kayla_show_ticket_availability( $EM_Ticket ) {
  if( $EM_Ticket->get_spaces() > 2 ) {
    return '<span class="spaces-avail">Spaces Available</span>';
  } elseif( $EM_Ticket->get_spaces() > 0 ) {
    return '<span class="spaces-last">Last Spaces</span>';
  }else{
    return '<span class="spaces-sold-out">Sold out</span>';
  }
}

/**
 * Hook into booking form submit button so we can add out own classes
 */
function mnm_kayla_em_booking_form_buttons($input) {
  die('POW!');
  return '<input type="submit" class="em-booking-submit wt_button small white" value="Submit" />';
}
add_action('em_booking_form_buttons', 'mnm_kayla_em_booking_form_buttons', 10, 1);