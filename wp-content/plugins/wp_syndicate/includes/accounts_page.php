<?php

$twitterOpts = get_option('wpsyn_options_twitter');
$facebookOpts = get_option('wpsyn_options_facebook');
$bloggerOpts = get_option('wpsyn_options_blogger');

?>
    
    <div id="account-tabs" class="tabs-wrapper">
        <ul>
            <li><a href="#account-tabs-1">Twitter</a></li>
            <li><a href="#account-tabs-2">Facebook</a></li>
            <li><a href="#account-tabs-3">Blogger</a></li>
            <li><a href="#account-tabs-4">Wordpress.com</a></li>
        </ul>
        
        <!-- TWITTER SETTINGS -->
        <div id="account-tabs-1" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert Twitter Account settings</h2>
                <?php settings_fields('wpsyn-options-twitter'); ?>
                <h3>Enable Twitter integration?</h3>
                <input type="checkbox" <?php    checked($twitterOpts['option_twitter_enabled'], 'yes'); ?> 
                       name="wpsyn_options_twitter[option_twitter_enabled]"
                       value="yes" />
                <h3>Twitter Consumer Key:</h3>
                <input type="text" name="wpsyn_options_twitter[option_twitter_key]"
                       value="<?php echo esc_attr($twitterOpts['option_twitter_key']); ?>" />
                <h3>Twitter Consumer Secret:</h3>
                <input type="text" name="wpsyn_options_twitter[option_twitter_secret]"
                       value="<?php echo esc_attr($twitterOpts['option_twitter_secret']); ?>" />
                <h3>Twitter access token:</h3>
                <input type="text" name="wpsyn_options_twitter[option_twitter_access_token]"
                       value="<?php echo esc_attr($twitterOpts['option_twitter_access_token']); ?>" />
                <h3>Twitter access token secret:</h3>
                <input type="text" name="wpsyn_options_twitter[option_twitter_access_secret]"
                       value="<?php echo esc_attr($twitterOpts['option_twitter_access_secret']); ?>" />
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="twitter-test-btn">Test Twitter configuration</button>

                <div id="twitter-test-result"></div>
            </div>
        </div> <!-- END TWITTER SETTINGS -->
        
        <!-- FACEBOOK SETTINGS -->
        <div id="account-tabs-2" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert Facebook settings</h2>
                <?php settings_fields('wpsyn-options-facebook'); ?>
                <h3>Enable Facebook integration?</h3>
                <input type="checkbox" <?php    checked($facebookOpts['option_facebook_enabled'], 'yes'); ?> 
                       name="wpsyn_options_facebook[option_facebook_enabled]"
                       value="yes" />
                <h3>Facebook App ID:</h3>
                <input type="text" name="wpsyn_options_facebook[option_facebook_app_id]"
                       value="<?php echo esc_attr($facebookOpts['option_facebook_app_id']); ?>" />
                <!-- <h3>Facebook App Secret</h3>
                <input type="text" name="wpsyn_options_facebook[option_facebook_app_secret]"
                       value="<?php echo esc_attr($facebookOpts['option_facebook_app_secret']); ?>" />
                <h3>Facebook Access Token</h3>
                <input type="text" name="wpsyn_options_facebook[option_facebook_access_token]"
                       value="<?php echo esc_attr($facebookOpts['option_facebook_access_token']); ?>" /> -->
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="facebook-test-btn">Test configuration</button>

                <div id="facebook-test-result"></div>
            </div>
        </div> <!-- END FACEBOOK SETTINGS -->
        
        <!-- BLOGGER SETTINGS -->
        <div id="account-tabs-3" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert Blogger settings</h2>
                <?php settings_fields('wpsyn-options-blogger'); ?>
                <h3>Enable Blogger integration?</h3>
                <input type="checkbox" <?php    checked($bloggerOpts['option_blogger_enabled'], 'yes'); ?> 
                       name="wpsyn_options_blogger[option_blogger_enabled]"
                       value="yes" />
                <h3>Blogger API key:</h3>
                <input type="text" name="wpsyn_options_blogger[option_blogger_api_key]"
                       value="<?php echo esc_attr($bloggerOpts['option_blogger_api_key']); ?>" />
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="mailer-test-btn">Test configuration</button>

                <div id="mailer-test-result"></div>
            </div>
        </div> <!-- BLOGSPOT SETTINGS -->
        
        <div id="account-tabs-4" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert notification settings</h2>
                <?php settings_fields('wpsyn-options-mailer'); ?>
                <h3>SMTP Server:</h3>
                <input type="text" name="wpsyn_options_mailer[option_mailer_server]"
                       value="<?php echo esc_attr($mailerOpts['option_mailer_server']); ?>" />
                <h3>Connection port:</h3>
                <input type="text" name="wpsyn_options_mailer[option_mailer_port]"
                       value="<?php echo esc_attr($mailerOpts['option_mailer_port']); ?>" />
                <h3>Username:</h3>
                <input type="text" name="wpsyn_options_mailer[option_mailer_username]"
                       value="<?php echo esc_attr($mailerOpts['option_mailer_username']); ?>" />
                <h3>Password:</h3>
                <input type="text" name="wpsyn_options_mailer[option_mailer_password]"
                       value="<?php echo esc_attr($mailerOpts['option_mailer_password']); ?>" />
                <h3>Email to send notifications:</h3>
                <input type="text" name="wpsyn_options_mailer[option_mailer_email]"
                       value="<?php echo esc_attr($mailerOpts['option_mailer_email']); ?>" />
                <h3>Enable SMTP authentication?</h3>
                <input type="radio" <?php echo ($mailerOpts['option_mailer_authentication'] == 'yes') ? 'checked' : ''; ?>
                       name="wpsyn_options_mailer[option_mailer_authentication]"
                       value="yes" /> yes
                <input type="radio" <?php echo ($mailerOpts['option_mailer_authentication'] == 'no') ? 'checked' : ''; ?>
                       name="wpsyn_options_mailer[option_mailer_authentication]"
                       value="no" /> no
                <h3>Select encryption method:</h3>
                <input type="radio" <?php echo ($mailerOpts['option_mailer_encryption'] == 'ssl') ? 'checked' : ''; ?>
                       name="wpsyn_options_mailer[option_mailer_encryption]"
                       value="ssl" /> ssl
                <input type="radio" <?php echo ($mailerOpts['option_mailer_encryption'] == 'tls') ? 'checked' : ''; ?>
                       name="wpsyn_options_mailer[option_mailer_encryption]"
                       value="tls" /> tls
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="mailer-test-btn">Test configuration</button>

                <div id="mailer-test-result"></div>
            </div>
        </div>
    </div>