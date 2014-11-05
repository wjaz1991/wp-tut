jQuery(document).ready(function($) {
    $("#tabs").tabs();
    $("#account-tabs").tabs();

    $('#dialog_link, ul#icons li').hover(function() {
        $(this).addClass('ui-state-hover');
    }, function() {
        $(this).removeClass('ui-state-hover');
    });

    //-------------------------
    //MAILER TEST
    //-------------------------
    $("#mailer-test-btn").on('click', function() {
        $("#mailer-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#mailer-test-result").append(image);
        var data = {
            'action': 'test_mailer',
            'nonce': ajax_object.ajax_nonce
        };

        var request = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: 'post',
            dataType: 'json'
        });

        request.done(function(msg) {
            $('#mailer-test-result').find('#mailer-loading').remove();
            $("#mailer-test-result").empty();

            if(msg.error) {
                $("#mailer-test-result").addClass('error');
                var text = '<h4> Mailer configuration test failed </h4><p>Check your configuration, and try again.</p>' +
                    '<p>More details: ' + msg.message + '</p>';
                $("#mailer-test-result").append(text);
            }
            if(msg.success) {
                $("#mailer-test-result").addClass('updated');
                var text = '<h4> Mailer configuration test passed </h4><p>Check provided email account for the sent message</p>';
                $("#mailer-test-result").append(text);
            }
        });
    });
    //-------------------------

    //-------------------------
    //SPINNER CHIEF TEST
    //-------------------------
    $("#spinner-test-btn").on('click', function() {
        $("#spinner-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#spinner-test-result").append(image);
        var data = {
            'action': 'test_spinner',
            'nonce': ajax_object.ajax_nonce
        };

        var request = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: 'post',
            dataType: 'json'
        });

        request.done(function(msg) {
            $('#spinner-test-result').find('#mailer-loading').remove();
            $("#spinner-test-result").empty();

            if(msg.error) {
                $("#spinner-test-result").addClass('error');
                var text = '<h4> SpinnerChief configuration test failed </h4><p>Check your configuration, and try again.</p>' +
                    '<p>More details: ' + msg.message + '</p>';
                $("#spinner-test-result").append(text);
            }
            if(msg.success) {
                $("#spinner-test-result").addClass('updated');
                var text = '<h4> SpinnerChief configuration test passed and is ready to use</h4><p>More details: ' + msg.message + '</p>';;
                $("#spinner-test-result").append(text);
            }
        });
    });
    //-------------------------
    
    //-------------------------
    //TWITTER TEST
    //-------------------------
    $("#twitter-test-btn").on('click', function() {
        $("#twitter-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#twitter-test-result").append(image);
        var data = {
            'action': 'test_twitter',
            'nonce': ajax_object.ajax_nonce
        };

        var request = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: 'post',
            dataType: 'json'
        });

        request.done(function(msg) {
            $('#twitter-test-result').find('#mailer-loading').remove();
            $("#twitter-test-result").empty();

            if(msg.error) {
                $("#twitter-test-result").addClass('error');
                var text = '<h4> Twitter configuration test failed </h4><p>Check your configuration, and try again.</p>';
                $("#twitter-test-result").append(text);
            }
            if(msg.success) {
                $("#twitter-test-result").addClass('updated');
                var text = '<h4> Twitter configuration test passed and is ready to use</h4>';
                $("#twitter-test-result").append(text);
            }
        });
    });
    //-------------------------
    
    //-------------------------
    //WORDPRESS.COM TEST
    //-------------------------
    $("#wordpress-test-btn").on('click', function() {
        $("#wordpress-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#wordpress-test-result").append(image);
        var data = {
            'action': 'test_wordpress',
            'nonce': ajax_object.ajax_nonce
        };

        var request = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: 'post',
            dataType: 'json'
        });

        request.done(function(msg) {
            $('#wordpress-test-result').find('#mailer-loading').remove();
            $("#wordpress-test-result").empty();

            if(msg.error) {
                $("#wordpress-test-result").addClass('error');
                var text = '<h4> Wordpress.com configuration test failed </h4><p>Check your configuration, and try again.</p>';
                $("#wordpress-test-result").append(text);
            }
            if(msg.success) {
                $("#wordpress-test-result").addClass('updated');
                var text = '<h4> Wordpress.com configuration test passed and is ready to use</h4>';
                $("#wordpress-test-result").append(text);
            }
        });
    });
    
    //-------------------------
    //BLOGGER TEST
    //-------------------------
    $("#blogger-test-btn").on('click', function() {
        $("#blogger-test-result").empty();
        var image = '<img id="mailer-loading" class="loader-image" src="' + $("#load-image").val() + '">';
        $("#blogger-test-result").append(image);
        var data = {
            'action': 'test_blogger',
            'nonce': ajax_object.ajax_nonce
        };

        var request = $.ajax({
            url: ajax_object.ajax_url,
            data: data,
            type: 'post',
            dataType: 'json'
        });

        request.done(function(msg) {
            $('#blogger-test-result').find('#mailer-loading').remove();
            $("#blogger-test-result").empty();

            if(msg.error) {
                $("#blogger-test-result").addClass('error');
                var text = '<h4> Failed to connect to the blog. </h4><p>Check your configuration, and try again.</p>';
                $("#blogger-test-result").append(text);
            }
            if(msg.success) {
                $("#blogger-test-result").addClass('updated');
                var text = '<h4> Blogger configuration test passed and is ready to use</h4>';
                $("#blogger-test-result").append(text);
            }
        });
    });
});