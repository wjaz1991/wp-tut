<?php
/*
Plugin Name: WPSyn
Plugin URI: http://wjaz.pl
Description: Plugin for post syndication to Facebook, Twitter, Google Blogspot, and Wordpress.com
Version: 1.0
Author: Wojciech Jazgara
Author URI: http://wjaz.pl
License: GPLv2
*/

require plugin_dir_path(__FILE__) . 'includes/PHPMailer/PHPMailerAutoload.php';
require_once(plugin_dir_path(__FILE__) . 'includes/codebird/src/codebird.php');
require_once(plugin_dir_path(__FILE__) . 'includes/facebook-php-sdk-v4-4.0/autoload.php');
require_once(plugin_dir_path(__FILE__) . 'includes/google-api-php-client-master/autoload.php');

use Codebird\Codebird;
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;


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
    
    //testing blogger api
    $bloggerOpts = get_option('wpsyn_options_blogger');
    $googleClient = new Google_Client();
    $googleClient->addScope("https://www.googleapis.com/auth/blogger");
    //$googleClient->setApplicationName('WPSyn');
    $googleClient->setDeveloperKey($bloggerOpts['option_blogger_api_key']);
    
    $blogger = new Google_Service_Blogger($googleClient);
    
    //$blogPosts = $blogger->getPosts();
    
    //var_dump($blogger);

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

    return $input;
}

/*----------------------------------
AJAX CALLBACKS
----------------------------------*/
add_action('wp_ajax_test_mailer', 'test_mailer_action');
add_action('wp_ajax_test_spinner', 'test_spinner_action');
add_action('wp_ajax_test_twitter', 'test_twitter_action');
add_action('wp_ajax_test_facebook', 'test_facebook_action');

function test_mailer_action() {
    $nonce = $_POST['nonce'];

    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }

    if(current_user_can('manage_options')) {
        $mailer = new PHPMailer;

        $mailerOpts = get_option('wpsyn_options_mailer');

        $mailer->isSMTP();

        //enable SMTP authentication
        if($mailerOpts['option_mailer_authentication'] == 'yes') {
            $mailer->SMTPAuth = true;
        }

        //setting encryption
        $mailer->SMTPSecure = $mailerOpts['option_mailer_encryption'];

        $mailer->Host = $mailerOpts['option_mailer_server'];
        $mailer->Username = $mailerOpts['option_mailer_username'];
        $mailer->Password = $mailerOpts['option_mailer_password'];
        $mailer->Port = $mailerOpts['option_mailer_port'];

        $mailer->addAddress($mailerOpts['option_mailer_email']);
        $mailer->WordWrap = 50;
        $mailer->isHTML(true);

        $mailer->Subject = 'WPSyn syndication';
        $mailer->Body    = 'This is a test message from <b>WPSyn</b> Wordpress plugin';
        $mailer->AltBody = 'This is a test message from WPSyn Wordpress plugin';

        $json = array();
        if(!$mailer->send()) {
            $json['error'] = true;
            $json['message'] = $mailer->ErrorInfo;
        } else {
            $json['success'] = true;
        }

        echo json_encode($json);

        die();
    }

    die();
}

function test_spinner_action() {
    $nonce = $_POST['nonce'];

    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }

    if(current_user_can('manage_options')) {
        $spinnerOpts = get_option('wpsyn_options_spinner');

        $post = 'Real Madrid is the best team in the world at the moment. They play beautiful and effective football.';

        $requestUrl = 'http://api.spinnerchief.com:443/apikey=' . $spinnerOpts['option_spinner_key'] .
            '&username=' . $spinnerOpts['option_spinner_username'] .
            '&password=' . $spinnerOpts['option_spinner_password'] .
            '&spintype=1&spinfreq=2&Orderly=1';

        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $requestUrl);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($request);

        $test = substr($result, 0, 6);

        $json = array();
        if ($test != 'error=') {
            $json['success'] = true;
            $json['message'] = $result;
        } else {
            $json['error'] = true;
            $json['message'] = substr($result, 6);
        }

        echo json_encode($json);
    }

    die();
}

function test_twitter_action() {
    $nonce = $_POST['nonce'];
    
    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }
    
    if(current_user_can('manage_options')) {
        $twitterOpts = get_option('wpsyn_options_twitter');

        Codebird::setConsumerKey($twitterOpts['option_twitter_key'], $twitterOpts['option_twitter_secret']);

        $cb = Codebird::getInstance();

        $cb->setToken($twitterOpts['option_twitter_access_token'], $twitterOpts['option_twitter_access_secret']);

        $reply = $cb->account_verifyCredentials();

        $json = array();
        if(!isset($reply->id)) {
            $json['error'] = true;
        } else {
            $json['success'] = true;
            $json['id'] = $reply->id;
        }
        
        echo json_encode($json);
    }
    
    die();
}

function test_facebook_action() {
    $nonce = $_POST['nonce'];
    
    $facebookOpts = get_option('wpsyn_options_facebook');
    
    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }
    
    if(current_user_can('manage_options')) {
        FacebookSession::setDefaultApplication($facebookOpts['option_facebook_app_id'], $facebookOpts['option_facebook_app_secret']);
        $session = new FacebookSession($facebookOpts['option_facebook_access_token']);
        
        try {
            $me = (new FacebookRequest(
              $session, 'GET', '/me'
            ))->execute()->getGraphObject(GraphUser::className());
            echo $me->getName();
          } catch (FacebookRequestException $e) {
            var_dump($e);
          } catch (\Exception $e) {
            var_dump($e);
          }
        /*$json = array();
        $json['success'] = true;
        
        echo json_encode($json);*/
    }
    
    die();
}