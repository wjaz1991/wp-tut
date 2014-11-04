<?php
/*
Plugin Name: WJ Syndicate
Plugin URI: http://wjaz.pl
Description: Plugin for post syndication to Facebook, Twitter, Google Blogspot, and Wordpress.com
Version: 1.0
Author: Wojciech Jazgara
Author URI: http://wjaz.pl
License: GPLv2
*/

//ajax testing mailer
add_action('admin_footer', 'test_mailer_javascript');

add_action('wp_ajax_my_action', 'my_action_callback');
add_action('wp_ajax_nopriv_my_action', 'my_action_callback');

function my_action_callback() {
    //$test = get_option('wpsyn_options_notify');
    //$text = print_r($test, true);
    
    //echo $text;
    echo 'works';
    
    die();
}


function test_mailer_javascript() {
    ?>
    <script>
        jQuery(document).ready(function($) {
           $("#test-email").on('click', function() {
               var data = {
                   action: 'my_action'
               };
               
               $.post(ajaxurl, data, function(msg) {
                   $('#mailer-test-result').append(msg);
               });
           });
        });
    </script>
    <?php
}
//-------------------------
//PLUGIN ACTIVATION
//-------------------------
register_activation_hook(__FILE__, 'wj_syndicate_install');

function wj_syndicate_install() {
	global $wp_version;

	//checking whether WP version is compatible with plugin
	if(version_compare($wp_version, '4.0', '<')) {
		wp_die('This plugin requires Wordpress version 4.0 or higher.');
	}
}

//-------------------------
//PLUGIN DEACTIVATION
//-------------------------
register_deactivation_hook(__FILE__, 'wj_sydicate_deactivate');

function wj_sydicate_deactivate() {

}

//CHANGING POST TITLES
add_filter('the_title', 'wj_custom_title');

function wj_custom_title($title) {
	$title .= ' - By Wojtek Jazgara';

	return $title;
}

//CHANGING POST CONTENT
add_filter('the_content', 'wj_content_footer');

function wj_content_footer($content) {
	$content .= '<br><h3>Liked the article?</h3><p>Go to <a href="http://wjaz.pl">wjaz.pl</a> for more!</p><br>';

	return $content;
}

//ADDING SOME CUSTOM CSS
add_action('wp_head', 'wj_head_style');

function wj_head_style() {
	?>
	<style>
		h1.entry-title a {
			font-weight: bold;
		}

		h1.entry-title a:hover {
			text-decoration: underline;
		}
	</style>
	<?php
}

//CREATING PLUGIN SETTINGS MENU
add_action('admin_menu', 'wj_add_admin_menu');

function wj_add_admin_menu() {
	//adding top level menu
	add_menu_page('WJ Sydicate Plugin Page', 'WP Syndicate', 'manage_options', 'wj_main_menu',
		'wj_syndicate_options_page');
        
        //adding submenu pages
        add_submenu_page('wj_main_menu', 'WP Sydicate General Settings', 'Settings', 'manage_options', 'wj_menu_general', 'wj_menu_general_page');
        add_submenu_page('wj_main_menu', 'WP Syndicate Account Settings', 'Account', 'manage_options', 'wj_menu_account', 'wj_menu_account_page');
        add_submenu_page('wj_main_menu', 'WP Syndicate Reporting Settings', 'Reporting', 'manage_options', 'wj_menu_reporting', 'wj_menu_reporting_page');
	
        //register settings
	add_action('admin_init', 'wj_register_settings');
}

function wj_register_settings() {
	register_setting('wpsyn-option-general', 'wpsyn_options_general', 'wj_sanitize_options_general');
        register_setting('wpsyn-option-spinner', 'wpsyn_options_spinner', 'wj_sanitize_options_spinner');
        register_setting('wpsyn-option-notify', 'wpsyn_options_notify', 'wj_sanitize_options_notify');
}

//Plugin option page
function wj_syndicate_options_page() {
}

//general settings page
function wj_menu_general_page() {
    include plugin_dir_path(__FILE__) . 'includes/general_settings.php';
}

function wj_sanitize_options_general($input) {
	$input['option_min_length'] = intval($input['option_min_length']);
        $input['option_max_length'] = intval($input['option_max_length']);
        $input['option_link_text'] = sanitize_text_field($input['option_link_text']);

	return $input;
}

function wj_sanitize_options_spinner($input) {
	$input['option_spinner_secret'] = sanitize_text_field($input['option_spinner_secret']);
        $input['option_spinner_key'] = sanitize_text_field($input['option_spinner_key']);

	return $input;
}

function wj_sanitize_options_notify($input) {
	$input['option_mailer_server'] = sanitize_text_field($input['option_mailer_server']);
        $input['option_mailer_user'] = sanitize_text_field($input['option_mailer_user']);
        $input['option_mailer_password'] = sanitize_text_field($input['option_mailer_password']);

	return $input;
}