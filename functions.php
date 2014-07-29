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


/************** Profile Page Changes *****************/

// http://www.webdesign.org/content-management-system/wordpress/powerful-ways-to-customize-wordpress-user-profiles.22145.html

/**
 * User profile field customisation
 */
function mnm_kayla_hide_instant_messaging( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['yim']);
  unset($contactmethods['jabber']);
  return $contactmethods;
}
add_filter('user_contactmethods','mnm_kayla_hide_instant_messaging',10,1);


/**
 * Add additional profile fields
 */
function mnm_kayla_show_edit_user_profile( $user ) {


  $modal_update_href = esc_url( add_query_arg( array(
    'page'     => 'my_media_manager',
    '_wpnonce' => wp_create_nonce( 'my_media_manager_options' ),
  ), admin_url( 'upload.php' ) ) );
?>

<table class="form-table profile-pic">
  <tr>
    <th><label for="pic">Profile Image</label></th>
    <td>
      <img src="<?php echo esc_attr( get_the_author_meta( 'profile_pic', $user->ID ) ); ?>"><br />
      <input type="text" name="profile_pic" id="profile_pic" value="<?php echo esc_attr( get_the_author_meta( 'profile_pic', $user->ID ) ); ?>" class="regular-text" />
      <button id="profile_pic_button" class="upload_image_button"
        data-update-link="<?php echo esc_attr( $modal_update_href ); ?>"
        data-uploader-title="<?php esc_attr_e( 'Choose a Profile Image' ); ?>"
        data-uploader-button-text="<?php esc_attr_e( 'Set as profile image' ); ?>" value="upload"><?php _e( 'Set profile image' ); ?>
      </button>
    </td>
  </tr>
</table>

<table class="form-table social">
  <tr>
    <th>
      <label for="social">Facebook</label>
    </th>
    <td>
      <input type="url" name="Facebook" id="Facebook" placeholder="http://www.facebook.com/USERNAME" 
      value="<?php echo esc_attr( get_the_author_meta( 'Facebook', $user->ID ) ); ?>" class="regular-text" />
    </td>
  </tr>
  <tr>
    <th>
      <label for="social">Twitter</label>
    </th>
    <td>
      <input type="url" name="Twitter" id="Twitter" placeholder="http://www.twitter.com/USERNAME" 
      value="<?php echo esc_attr( get_the_author_meta( 'Twitter', $user->ID ) ); ?>" class="regular-text" />
    </td>
  </tr>
</table>

<table class="my-photos">
  <?php for($i=1; $i<=6; $i++) : ?>
  <tr>
    <td>
      <img src="<?php echo wp_get_attachment_thumb_url( get_the_author_meta( 'gallery_pic_'.$i.'_id', $user->ID ) ); ?>" />
      <input type="text" name="gallery_pic_<?php echo $i ?>" id="gallery_pic_<?php echo $i ?>" value="<?php echo esc_attr( get_the_author_meta( 'gallery_pic_'.$i, $user->ID ) ); ?>" class="regular-text" />
      <input type="hidden" name="gallery_pic_<?php echo $i ?>_id" id="gallery_pic_<?php echo $i ?>_id" value="<?php echo esc_attr( get_the_author_meta( 'gallery_pic_'.$i.'_id', $user->ID ) ); ?>" class="regular-text" />
      <button id="gallery_pic_<?php echo $i ?>_button" class="upload_image_button"
        data-update-link="<?php echo esc_attr( $modal_update_href ); ?>"
        data-uploader-title="<?php esc_attr_e( 'Choose a Gallery Image' ); ?>"
        data-uploader-button-text="<?php esc_attr_e( 'Set as gallery image' ); ?>" value="upload"><?php _e( 'Set gallery image' ); ?> <?php echo $i ?>
      </button>
    </td>
  </tr>
  <?php endfor; ?>
</table>
<?php
}
add_action( 'show_user_profile', 'mnm_kayla_show_edit_user_profile');
add_action( 'edit_user_profile', 'mnm_kayla_show_edit_user_profile');


/**
 * Configure custom image uploader
 *
 * http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 */
function mnm_kayla_profile_media_manager() {

  if ( ! did_action( 'wp_enqueue_media' ) ) {
    wp_enqueue_media();
  }

  ?>
  <script>

jQuery(document).ready(function($) {

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
});
  </script>
  <?php
}
add_action('admin_head','mnm_kayla_profile_media_manager');


function mnm_kayla_save_profile_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;
  update_usermeta( $user_id, 'profile_pic', $_POST['profile_pic'] );
  update_usermeta( $user_id, 'Facebook', $_POST['Facebook'] );
  update_usermeta( $user_id, 'Twitter', $_POST['Twitter'] );
  for($i=1; $i<=6; $i++) {
    update_usermeta( $user_id, 'gallery_pic_'.$i, $_POST['gallery_pic_'.$i] );
    update_usermeta( $user_id, 'gallery_pic_'.$i.'_id', $_POST['gallery_pic_'.$i.'_id'] );
  }
}
add_action( 'personal_options_update', 'mnm_kayla_save_profile_fields' );
add_action( 'edit_user_profile_update', 'mnm_kayla_save_profile_fields' );

