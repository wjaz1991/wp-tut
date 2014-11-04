<?php

require 'PHPMailer/PHPMailerAutoload.php';

wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('wj-settings-script', plugin_dir_url(__FILE__) . '../js/settings_page.js');
wp_enqueue_style('jquery-theme-style', plugin_dir_url(__FILE__) . '../css/jquery-ui/jquery-ui.css');

$options = get_option('wpsyn_options_general');

$spinnerOpts = get_option('wpsyn_options_spinner');

$mailerOpts = get_option('wpsyn_options_notify');
?>
<div id="tabs">
    <h2>General settings</h2>
	<ul>
		<li><a href="#tabs-1">General Settings</a></li>
		<li><a href="#tabs-2">SpinnerChief</a></li>
		<li><a href="#tabs-3">Notifications</a></li>
	</ul>
	<div id="tabs-1" class="wrap">
		<form action="options.php" method="post">
			<?php settings_fields('wpsyn-option-general'); ?>
			<h3>Minimal length of the syndicated message:</h3>
			<input type="text" name="wpsyn_options_general[option_min_length]"
				value="<?php echo esc_attr($options['option_min_length']); ?>" />
                        <h3>Maximal length of the syndicated message:</h3>
			<input type="text" name="wpsyn_options_general[option_max_length]"
				value="<?php echo esc_attr($options['option_max_length']); ?>" />
                        <h3>Text for links to your article:</h3>
			<input type="text" name="wpsyn_options_general[option_link_text]"
				value="<?php echo esc_attr($options['option_link_text']); ?>" />
			<br><br>
			<button type="submit">Save changes</button>
		</form>
	</div>

	<div id="tabs-2">
		<form action="options.php" method="post">
			<?php settings_fields('wpsyn-option-spinner'); ?>
			<h3>SpinnerChief API Key:</h3>
			<input type="text" name="wpsyn_options_spinner[option_spinner_key]"
				value="<?php echo esc_attr($spinnerOpts['option_spinner_key']); ?>" />
                        <h3>SpinnerChief API Secret:</h3>
			<input type="text" name="wpsyn_options_spinner[option_spinner_secret]"
				value="<?php echo esc_attr($spinnerOpts['option_spinner_secret']); ?>" />
			<br><br>
			<button type="submit">Save changes</button>
		</form>
	</div>
    
	<div id="tabs-3">
		<form action="options.php" method="post">
			<?php settings_fields('wpsyn-option-notify'); ?>
			<h3>Set main server:</h3>
			<input type="text" name="wpsyn_options_notify[option_mailer_server]"
				value="<?php echo esc_attr($mailerOpts['option_mailer_server']); ?>" />
                        <h3>Set username:</h3>
			<input type="text" name="wpsyn_options_notify[option_mailer_user]"
				value="<?php echo esc_attr($mailerOpts['option_mailer_user']); ?>" />
                        <h3>Set password:</h3>
			<input type="text" name="wpsyn_options_notify[option_mailer_password]"
				value="<?php echo esc_attr($mailerOpts['option_mailer_password']); ?>" />
			<button type="submit">Save changes</button>
		</form>
            
            <br>
            <button id="test-email">Test connection</button>
            
            <div id="mailer-test-result"></div>
	</div>
</div>

<?php
//sending test mail
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'wjaz1991@gmail.com';
$mail->Password = 'str@t0c@st3r';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->From = 'wp@local.com';
$mail->FromName = 'Wordpress';
$mail->addAddress('wjaz1991@gmail.com');
$mail->WordWrap = 50; 
$mail->isHTML(true);

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

/*if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}*/




