<?php
/*
Theme My Login override of profile template.
*/


	// Prep for recommended events
	$EM_Events = EM_Events::get();

	$recommended_events = array();

	foreach( $EM_Events as $EM_Event ) {
		if( mnm_is_speed_dating_event( $EM_Event ) && mnm_user_matches_event_criteria( $user, $EM_Event ) ) {
			$recommended_events[] = $EM_Event;
		}
	}

	// Prep for media manager
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	$modal_update_href = esc_url( add_query_arg( array(
		'page'     => 'my_media_manager',
		'_wpnonce' => wp_create_nonce( 'my_media_manager_options' ),
	), admin_url( 'upload.php' ) ) );

?>

<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">

	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>

		<input type="hidden" name="from" value="profile" />
		<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />

		<?php $template->the_action_template_message( 'profile' ); ?>
		<?php $template->the_errors(); ?>


		<div class="one_half">

			<div class="framed_box rounded">
				<h6 class="framed_box_title">My Profile</h6>

				<div class="framed_box_content clearfix">

					<?php if ( has_action( 'personal_options' ) ) : ?>

					<h3><?php _e( 'Personal Options' ); ?></h3>

					<table class="form-table">
					<?php do_action( 'personal_options', $profileuser ); ?>
					</table>

					<?php endif; ?>

					<?php do_action( 'profile_personal_options', $profileuser ); ?>

					<table class="form-table">

					<tr>
						<th><label for="pic">Picture</label></th>
						<td>
							<img id="profile_pic_img" src="<?php echo wp_get_attachment_thumb_url( get_the_author_meta( 'profile_pic', $user->ID ) ); ?>" />
							<input type="hidden" name="profile_pic" id="profile_pic" value="<?php echo esc_attr( get_the_author_meta( 'profile_pic', $user->ID ) ); ?>" class="regular-text" />
							<button id="profile_pic_button" class="upload_image_button wt_button black_alt small"
								data-update-link="<?php echo esc_attr( $modal_update_href ); ?>"
								data-uploader-title="<?php esc_attr_e( 'Choose a Profile Image' ); ?>"
								data-uploader-button-text="<?php esc_attr_e( 'Set as profile image' ); ?>" value="upload"><?php _e( 'Set profile image' ); ?>
							</button>
						</td>
					</tr>

					<tr>
						<th><label for="first_name"><?php _e( 'First Name' ); ?></label></th>
						<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
					</tr>

					<tr>
						<th><label for="last_name"><?php _e( 'Last Name' ); ?></label></th>
						<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
					</tr>

					<!--
					<tr>
						<th><label for="nickname"><?php _e( 'Nickname' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
						<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
					</tr>

					<tr>
						<th><label for="display_name"><?php _e( 'Display name publicly as' ); ?></label></th>
						<td>
							<select name="display_name" id="display_name">
							<?php
								$public_display = array();
								$public_display['display_nickname']  = $profileuser->nickname;
								$public_display['display_username']  = $profileuser->user_login;

								if ( ! empty( $profileuser->first_name ) )
									$public_display['display_firstname'] = $profileuser->first_name;

								if ( ! empty( $profileuser->last_name ) )
									$public_display['display_lastname'] = $profileuser->last_name;

								if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
									$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
									$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
								}

								if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
									$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

								$public_display = array_map( 'trim', $public_display );
								$public_display = array_unique( $public_display );

								foreach ( $public_display as $id => $item ) {
							?>
								<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
							<?php
								}
							?>
							</select>
						</td>
					</tr>
				-->

					<tr>
						<th><label for="email"><?php _e( 'E-mail' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
						<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
					</tr>

					<?php
					$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
					if ( $show_password_fields ) :
					?>
					<tr id="password">
						<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
						<td><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /> <span class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.' ); ?></span><br />
							<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /> <span class="description"><?php _e( 'Type your new password again.' ); ?></span><br />
							<div id="pass-strength-result"><?php _e( 'Strength indicator', 'theme-my-login' ); ?></div>
							<p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>

<!--
					<tr>
						<th><label for="url"><?php _e( 'Website' ); ?></label></th>
						<td><input type="text" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ); ?>" class="regular-text code" /></td>
					</tr>
-->
					<?php
						foreach ( _wp_get_user_contactmethods() as $name => $desc ) {
					?>
					<tr>
						<th><label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label></th>
						<td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ); ?>" class="regular-text" /></td>
					</tr>
					<?php
						}
					?>

					<tr>
						<th><label for="description"><?php _e( 'Short Bio' ); ?></label></th>
						<td><textarea name="description" id="description" rows="5" cols="30" placeholder="Tell a little bit more about yourself"><?php echo esc_html( $profileuser->description ); ?></textarea></td>
					</tr>

					</table>

					<?php do_action( 'show_user_profile', $profileuser ); ?>

				</div>
			</div>
		</div>

		<div class="one_half last">

			<div class="framed_box rounded">
				<h6 class="framed_box_title">My Matches</h6>
				<div class="framed_box_content clearfix">
					<?php mnm_my_past_speed_dating_events() ?>
				</div>
			</div>

			<!-- Photos -->
			<div class="framed_box rounded">
				<h6 class="framed_box_title">My Photos</h6>
				<div class="framed_box_content clearfix">
					<table class="my-photos">
						<?php for($i=1; $i<=6; $i++) : ?>
						<tr>
							<td>
								<img id="gallery_pic_<?php echo $i ?>_img" src="<?php echo wp_get_attachment_thumb_url( get_the_author_meta( 'gallery_pic_'.$i, $user->ID ) ); ?>" />
								<input type="hidden" name="gallery_pic_<?php echo $i ?>" id="gallery_pic_<?php echo $i ?>" value="<?php echo esc_attr( get_the_author_meta( 'gallery_pic_'.$i, $user->ID ) ); ?>" class="regular-text" />
								<button id="gallery_pic_<?php echo $i ?>_button" class="upload_image_button wt_button black_alt"
									data-update-link="<?php echo esc_attr( $modal_update_href ); ?>"
									data-uploader-title="<?php esc_attr_e( 'Choose a Gallery Image' ); ?>"
									data-uploader-button-text="<?php esc_attr_e( 'Set as gallery image' ); ?>" value="upload"><span><?php _e( 'Set gallery image' ); ?> <?php echo $i ?></span>
								</button>
							</td>
						</tr>
						<?php endfor; ?>
					</table>
				</div>
			</div>


			<div class="framed_box rounded">
				<h6 class="framed_box_title">My Settings</h6>
				<div class="framed_box_content clearfix email-subscription-container">
					<table class="form-table">
					</table>
				</div>
			</div>


			<div class="framed_box rounded">
				<h6 class="framed_box_title">Events you'll like</h6>

				<?php em_locate_template('templates/events-list.php', true, $recommended_events ); ?>
				<a class="pull-right pad-10" href="<?php echo get_site_url() ?>/<?php echo EM_POST_TYPE_EVENT_SLUG ?>">See more events »</a>
				<div class="clearfix"></div>
			</div>

		</div>

		<div class="clearfix"></div>

		<p class="submit">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary wt_button black_alt" value="<?php esc_attr_e( 'Update Profile' ); ?>" name="submit" />
		</p>

	</form>
</div>
