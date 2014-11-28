<?php

$twitterOpts = get_option('wpsyn_options_twitter');
$facebookOpts = get_option('wpsyn_options_facebook');
$bloggerOpts = get_option('wpsyn_options_blogger');
$wordpressOpts = get_option('wpsyn_options_wordpress');

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
                <h3>Blogger blog ID:</h3>
                <input type="text" name="wpsyn_options_blogger[option_blogger_blog_id]"
                       value="<?php echo esc_attr($bloggerOpts['option_blogger_blog_id']); ?>" />
                <h3>Blogger client ID:</h3>
                <input type="text" name="wpsyn_options_blogger[option_blogger_client_id]"
                       value="<?php echo esc_attr($bloggerOpts['option_blogger_client_id']); ?>" />
                <h3>Blogger client secret:</h3>
                <input type="text" name="wpsyn_options_blogger[option_blogger_client_secret]"
                       value="<?php echo esc_attr($bloggerOpts['option_blogger_client_secret']); ?>" />
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="blogger-test-btn">Test configuration</button>

                <div id="blogger-test-result"></div>
            </div>
        </div> <!-- BLOGGER SETTINGS -->
        
        <!-- WORDPRESS.COM SETTINGS -->
        <div id="account-tabs-4" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert Wordpress.com settings</h2>
                <?php settings_fields('wpsyn-options-wordpress'); ?>
                <h3>Enable Wordpress.com integration?</h3>
                <input type="checkbox" <?php    checked($wordpressOpts['option_wordpress_enabled'], 'yes'); ?> 
                       name="wpsyn_options_wordpress[option_wordpress_enabled]"
                       value="yes" />
                <h3>Client ID:</h3>
                <input type="text" name="wpsyn_options_wordpress[option_wordpress_client_id]"
                       value="<?php echo esc_attr($wordpressOpts['option_wordpress_client_id']); ?>" />
                <h3>Client Secret:</h3>
                <input type="text" name="wpsyn_options_wordpress[option_wordpress_client_secret]"
                       value="<?php echo esc_attr($wordpressOpts['option_wordpress_client_secret']); ?>" />
                <h3>Wordpress.com blog ID:</h3>
                <input type="text" name="wpsyn_options_wordpress[option_wordpress_blog_id]"
                       value="<?php echo esc_attr($wordpressOpts['option_wordpress_blog_id']); ?>"/>
                <h3>Wordpress.com username:</h3>
                <input type="text" name="wpsyn_options_wordpress[option_wordpress_username]"
                       value="<?php echo esc_attr($wordpressOpts['option_wordpress_username']); ?>"/>
                <h3>Wordpress.com password:</h3>
                <input type="text" name="wpsyn_options_wordpress[option_wordpress_password]"
                       value="<?php echo esc_attr($wordpressOpts['option_wordpress_password']); ?>"/>
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="wordpress-test-btn">Test configuration</button>

                <div id="wordpress-test-result"></div>
            </div>
        </div>
    </div>