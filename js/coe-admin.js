(function($){

    $(function(){

        $('#coe-college-upload-logo').click(function(e){

            e.preventDefault();

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Insert Images',
                button: {
                    text: 'Insert'
                },
                multiple: true  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {

                var selection = file_frame.state().get('selection');

                selection.map( function( attachment ) {

                    attachment = attachment.toJSON();
                    $('#coe-college-logo-img').html('<img src="' + attachment.url + '" class="img-responsive">');
                    $('#coe-college-logo').val(attachment.url);
                    $('#coe-college-remove-logo').show();

                });
            });

            // Finally, open the modal
            file_frame.open();
        });

        $('#coe-college-remove-logo').click(function(e){

            e.preventDefault();
            $('#coe-college-logo-img').html('');
            $('#coe-college-logo').val('');
            $('#coe-college-remove-logo').hide();

        });

    });

})(jQuery);