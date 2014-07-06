<?php
  global $post;
  $EM_Location = em_get_location( $post->ID, 'post_id' );

  // Get featured image source link
  $ftrd_img_src = "";
  if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
    $ftrd_img_css = "background-image: url(".$thumbnail[0].")";
  }
?>
<?php get_header(); ?>
<?php //theme_generator('custom_header',$post->ID); ?></div>

  <header id="intro" class="clearfix">
    <div class="inner">
      <!--<div id="introType"> -->
      <div class="location-image" style="<?php echo $ftrd_img_css ?>">
        <h1><?php echo $EM_Location->output('#_LOCATIONNAME') ?> <?php echo $EM_Location->output('#_LOCATIONTOWN') ?></h1>
      </div>

      <div class="location-map">
        <?php echo $EM_Location->output('#_LOCATIONMAP') ?>
      </div>

    </div>
  </header>
</div>




<!-- End headerWrapper -->
<?php if ($enable_scrollorama=='true'):?>
<div id="wt_blocks" class="clearfix">
<?php endif; ?>

<?php theme_generator('containerWrapper',$post->ID);?>
<div id="containerWrapp" class="clearfix">
  <div id="wt_container" class="clearfix">
    <?php theme_generator('content',$post->ID);?>

    <?php theme_generator('breadcrumbs',$post->ID); ?>
    <div class="clearfix"></div>

    <div class="three_fourth">
      <div class="two_fifth">
        <?php echo $EM_Location->output('#_LOCATIONNOTES') ?>

        <?php if( $EM_Location->output('#_LATT{WEBSITE}') != '' ) : ?>
          <a class="pull-right pad-10" target="_new" href="<?php echo $EM_Location->output('#_LATT{WEBSITE}') ?>">Go to website</a>
        <?php endif; ?>
      </div>

      <div class="three_fifth last location-gallery">


        <?php $attachments = new Attachments( 'mnm_location_gallery', $product->ID ); ?>

        <?php if( $attachments->exist() ) : ?>

          <div class="image_frame styled_image">
            <span class="">
              <a data-rel="lightbox" class="overlay_zoom" title="<?php echo $attachments->field( 'title', 0 ); ?>" href="<?php echo $attachments->url( 0 ); ?>">
                <img class="custom" alt="<?php echo $attachments->field( 'title', 0 ); ?>" src="<?php echo $attachments->url( 0 ); ?>" />
              </a>
            </span>
          </div>

          <ul class="thumbnails">
          <?php while( $attachments->get() ) : ?>
            <li><a href="<?php echo $attachments->url(); ?>" data-title="<?php echo $attachments->field( 'title' ); ?>"><?php echo $attachments->image('thumbnail'); ?></a></li>
          <?php endwhile; ?>
          </ul>

        <?php endif; ?>

      </div>

      <div class="clearfix"></div>

      <div class="framed_box rounded">
        <h6 class="framed_box_title">Upcoming Events</h6>

      <?php
        $event_list_args = array(
          'limit'=> 5,
          'location' => $EM_Location->location_id
        );
        echo em_get_events_list_shortcode( $event_list_args );
      ?>
        <a class="pull-right pad-10" href="<?php echo get_site_url() ?>/<?php echo EM_POST_TYPE_EVENT_SLUG ?>">See more events</a>
        <div class="clearfix"></div>
      </div>

    </div>

    <div class="one_fourth last">
      <div class="framed_box rounded">
        <h6 class="framed_box_title">Getting There</h6>
        <div class="framed_box_content clearfix">
          <h5><i class="wt-icon-map-marker"></i> Address</h5>
          <p>
            <?php echo ( $EM_Location->output('#_LOCATIONNAME') != "" ? $EM_Location->output('#_LOCATIONNAME') .'<br />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONADDRESS') != "" ? $EM_Location->output('#_LOCATIONADDRESS') .',<br class="hide-sm" />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONTOWN') != "" ? $EM_Location->output('#_LOCATIONTOWN') .',' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONREGION') != "" ? $EM_Location->output('#_LOCATIONREGION') .',' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONPOSTCODE') != "" ? $EM_Location->output('#_LOCATIONPOSTCODE') .'<br />' : "" ) ?>

            <?php
              $directions_url = "http://maps.google.com.au/maps?daddr=";
              $directions_url.= $EM_Location->output('#_LOCATIONADDRESS').',+';
              $directions_url.= $EM_Location->output('#_LOCATIONTOWN').',+';
              $directions_url.= $EM_Location->output('#_LOCATIONPOSTCODE');
            ?>
            <a class="pull-right" target="_new" href="<?php echo $directions_url ?>">Get Driving directions</a>
          </p>

          <h5><i class="wt-icon-circle-arrow-down"></i> Parking</h5>
          <p><?php echo $EM_Location->output('#_LATT{Parking}') ?></p>
        </div>
      </div>

      <div class="framed_box rounded">
        <h6 class="framed_box_title">Locations Nearby</h6>
        <div class="framed_box_content clearfix">

        <?php
          // Load all locations
          $locations = EM_Locations::get();

          // Loop through, check if region matches
          foreach( $locations as $location ) {
            if(
              $location->location_attributes['Region'] == $EM_Location->location_attributes['Region']
              && $location->location_id != $EM_Location->location_id )
            {
              ?>
              <strong><a href="<?php echo get_site_url() ?>/locations/<?php echo $location->location_slug ?>">
                <?php echo $location->location_name ?></a>
              </strong><br />
              <?php echo ( $location->output('#_LOCATIONADDRESS') != "" ? $location->output('#_LOCATIONADDRESS') .',' : "" ) ?>
              <?php echo ( $location->output('#_LOCATIONTOWN') != "" ? $location->output('#_LOCATIONTOWN') .',' : "" ) ?>
              <?php echo ( $location->output('#_LOCATIONREGION') != "" ? $location->output('#_LOCATIONREGION') .',' : "" ) ?>
              <?php echo ( $location->output('#_LOCATIONPOSTCODE') != "" ? $location->output('#_LOCATIONPOSTCODE') .',' : "" ) ?>
              <?php echo ( $location->output('#_LOCATIONCOUNTRY') != "" ? $location->output('#_LOCATIONCOUNTRY') : "" ) ?>
              <?php
            }
          }
        ?>
          <a class="pull-right pad-10" href="<?php echo get_site_url() ?>/locations">See more locations</a>
        </div>
      </div>

    </div>

  <!-- End wt_content -->
</div>
<!-- End wt_container -->
</div>
<!-- End containerWrapper -->
</div>
<!-- End containerWrapp -->
<?php get_footer(); ?>