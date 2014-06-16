<?php
/* 
 * This file generates the default login form within the booking form (if enabled in options).
 */
?>
<div class="em-booking-login">
  <p><strong>Please 
    <a href="#event-login-modal" data-rel="lightbox[inline]" rel="lightbox[inline]">Login</a>
  </strong>
  <br />
  <p>If you are not already a member, please complete the form below to register for the event.</p>

  <div id="event-login-modal" class="hidden">

    <div class="modal-inner">

      <div class="wt_title">
        <h1>Member Login</h1>
      </div>

      <div class="one_half">
        <div class="framed_alt_box login_form">
          <form class="em-booking-login-form" action="<?php echo site_url('wp-login.php', 'login_post'); ?>" method="post">
            <p>
              <label><?php esc_html_e( 'Username','dbem' ) ?></label>
              <input type="text" name="log" class="input" value="" />
            </p>
            <p>
              <label><?php esc_html_e( 'Password','dbem' ) ?></label>
              <input type="password" name="pwd" class="input" value="" />
            </p>
            <?php do_action('login_form'); ?>
            <p><input name="rememberme" type="checkbox" id="em_rememberme" value="forever" /> <?php esc_html_e( 'Remember Me','dbem' ) ?> *</p>
            <input type="submit" name="wp-submit" id="em_wp-submit" value="<?php esc_html_e('Log In', 'dbem'); ?>" tabindex="100" class="wt_button small dark_green" />
            <input type="hidden" name="redirect_to" value="<?php echo esc_url($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']); ?>#em-booking" />
          </form>
        </div>
      </div>

      <div class="one_half last">
        <p>If you have forgotten your password please use our 
        <a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php esc_html_e('Password Lost and Found', 'dbem') ?>">
          Forgotten Password Form
        </a>
        to generate a new one.</p>

        <p>You may change your password at any time by loggin into your "My Account" page and choosing
          the "Change Password" option.</p>

        <p>(*) Tick the "Remember Me" feature to automatically log in next time you visit.
          This requires a browser with cookie enabled. Note that this feature increases the
          risk of unauthorised access to your personal details.
        </p>
        <?php
        //Signup Links
        /*
        if ( get_option('users_can_register') ) {
          echo "<br />";
          if ( function_exists('bp_get_signup_page') ) { //Buddypress
            $register_link = bp_get_signup_page();
          }elseif ( file_exists( ABSPATH."/wp-signup.php" ) ) { //MU + WP3
            $register_link = site_url('wp-signup.php', 'login');
          } else {
            $register_link = site_url('wp-login.php?action=register', 'login');
          }
          ?>
          <a href="<?php echo $register_link ?>"><?php esc_html_e('Sign Up','dbem') ?></a>&nbsp;&nbsp;|&nbsp;&nbsp; 
          <?php
        }
        */
        ?>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>