<?php
/*
Plugin Name: WPSyn
Plugin URI: http://polcode.pl
Description: Plugin for post syndication to Facebook, Twitter, Google Blogspot, and Wordpress.com
Version: 1.0
Author: Wojciech Jazgara
Author URI: http://polcode.pl
License: GPLv2
*/

require plugin_dir_path(__FILE__) . 'includes/PHPMailer/PHPMailerAutoload.php';
require_once(plugin_dir_path(__FILE__) . 'includes/codebird/src/codebird.php');
require_once(plugin_dir_path(__FILE__) . 'includes/google-api-php-client-master/autoload.php');

use Codebird\Codebird;


//-------------------------
//PLUGIN ACTIVATION
//-------------------------
register_activation_hook(__FILE__, 'wpsyn_install');

function wpsyn_install() {
	global $wp_version;

	//checking whether WP version is compatible with plugin
	if(version_compare($wp_version, '4.0', '<')) {
		wp_die('This plugin requires Wordpress version 4.0 or higher.');
	}
        
        wpsyn_create_table();
}

//function to create database table
function wpsyn_create_table() {
    global $wpdb;
    
    $tableName = $wpdb->prefix . 'wpsyn';
    
    $charsetCollate = '';
    
    if(!empty($wpdb->charset)) {
        $charsetCollate = 'DEFAULT CHARACTER SET ' . $wpdb->charset;
    }
    
    if(!empty($wpdb->collate)) {
        $charsetCollate .= ' COLLATE ' . $wpdb->collate;
    }
    
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id int(10) unsigned NOT NULL AUTO_INCREMENT,
            link text NOT NULL,
            published datetime NOT NULL,
            PRIMARY KEY id (id)
          ) ENGINE=InnoDB $charsetCollate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

//-------------------------
//PLUGIN DEACTIVATION
//-------------------------
register_deactivation_hook(__FILE__, 'wpsyn_deactivate');

function wpsyn_deactivate() {

}

//CREATING PLUGIN SETTINGS MENU
add_action('admin_menu', 'wpsyn_add_admin_menu');

function wpsyn_add_admin_menu() {
	//adding top level menu
	add_menu_page('WP Sydicate Plugin Page', 'WP Syndicate', 'manage_options', 'wpsyn_main_menu',
		'wpsyn_options_page');
        
        add_submenu_page('wpsyn_main_menu', 'WPSyn General Settings', 'Settings', 'manage_options', 'wpsyn_main_menu', 'wpsyn_page_settings');
        add_submenu_page('wpsyn_main_menu', 'WPSyn Accounts Settings', 'Accounts', 'manage_options', 'wpsyn_menu_accounts', 'wpsyn_page_accounts');
        add_submenu_page('wpsyn_main_menu', 'WPSyn Reporting Settings', 'Reporting', 'manage_options', 'wpsyn_menu_reporting', 'wpsyn_page_reporting');

	//register settings
	add_action('admin_init', 'wpsyn_register_settings');
}

//REGISTERING PLUGIN SETTINGS
function wpsyn_register_settings() {
    register_setting('wpsyn-options-general', 'wpsyn_options_general', 'wpsyn_sanitize_general');
    register_setting('wpsyn-options-spinner', 'wpsyn_options_spinner', 'wpsyn_sanitize_spinner');
    register_setting('wpsyn-options-mailer', 'wpsyn_options_mailer', 'wpsyn_sanitize_mailer');
    register_setting('wpsyn-options-twitter', 'wpsyn_options_twitter', 'wpsyn_sanitize_twitter');
    register_setting('wpsyn-options-facebook', 'wpsyn_options_facebook', 'wpsyn_sanitize_facebook');
    register_setting('wpsyn-options-blogger', 'wpsyn_options_blogger', 'wpsyn_sanitize_blogger');
    register_setting('wpsyn-options-wordpress', 'wpsyn_options_wordpress', 'wpsyn_sanitize_wordpress');
}

//PLUGIN OPTIONS PAGE
function wpsyn_options_page() {
}

//PLUGIN GENERAL SETTINGS PAGE
function wpsyn_page_settings() {
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('wp-settings-script', plugin_dir_url(__FILE__) . 'js/settings_page.js', array('jquery'));

    wp_localize_script('wp-settings-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('wpsyn-ajax-nonce'),
    ));

    wp_enqueue_style('jquery-theme-style', plugin_dir_url(__FILE__) . 'css/jquery-ui/jquery-ui.css');
    wp_enqueue_style('plugin-style', plugin_dir_url(__FILE__) . 'css/style.css');
    
    //PUBLISHING ON BLOGGER.COM
    /*$bloggerOpts = get_option('wpsyn_options_blogger');
    
    $scope = 'blogger.posts.insert';
    $redirect = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $state = 'some state';
    $access_type = 'online';
    
    $url = "https://accounts.google.com/o/oauth2/auth?
            scope=" . $scope . "&
            state=" . $state . "&
            redirect_uri=" . $redirect . "&
            response_type=code&
            client_id=" . $bloggerOpts['option_blogger_client_id'] . "&
            approval_prompt=auto&response_type=code";
    
    var_dump($url);
    
    $req = curl_init();
    
    curl_setopt($req, CURLOPT_URL, $url);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    
    $result = curl_exec($req);
    
    var_dump($result);*/
    
    $fbOpts = get_option('wpsyn_options_facebook');
    
    ?>
<script>
    jQuery(document).ready(function($) {
    var status = '';
    
    window.fbAsyncInit = function() {
        FB.init({
            appId      : <?php echo $fbOpts['option_facebook_app_id']; ?>,
            xfbml      : true,
            version    : 'v2.1'
        });
        
        alert('after init');
        
        (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        //});
    }
    
    //jQuery(document).ready(function($) {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    alert('logged');
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;

                    var data = {
                        'caption': 'Some title',
                        'message': 'Some message',
                        'link': 'Some link'
                    };
                    
                    var body = 'Reading JS SDK documentation';
                    FB.api('/me/feed', 'post', { message: body }, function(response) {
                      if (!response || response.error) {
                        alert('Error occured');
                      } else {
                        alert('Post ID: ' + response.id);
                      }
                    });

                    /*FB.api('/me/feed', 'post', data, function() {});
                    status = 'connected';*/
                } else {
                    alert('not logged');
                    FB.login(function(){
                        var data = {
                            'caption': 'Some title',
                            'message': 'Some message',
                            'link': 'Some link'
                        };
                        
                        var body = 'Reading JS SDK documentation';
                        FB.api('/me/feed', 'post', { message: body }, function(response) {
                          if (!response || response.error) {
                            alert('Error occured');
                          } else {
                            alert('Post ID: ' + response.id);
                          }
                        });

                        //FB.api('/me/feed', 'post', data, function() {});
                    }, {scope: 'public_profile, publish_stream'});
                }
            });
    });
</script>
<?php
    
    //including page for options management
    include(plugin_dir_path(__FILE__) . 'includes/settings_page.php');
}

//PLUGIN ACCOUNT SETTING PAGE
function wpsyn_page_accounts() {
    $facebookOpts = get_option('wpsyn_options_facebook');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('wp-settings-script', plugin_dir_url(__FILE__) . 'js/settings_page.js', array('jquery'));
    wp_enqueue_script('wp-facebook-script', plugin_dir_url(__FILE__) . 'js/facebook_test.js', array('jquery'));
        
    wp_localize_script('wp-facebook-script', 'facebook_data', array(
        'app_id' => $facebookOpts['option_facebook_app_id'],
    ));

    wp_localize_script('wp-settings-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('wpsyn-ajax-nonce'),
    ));

    wp_enqueue_style('jquery-theme-style', plugin_dir_url(__FILE__) . 'css/jquery-ui/jquery-ui.css');
    wp_enqueue_style('plugin-style', plugin_dir_url(__FILE__) . 'css/style.css');
    
    //including page for options management
    include(plugin_dir_path(__FILE__) . 'includes/accounts_page.php');
}


/*----------------------------------
SANITIZING FUNCTIONS
----------------------------------*/
function wpsyn_sanitize_general($input) {
	$input['option_general_min_length'] = intval($input['option_general_min_length']);
    $input['option_general_max_length'] = intval($input['option_general_max_length']);
    $input['option_anchor_text'] = sanitize_text_field($input['option_anchor_text']);

	return $input;
}

function wpsyn_sanitize_spinner($input) {
    $input['option_spinner_key'] = sanitize_text_field($input['option_spinner_key']);
    $input['option_spinner_username'] = sanitize_text_field($input['option_spinner_username']);
    $input['option_spinner_password'] = sanitize_text_field($input['option_spinner_password']);

    return $input;
}

function wpsyn_sanitize_mailer($input) {
    $input['option_mailer_server'] = sanitize_text_field($input['option_mailer_server']);
    $input['option_mailer_port'] = intval($input['option_mailer_port']);
    $input['option_mailer_username'] = sanitize_text_field($input['option_mailer_username']);
    $input['option_mailer_password'] = sanitize_text_field($input['option_mailer_password']);
    $input['option_mailer_authentication'] = sanitize_text_field($input['option_mailer_authentication']);
    $input['option_mailer_encryption'] = sanitize_text_field($input['option_mailer_encryption']);
    $input['option_mailer_email'] = sanitize_email($input['option_mailer_email']);

    return $input;
}

function wpsyn_sanitize_twitter($input) {
    $input['option_twitter_enabled'] = ($input['option_twitter_enabled'] == "yes") ? "yes" : "";
    $input['option_twitter_key'] = sanitize_text_field($input['option_twitter_key']);
    $input['option_twitter_secret'] = sanitize_text_field($input['option_twitter_secret']);
    $input['option_twitter_access_token'] = sanitize_text_field($input['option_twitter_access_token']);
    $input['option_twitter_access_secret'] = sanitize_text_field($input['option_twitter_access_secret']);

    return $input;
}

function wpsyn_sanitize_facebook($input) {
    $input['option_facebook_enabled'] = ($input['option_facebook_enabled'] == "yes") ? "yes" : "";
    $input['option_facebook_app_id'] = sanitize_text_field($input['option_facebook_app_id']);
    $input['option_facebook_app_secret'] = sanitize_text_field($input['option_facebook_app_secret']);
    $input['option_facebook_access_token'] = sanitize_text_field($input['option_facebook_access_token']);

    return $input;
}

function wpsyn_sanitize_blogger($input) {
    $input['option_blogger_enabled'] = ($input['option_blogger_enabled'] == "yes") ? "yes" : "";
    $input['option_blogger_api_key'] = sanitize_text_field($input['option_blogger_api_key']);
    $input['option_blogger_blog_id'] = sanitize_text_field($input['option_blogger_blog_id']);
    $input['option_blogger_client_id'] = sanitize_text_field($input['option_blogger_client_id']);
    $input['option_blogger_client_secret'] = sanitize_text_field($input['option_blogger_client_secret']);

    return $input;
}

function wpsyn_sanitize_wordpress($input) {
    $input['option_wordpress_enabled'] = ($input['option_wordpress_enabled'] == "yes") ? "yes" : "";
    $input['option_wordpress_client_id'] = sanitize_text_field($input['option_wordpress_client_id']);
    $input['option_wordpress_client_secret'] = sanitize_text_field($input['option_wordpress_client_secret']);
    $input['option_wordpress_username'] = sanitize_text_field($input['option_wordpress_username']);
    $input['option_wordpress_password'] = sanitize_text_field($input['option_wordpress_password']);
    $input['option_wordpress_blog_id'] = sanitize_text_field($input['option_wordpress_blog_id']);

    return $input;
}

/*----------------------------------
AJAX CALLBACKS
----------------------------------*/
add_action('wp_ajax_test_mailer', 'test_mailer_action');
add_action('wp_ajax_test_spinner', 'test_spinner_action');
add_action('wp_ajax_test_twitter', 'test_twitter_action');
add_action('wp_ajax_test_facebook', 'test_facebook_action');
add_action('wp_ajax_test_blogger', 'test_blogger_action');
add_action('wp_ajax_test_wordpress', 'test_wordpress_action');

include( plugin_dir_path(__FILE__) . 'includes/test_functions.php');


//---------------------------------------
//SENDING POST TO THE ADDED ACCOUNTS
//---------------------------------------
add_action('publish_post', 'wpsyn_send_to_socials', 10, 2);

function wpsyn_send_to_socials($ID, $post) {
    $content = $post->post_content;
    $title = $post->post_title;
    
    $postTitle = $post->post_title;
    
    //PUBLISHING ON TWITTER
    if(strlen($title) > 140) {
        $title = substr($title, 0, 140);
    }
    
    $title .= " " . get_permalink($post->id);
    
    $twitterOpts = get_option('wpsyn_options_twitter');

    Codebird::setConsumerKey($twitterOpts['option_twitter_key'], $twitterOpts['option_twitter_secret']);

    $cb = Codebird::getInstance();

    $cb->setToken($twitterOpts['option_twitter_access_token'], $twitterOpts['option_twitter_access_secret']);

    $reply = $cb->statuses_update('status=' . $title);
    
    //PUBLISHING ON WORDPRESS.COM BLOG
    $wpOpts = get_option('wpsyn_options_wordpress');

    $curl = curl_init('https://public-api.wordpress.com/oauth2/token');
    curl_setopt( $curl, CURLOPT_POST, true );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
        'client_id' => $wpOpts['option_wordpress_client_id'],
        'client_secret' => $wpOpts['option_wordpress_client_secret'],
        'grant_type' => 'password',
        'username' => $wpOpts['option_wordpress_username'],
        'password' => $wpOpts['option_wordpress_password']
    ) );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
    $auth = curl_exec( $curl );
    $auth = json_decode($auth);
    if(isset($auth->access_token)) {
        $access_key = $auth->access_token;
    
        $options  = array (
            'http' => 
            array (
              'ignore_errors' => true,
              'method' => 'POST',
              'header' => 
              array (
                0 => 'authorization: Bearer ' . $access_key,
                1 => 'Content-Type: application/x-www-form-urlencoded',
              ),
              'content' => http_build_query(   
                array (
                  'title' => $post->post_title,
                  'content' => $post->post_content,
                  'tags' => 'wordpress.dev.com, from main',
                  'categories' => 'Main Blog',
                )
              ),
            ),
          );

          $context  = stream_context_create( $options );
          $response = file_get_contents(
            'https://public-api.wordpress.com/rest/v1/sites/' . $wpOpts['option_wordpress_blog_id'] . '/posts/new/',
            false,
            $context
          );
          $response = json_decode( $response );
    }
    
    //PUBLISHING ON BLOGGER.COM
    $bloggerOpts = get_option('wpsyn_options_blogger');
    
    $client = new Google_Client();
    $client->setApplicationName("WPSyn");
    $client->setDeveloperKey($bloggerOpts['option_blogger_api_key']);
    
    $blogger = new Google_Service_Blogger($client);
    
}