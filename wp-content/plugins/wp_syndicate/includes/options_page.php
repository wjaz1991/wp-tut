<?php

$generalOpts = get_option('wpsyn_options_general');
$spinnerOpts = get_option('wpsyn_options_spinner');
$mailerOpts = get_option('wpsyn_options_mailer');

?>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">General</a></li>
            <li><a href="#tabs-2">SpinnerChief</a></li>
            <li><a href="#tabs-3">Notification</a></li>
        </ul>
        <div id="tabs-1" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert general settings</h2>
                <?php settings_fields('wpsyn-options-general'); ?>
                <h3>Minimum length of the message:</h3>
                <input type="text" name="wpsyn_options_general[option_general_min_length]"
                       value="<?php echo esc_attr($generalOpts['option_general_min_length']); ?>" />
                <h3>Maximum length of the message:</h3>
                <input type="text" name="wpsyn_options_general[option_general_max_length]"
                       value="<?php echo esc_attr($generalOpts['option_general_max_length']); ?>" />
                <h3>Anchor text for back links:</h3>
                <input type="text" name="wpsyn_options_general[option_general_anchor_text]"
                       value="<?php echo esc_attr($generalOpts['option_general_anchor_text']); ?>" />
                <br><br>
                <button type="submit">Save changes</button>
            </form>
        </div>

        <div id="tabs-2" class="tab">
            <form class="wpsyn-option-form" action="options.php" method="post">
                <h2>Insert SpinnerChief settings</h2>
                <?php settings_fields('wpsyn-options-spinner'); ?>
                <h3>SpinnerChief API key:</h3>
                <input type="text" name="wpsyn_options_spinner[option_spinner_key]"
                       value="<?php echo esc_attr($spinnerOpts['option_spinner_key']); ?>" />
                <h3>SpinnerChief account username</h3>
                <input type="text" name="wpsyn_options_spinner[option_spinner_username]"
                       value="<?php echo esc_attr($spinnerOpts['option_spinner_username']); ?>" />
                <h3>SpinnerChief account password</h3>
                <input type="text" name="wpsyn_options_spinner[option_spinner_password]"
                       value="<?php echo esc_attr($spinnerOpts['option_spinner_password']); ?>" />
                <br><br>
                <button type="submit">Save changes</button>
            </form>
            <div class="clear"></div>
            <div class="after-form">
                <input type="hidden" value="<?php echo plugin_dir_url(__FILE__) . '../images/loader.GIF'; ?>" id="load-image" >
                <button id="spinner-test-btn">Test configuration</button>

                <div id="spinner-test-result"></div>
            </div>
        </div>

        <div id="tabs-3" class="tab">
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