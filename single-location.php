<?php
  global $post;
  $EM_Location = em_get_location( $post->ID, 'post_id' );

  // Get featured image source link
  $ftrd_img_src = "";
  if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
    $ftrd_img_css = "background: url(".$thumbnail[0].") no-repeat";
  }
?>
<?php get_header(); ?>
<?php //theme_generator('custom_header',$post->ID); ?></div>

  <header id="intro" class="clearfix">
    <div class="inner">
      <!--<div id="introType"> -->
      <div class="location-image" style="<?php echo $ftrd_img_css ?>">
        <h1><?php echo $EM_Location->output('#_LOCATIONNAME') ?></h1>
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
          <a class="pull-right" target="_new" href="<?php echo $EM_Location->output('#_LATT{WEBSITE}') ?>">Go to website >></a>
        <?php endif; ?>
      </div>

      <div class="three_fifth last location-gallery">

        <?php $attachments = new Attachments( 'mnm_location_gallery', $product->ID ); ?>

        <?php if( $attachments->exist() ) : ?>

          <span class="image_frame styled_image">
            <span class="image_holder" style="background-image: none;">
              <a class="no_link"><img src="<?php echo $attachments->url( 0 ); ?>" alt="<?php echo $attachments->field( 'title', 0 ); ?>" class="custom" style="visibility: visible; opacity: 1;"></a>
            </span>
          </span>

          <div class="thumb-container hidden-xs">
            <ul class="thumbnails">
            <?php while( $attachments->get() ) : ?>
              <li><a href="<?php echo $attachments->url(); ?>"><img src="<?php echo $attachments->url(); ?>" /></a></li>
            <?php endwhile; ?>
            </ul>
          </div>
        <?php endif; ?>

      </div>

      <div class="clearfix"></div>
    </div>

    <div class="one_fourth last">
      <div class="framed_box rounded">
        <h6 class="framed_box_title">Getting There</h6>
        <div class="framed_box_content clearfix">
          <h5><i class="wt-icon-map-marker"></i> Address</h5>
          <p>
            <?php echo ( $EM_Location->output('#_LOCATIONNAME') != "" ? $EM_Location->output('#_LOCATIONNAME') .'<br />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONADDRESS') != "" ? $EM_Location->output('#_LOCATIONADDRESS') .'<br />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONTOWN') != "" ? $EM_Location->output('#_LOCATIONTOWN') .'<br />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONREGION') != "" ? $EM_Location->output('#_LOCATIONREGION') .',' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONPOSTCODE') != "" ? $EM_Location->output('#_LOCATIONPOSTCODE') .'<br />' : "" ) ?>
            <?php echo ( $EM_Location->output('#_LOCATIONCOUNTRY') != "" ? $EM_Location->output('#_LOCATIONCOUNTRY') .'<br />' : "" ) ?>

            <?php
              $directions_url = "http://maps.google.com.au/maps?daddr=";
              $directions_url.= $EM_Location->output('#_LOCATIONADDRESS').',+';
              $directions_url.= $EM_Location->output('#_LOCATIONTOWN').',+';
              $directions_url.= $EM_Location->output('#_LOCATIONPOSTCODE');
            ?>
            <a class="pull-right" target="_new" href="<?php echo $directions_url ?>">Driving directions >></a>
          </p>

          <h5><i class="wt-icon-circle-arrow-down"></i> Parking</h5>
          <p><?php echo $EM_Location->output('#_LATT{Parking}') ?></p>
        </div>
      </div>
    </div>

    <div class="three_fourth">

      <div class="framed_box rounded">
        <h6 class="framed_box_title">Upcoming Events</h6>
        
      <?php
        $event_list_args = array(
          'limit'=> 5,
          'location' => $EM_Location->location_id
        );
        echo em_get_events_list_shortcode( $event_list_args );
      ?>
        <a class="pull-right pad-10" href="#">See more events >></a>
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="one_fourth last">
      <div class="framed_box rounded">
        <h6 class="framed_box_title">Locations Nearby</h6>
        <div class="framed_box_content clearfix">

        </div>
      </div>
    </div>


    <?php //echo  $EM_Location->output_single(); ?>


  <!-- End wt_content -->
</div>
<!-- End wt_container -->
</div>
<!-- End containerWrapper -->
</div>
<!-- End containerWrapp -->
<?php get_footer(); ?>