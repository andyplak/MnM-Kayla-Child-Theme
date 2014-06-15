<?php
/*
 * Default Events List Template
 * This page displays a list of events, called during the em_content() if this is an events list page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output()
 * 
 */
$args = apply_filters('em_content_events_args', $args);

global $EM_Event;
$EM_Event_old = $EM_Event; //When looping, we can replace EM_Event global with the current event in the loop
//get page number if passed on by request (still needs pagination enabled to have effect)
if( !empty($args['pagination']) && !array_key_exists('page',$args) && !empty($_REQUEST['pno']) && is_numeric($_REQUEST['pno']) ){
	$page = $args['page'] = $_REQUEST['pno'];
}
//Can be either an array for the get search or an array of EM_Event objects
if( is_object(current($args)) && get_class((current($args))) == 'EM_Event' ){
	$func_args = func_get_args();
	$events = $func_args[0];
	$args = (!empty($func_args[1]) && is_array($func_args[1])) ? $func_args[1] : array();
	$args = apply_filters('em_events_output_args', EM_Events::get_default_search($args), $events);
	$limit = ( !empty($args['limit']) && is_numeric($args['limit']) ) ? $args['limit']:false;
	$offset = ( !empty($args['offset']) && is_numeric($args['offset']) ) ? $args['offset']:0;
	$page = ( !empty($args['page']) && is_numeric($args['page']) ) ? $args['page']:1;
	$events_count = count($events);
}else{
	//Firstly, let's check for a limit/offset here, because if there is we need to remove it and manually do this
	$args = apply_filters('em_events_output_args', EM_Events::get_default_search($args));
	$limit = ( !empty($args['limit']) && is_numeric($args['limit']) ) ? $args['limit']:false;
	$offset = ( !empty($args['offset']) && is_numeric($args['offset']) ) ? $args['offset']:0;
	$page = ( !empty($args['page']) && is_numeric($args['page']) ) ? $args['page']:1;
	$args_count = $args;
	$args_count['limit'] = false;
	$args_count['offset'] = false;
	$args_count['page'] = false;
	$events_count = EM_Events::count($args_count);
	$events = EM_Events::get( $args );
}


if( get_option('dbem_css_evlist') ) echo "<div class='css-events-list'>";

//echo EM_Events::output( $args );

$events = apply_filters('em_events_output_events', $events);
if ( $events_count > 0 ) {

?>
<div class="styled_table">
<table class="table table-bordered table-striped mnm-events-list">
	<thead>
		<tr>
			<th class="event-description">Event</th>
			<th class="event-time">Date &amp; Time</th>
			<th class="event-age">Age</th>
			<th class="event-status">Status</th>
			<th class="event-price">Price</th>
			<th class="event-action"></th>
		</tr>
	</thead>
	<tbody>

	<?php foreach ( $events as $EM_Event ) : ?>
		<tr>
			<td class="event-desc">
				<?php if( has_post_thumbnail($EM_Event->ID) ) : ?>
					<?php echo get_the_post_thumbnail( $EM_Event->ID, array(50, 50)); ?>
				<?php endif ?>
				<?php echo $EM_Event->event_name ?>
			</td>
	  		<td>
	  			<i class="wt-icon-calendar"></i>
				<?php
					//$date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format'):get_option('date_format');
					$date_format = 'l jS \o\f F';
					if( $EM_Event->event_start_date != $EM_Event->event_end_date){
						echo date_i18n($date_format, $EM_Event->start). get_option('dbem_dates_separator') . date_i18n($date_format, $EM_Event->end);
					}else{
						echo date_i18n($date_format, $EM_Event->start);
					}
				?>
				<br/>
				<i class="wt-icon-time"></i>
				<?php
					if( !$EM_Event->event_all_day ){
						$time_format = ( get_option('dbem_time_format') ) ? get_option('dbem_time_format'):get_option('time_format');
						if($EM_Event->event_start_time != $EM_Event->event_end_time ){
							echo date_i18n($time_format, $EM_Event->start). get_option('dbem_times_separator') . date_i18n($time_format, $EM_Event->end);
						}else{
							echo date_i18n($time_format, $EM_Event->start);
						}
					}else{
						echo get_option('dbem_event_all_day_message');
					}
				?>
			</td>
			<td>
			<?php if( mnm_is_speed_dating_event( $EM_Event ) ) : ?>
				<?php echo $EM_Event->event_attributes['Age Range'] ?>
			<?php endif; ?>
			</td>
			<td>
			<?php if( mnm_is_speed_dating_event( $EM_Event ) ) {
				foreach( $EM_Event->get_tickets()->tickets as $EM_Ticket) {
					if( $EM_Ticket->ticket_name == 'Male' || $EM_Ticket->ticket_name == 'Female' ) {

						if( $EM_Ticket->ticket_name == 'Male' ) {
							echo "♂ ";
						}
						if( $EM_Ticket->ticket_name == 'Female' ) {
							echo "♀ ";
						}

						$prices[ $EM_Ticket->ticket_name ] = $EM_Ticket->get_price(true);

						if( $EM_Ticket->get_spaces() > 2 ) {
							echo '<span class="spaces-avail">Spaces Available</span>';
						} elseif( $EM_Ticket->get_spaces() > 0 ) {
							echo '<span class="spaces-last">Last Spaces</span>';
						}else{
							echo '<span class="spaces-sold-out">Sold out</span>';
						}
					}
					echo '<br />';
				}
			} ?>
			</td>
			<td>
			<?php if( mnm_is_speed_dating_event( $EM_Event ) ) : ?>
				<?php if( $prices['Male'] == $prices['Female'] ): ?>
					<?php echo $prices['Male'] ?>
				<?php else: ?>
					<?php echo $prices['Male'] ?><br />
					<?php echo $prices['Female'] ?>
				<?php endif; ?>
			<?php endif ?>
			</td>
			<td>
				<a class="wt_button marine small" href="<?php echo $EM_Event->get_permalink() ?>">More details</a>
			</td>
		</tr>
	<?php endforeach; ?>

	</tbody>
</table>
</div>

<?php
	//Pagination (if needed/requested)
	if( !empty($args['pagination']) && !empty($limit) && $events_count > $limit ){
		echo EM_Events::get_pagination_links($args, $events_count);
	}
} else {
	echo get_option ( 'dbem_no_events_message' );
}

$EM_Event = $EM_Event_old;


if( get_option('dbem_css_evlist') ) echo "</div>";