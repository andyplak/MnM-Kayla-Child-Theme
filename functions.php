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

function mnm_kayla_enqueue_scripts() {
  wp_enqueue_script('mnm-kayla-child', get_stylesheet_directory_uri().'/js/kayla-child.js', array('jquery'));
}
add_action('em_enqueue_scripts', 'mnm_kayla_enqueue_scripts');


/**
 * Breadcrumbs don't work properly on EM sections. Attempt to fix that here
 */
function mnm_kayla_breadcrumbs_plus( $breadcrumbs ) {
  global $wp_query;

  if( function_exists( 'em_init' ) ) {

    if ( get_option('show_on_front') == 'page' &&
      (em_is_event_page() ||  em_is_location_page() ) ) {
      // If site does not have blog as homepage, breadcrumbs-plus will add current page as the second
      // link as it is EM unaware, so strip that out here.
      $pos = strpos($breadcrumbs, '</span>');
      $start = substr($breadcrumbs, 0, $pos+7);
      $end = substr($breadcrumbs, $pos+7);

      $pos = strpos($end, '</span>');
      $end = substr($end, $pos+7);

      $breadcrumbs = $start . $end;
    }


    if ( em_is_event_page() ) {

      // Find last occurance of seperator span close tag, and insert Events page
      $pos = strrpos($breadcrumbs, '</span>');
      $start = substr($breadcrumbs, 0, $pos+7);
      $end = substr($breadcrumbs, $pos+7);
      $events = ' <a href="'.get_site_url().'/'.EM_POST_TYPE_EVENT_SLUG.'">Events</a> <span class="breadcrumbs-separator">/</span>';
      $breadcrumbs = $start . $events . $end;
    }

    if ( em_is_location_page() ) {
      // Find last occurance of seperator span close tag, and insert Locations page
      $pos = strrpos($breadcrumbs, '</span>');
      $start = substr($breadcrumbs, 0, $pos+7);
      $end = substr($breadcrumbs, $pos+7);
      $events = ' <a href="'.get_site_url().'/'.EM_POST_TYPE_LOCATION_SLUG.'">Locations</a> <span class="breadcrumbs-separator">/</span>';
      $breadcrumbs = $start . $events . $end;
    }
  }

  return $breadcrumbs;
}

add_filter( 'breadcrumbs_plus', 'mnm_kayla_breadcrumbs_plus', 10, 1);