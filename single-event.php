<?php
/*
 * Override EM default events display. Done at WP theme level where we override the single event page completely 
 * as described here - http://codex.wordpress.org/Post_Types#Template_Files
 */
global $post;
$EM_Event = em_get_event( $post->ID, 'post_id' );
?>
<?php get_header(); ?>
<?php theme_generator('custom_header',$post->ID); ?></div>
<!-- End headerWrapper -->
<?php if ($enable_scrollorama=='true'):?>
<div id="wt_blocks" class="clearfix">
<?php endif; ?>

<?php theme_generator('containerWrapper',$post->ID);?>
<div id="containerWrapp" class="clearfix">
  <div id="wt_container" class="clearfix">
    <?php theme_generator('content',$post->ID);?>
    <?php //theme_generator('breadcrumbs',$post->ID); ?>

    <?php if( mnm_is_speed_dating_event( $EM_Event ) ) : ?>
    <div class="three_fifth">
      <div class="two_fifth">

        <div class="framed_box date-n-time">
          <h6 class="framed_box_title">Date &amp; Time</h6>
          <div class="framed_box_content clearfix">
            <h5>
              <i class="wt-icon-calendar"></i>
              <?php echo $EM_Event->output('#_EVENTDATES') ?>
            </h5>

            from <?php echo $EM_Event->output('#_EVENTTIMES') ?>
            <?php /*
            <span class="tooltips">
              <a href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="We advise you to come 30 min earlier">
                <i class="wt-icon-info-sign"></i>
              </a>
            </span>
            */ ?>
            <br />

            <div class="pad-10">
              <a class="pull-right text-right hide-xs hide-sm" target="_blank" rel="nofollow"
                href="<?php echo $EM_Event->output('#_EVENTICALURL') ?>">Add to your calendar »</a>

              <a class="pull-right" target="_blank" rel="nofollow"
                href="<?php echo $EM_Event->output('#_EVENTGCALURL') ?>">Add to Google calendar »</a>

              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <div class="framed_box participants">
          <h6 class="framed_box_title">Participants</h6>
          <div class="framed_box_content clearfix">
            <?php
              foreach( $EM_Event->get_tickets()->tickets as $EM_Ticket ) {

                // Define class name if last iteration
                $last = ($EM_Ticket === end( $EM_Event->get_tickets()->tickets ) ? "last":"");
                echo '<div class="one_half '.$last.'">';

                if( $EM_Ticket->ticket_name == 'Male' ) {
                  echo '<h5><i class="mnm-icon male"></i> Men</h5>';
                  echo "Age: ".$EM_Event->event_attributes['Male Age Range'];
                }
                if( $EM_Ticket->ticket_name == 'Female' ) {
                  echo '<h5><i class="mnm-icon female"></i> Women</h5>';
                  echo "Age: ".$EM_Event->event_attributes['Female Age Range'];
                }
                echo '<br />', mnm_kayla_show_ticket_availability( $EM_Ticket ), '</div>';
              }
            ?>
            <div class="clearfix"></div>
          </div>
        </div>

      <?php if( !is_null( $EM_Location = $EM_Event->get_location() ) ) : ?>
        <div class="framed_box location">
          <h6 class="framed_box_title">Location</h6>
          <div class="framed_box_content clearfix">
            <h5>
              <i class="wt-icon-map-marker"></i>
              <?php echo $EM_Location->location_attributes['Region'] ?>
            </h5>

            <?php
              echo ( isset($EM_Location->location_name) ? $EM_Location->location_name.'<br />' : '');
              echo ( isset($EM_Location->location_address) ? $EM_Location->location_address.',<br class="hide-sm" /> ' : '');
              echo ( isset($EM_Location->location_town) ? $EM_Location->location_town.', ' : '');
              echo ( isset($EM_Location->location_postcode) ? $EM_Location->location_postcode.'<br />' : '');
            ?>

            <a class="pull-right pad-10" href="<?php echo $EM_Location->get_permalink() ?>">More details »</a>

          </div>
        </div>
      <?php endif; ?>

      </div>

      <div class="three_fifth last event-content">

        <?php if( has_post_thumbnail( $EM_Event->ID ) ) : ?>
          <span class="image_frame styled_image">
            <span class="image_holder" style="background-image: none;">
              <?php echo get_the_post_thumbnail( $EM_Event->ID, 'large'); ?>
            </span>
          </span>
        <?php endif ?>

        <div class="event-notes">
          <?php echo $EM_Event->output('#_EVENTNOTES'); ?>
        </div>

      </div>

    </div>

    <div class="two_fifth last">

      <div class="framed_box">
        <h6 class="framed_box_title">Book this event</h6>
        <div class="framed_box_content clearfix">
          <?php echo $EM_Event->output('#_BOOKINGFORM'); ?>
          <div class="clearboth"></div>
        </div>
      </div>

    </div>


    <div class="clearfix"></div>

    <div class="framed_box">
      <h6 class="framed_box_title">Similar Events like this</h6>

      <?php
        // Show events list for related events
        // Initially just events for the same location. Later on, tie into region
        $event_list_args = array('limit'=> 5);
        if( !is_null( $EM_Location = $EM_Event->get_location() ) ) {
          $event_list_args['location'] = $EM_Location->location_id;
        }
        echo em_get_events_list_shortcode( $event_list_args );
      ?>
      <a class="pull-right pad-10" href="<?php echo get_site_url() ?>/<?php echo EM_POST_TYPE_EVENT_SLUG ?>">See more events »</a>
      <div class="clearfix"></div>
    </div>

  <?php else: ?>
    <?php echo $EM_Event->output_single(); ?>
  <?php endif ?>
  </div>

  <!-- End wt_content -->
</div>
<!-- End wt_container -->
</div>
<!-- End containerWrapper -->
</div>
<!-- End containerWrapp -->
<?php get_footer(); ?>