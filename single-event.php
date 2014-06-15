<?php
/* 
 * Override EM default events display. Done at WP theme level where we override the single event page completely 
 * as described here - http://codex.wordpress.org/Post_Types#Template_Files
 */
global $post;
$EM_Event = em_get_event( $post->
ID, 'post_id' );
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

        <div class="framed_box rounded">
          <h6 class="framed_box_title">Date &amp Time</h6>
          <div class="framed_box_content clearfix">
            <p>
              <i class="wt-icon-calendar"></i><strong>
              <?php
                //$date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format'):get_option('date_format');
                $date_format = 'l jS \o\f F';
                if( $EM_Event->event_start_date != $EM_Event->event_end_date){
                  echo date_i18n($date_format, $EM_Event->start). get_option('dbem_dates_separator') . date_i18n($date_format, $EM_Event->end);
                }else{
                  echo date_i18n($date_format, $EM_Event->start);
                }
              ?>
              </strong>
              <br/>
              <?php
                if( !$EM_Event->event_all_day ){
                  $time_format = ( get_option('dbem_time_format') ) ? get_option('dbem_time_format'):get_option('time_format');
                  if($EM_Event->event_start_time != $EM_Event->event_end_time ){
                    echo 'From '.date_i18n($time_format, $EM_Event->start).' till '. date_i18n($time_format, $EM_Event->end);
                  }else{
                    echo date_i18n($time_format, $EM_Event->start);
                  }
                }else{
                  echo get_option('dbem_event_all_day_message');
                }
              ?>
            </p>
          </div>
        </div>

        <div class="framed_box rounded">
          <h6 class="framed_box_title">Participants</h6>
          <div class="framed_box_content clearfix">
            <?php
              foreach( $EM_Event->get_tickets()->tickets as $EM_Ticket ) {

                // Define class name if last iteration
                $last = ($EM_Ticket === end( $EM_Event->get_tickets()->tickets ) ? "last":"");
                echo '<div class="one_half '.$last.'">';

                if( $EM_Ticket->ticket_name == 'Male' ) {
                  echo "<h5>♂ Men</h5>";
                  echo "Age: ".$EM_Event->event_attributes['Age Range']; // Looks like we'll be needing age range for both genders
                }
                if( $EM_Ticket->ticket_name == 'Female' ) {
                  echo "<h5>♀ Female</h5>";
                  echo "Age: ".$EM_Event->event_attributes['Age Range'];
                }
                echo '<br />', mnm_kayla_show_ticket_availability( $EM_Ticket ), '</div>';
              }
            ?>
            <div class="clearboth"></div>
          </div>
        </div>

        <div class="framed_box rounded">
          <h6 class="framed_box_title">Location</h6>
          <div class="framed_box_content clearfix">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor dictum auctor. Sed magna felis, pulvinar in ultricies nec, viverra quis quam. Nulla sed feugiat purus.
              <br></p>
            <div class="clearboth"></div>
          </div>
        </div>

      </div>

      <div class="three_fifth last">

        <?php if( has_post_thumbnail( $EM_Event->ID ) ) : ?>
          <?php echo get_the_post_thumbnail( $EM_Event->ID, 'large'); ?>
        <?php endif ?>

        <?php echo $EM_Event->post_content ?>

      </div>

    </div>

    <div class="two_fifth last">

      <div class="framed_box rounded">
        <h6 class="framed_box_title">Book this event</h6>
        <div class="framed_box_content clearfix">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor dictum auctor. Sed magna felis, pulvinar in ultricies nec, viverra quis quam. Nulla sed feugiat purus.
            <br></p>
          <div class="clearboth"></div>
        </div>
      </div>

    </div>

    <div class="clearfix"></div>

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