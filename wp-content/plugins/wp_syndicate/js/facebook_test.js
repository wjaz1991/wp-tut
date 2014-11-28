jQuery(document).ready(function($) {
    
    var status = '';
    
    window.fbAsyncInit = function() {
        FB.init({
            appId      : facebook_data.app_id,
            xfbml      : true,
            version    : 'v2.1'
        });
        
        FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    // the user is logged in and has authenticated your
    // app, and response.authResponse supplies
    // the user's ID, a valid access token, a signed
    // request, and the time the access token 
    // and signed request each expire
    var uid = response.authResponse.userID;
    var accessToken = response.authResponse.accessToken;
    status = 'connected';
  } else if (response.status === 'not_authorized') {
    // the user is logged in to Facebook, 
    // but has not authenticated your app
    status = 'not_authorized';
  } else {
    // the user isn't logged in to Facebook.
    status = 'not logged';
  }
 });
 
 
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
       
    $('#facebook-test-btn').click(function() {
        $("#facebook-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#facebook-test-result").append(image);
        
        if(status == 'connected') {
            FB.api('/me', {fields: 'last_name'}, function(response) {
                $('#facebook-test-result').find('#mailer-loading').remove();
                $("#facebook-test-result").empty();

                if(!response.last_name) {
                    $("#facebook-test-result").addClass('error');
                    var text = '<h4> Facebook configuration test failed </h4><p>Check your configuration, and try again.</p>';
                    $("#facebook-test-result").append(text);
                } else {
                    $("#facebook-test-result").addClass('updated');
                    var text = '<h4> Facebook configuration test passed and is ready to use</h4>';
                    $("#facebook-test-result").append(text);
                }
            });
        } else {
            FB.login(function(){
                FB.api('/me', {fields: 'last_name'}, function(response) {
                    $('#facebook-test-result').find('#mailer-loading').remove();
                    $("#facebook-test-result").empty();

                    if(!response.last_name) {
                        $("#facebook-test-result").addClass('error');
                        var text = '<h4> Facebook configuration test failed </h4><p>Check your configuration, and try again.</p>';
                        $("#facebook-test-result").append(text);
                    } else {
                        $("#facebook-test-result").addClass('updated');
                        var text = '<h4> Facebook configuration test passed and is ready to use</h4>';
                        $("#facebook-test-result").append(text);
                    }
                });
            }, {scope: 'public_profile'});
        }
    });
});