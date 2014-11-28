<?php

/*
 * AJAX CALLBACK FUNCTIONS TO TEST CONNECTIONS TO VARIOUS APIs
 */

use Codebird\Codebird;

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

function test_blogger_action() {
    $nonce = $_POST['nonce'];
    
    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }
    
    if(current_user_can('manage_options')) {
        $json = array();
        
        //testing blogger api
        $bloggerOpts = get_option('wpsyn_options_blogger');
        $url = 'https://www.googleapis.com/blogger/v3/blogs/' . $bloggerOpts['option_blogger_blog_id'] . '?key=' . $bloggerOpts['option_blogger_api_key'];

        //making a curl request
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($request);

        $resultJson = json_decode($result, true);
        
        if(isset($resultJson['id']) && strlen($resultJson['id'])>0) {
            $json['success'] = true;
            $json['id'] = $resultJson['id'];
        } else {
            $json['error'] = true;
        }
        
        echo json_encode($json);
    }
    
    die();
}

function test_wordpress_action() {
    $nonce = $_POST['nonce'];
    
    if(!wp_verify_nonce($nonce, 'wpsyn-ajax-nonce')) {
        die();
    }
    
    $json = array();
    
    if(current_user_can('manage_options')) {
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
        }
        
        if(isset($access_key) && strlen($access_key) > 0) {
            $json['success'] = true;
        } else {
            $json['error'] = true;
        }
        
        echo json_encode($json);
    }
    
    die();
}

