function render_artwork_uploader($) {
    var file_frame, image_data, json;
    
    if(undefined !== file_frame) {
        file_frame.open();
        return;
    }
    
    file_frame = wp.media.frames.file_frame = wp.media({
        frame: 'post',
        state: 'insert',
        multiple: false
    });

    file_frame.on('insert', function() {
        json = file_frame.state().get('selection').first().toJSON();
        
        if(0 > $.trim(json.url.length)) {
            return;
        }
        
        $('#album-artwork-preview').children('img')
                .attr('src', json.url)
                .attr('title', json.title)
                .attr('alt', json.caption)
                .parent()
                .show();
        
        $('#artwork-url').val(json.url);
        $('#artwork-title').val(json.title);
        $('#artwork-alt').val(json.alt);
    });
    
    file_frame.open();
}

function remove_album_artwork($) {
    $('#album-artwork-preview').children('img')
            .attr('src', '')
            .attr('title', '')
            .attr('alt', '')
            .parent()
            .hide();
    
    $('#artwork-url').val('');
    $('#artwork-title').val('');
    $('#artwork-alt').val('');
}

function render_artwork($) {
    if($.trim($('#artwork-url').val()) !== '') {
        $('#album-artwork-preview').show();
    }
}

jQuery(document).ready(function($){
    render_artwork($);
    
    $('#set-album-artwork').on('click', function(evt) {
        evt.preventDefault();
        
        render_artwork_uploader($);
    });
    
    $('#remove-album-artwork').on('click', function(evt) {
        evt.preventDefault();
        
        remove_album_artwork($);
    });
});