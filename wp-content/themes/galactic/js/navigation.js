$(function() {
    /*
    NAVIGATION BAR MAGIC LINE ANIMATIONS
     */
    $(".main-nav ul li:first-child").addClass('current-page-item');

    var $el, leftPos, newWidth, $mainNav = $('.main-nav ul');

    $mainNav.append('<div class="clear"></div><li id="magic-line"></li>');

    var $magicLine = $("#magic-line");

    $magicLine.css('left', $('.current-page-item a').position().left)
        .css('width', $('.current-page-item').width())
        .data('origLeft', $magicLine.position().left)
        .data('origWidth', $magicLine.width());

    $('.main-nav ul li').hover(function() {
        $el = $(this);
        leftPos = $el.position().left;
        newWidth = $el.width();
        $magicLine.stop().animate({
            left: leftPos,
            width: newWidth
        });
    }, function() {
        $magicLine.stop().animate({
            left: $magicLine.data('origLeft'),
            width: $magicLine.data('origWidth')
        });
    });
});