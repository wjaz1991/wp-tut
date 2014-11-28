$(function() {
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        topDistance: '300', // Distance from top before showing element (px)
        topSpeed: 300, // Speed back to top (ms)
        animation: 'fade', // Fade, slide, none
        animationInSpeed: 200, // Animation in speed (ms)
        animationOutSpeed: 200, // Animation out speed (ms)
        scrollText: '', // Text for element
        activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    });
      
    
    if($('.post-thumbnail img').length > 0) {
        var $anchor = $('.post-thumbnail img');
    }
    else if($('.post-meta h4').length > 0) {
       var $anchor = $('.post-meta h4');
    } else {
        var $anchor = $('.post-title h1');
    }
    
    var position = $anchor.position().top - $('.post-pagination a').position().top + parseInt($anchor.css('margin-top'));
    
    console.log(parseInt($anchor.css('margin-top')));
    $('.post-pagination a').css({
        'height': $anchor.height(),
        'margin-top': position,
        'min-height': '100px'
    });
});