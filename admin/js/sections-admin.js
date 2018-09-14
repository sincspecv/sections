jQuery(function($){
  /*
   * Select/Upload image(s) event
   */
  $('body').on('click', '.image_button', function(e){
        e.preventDefault();
        // get the index from the button that was selected
        var index = $(this).context.dataset.index;

        // define the parameters for the media modal
        var custom_uploader = wp.media({
            title: 'Select image',
            library : {
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on('select', function() { // it also has "open" and "close" events
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#section_image_src_'+index).val(attachment.url); // add the image url to the hidden field
            $('#image_button_'+index).text('Replace Section Image'); // change the text of the button
            $('#section_image_'+index+' > img').attr('src', attachment.url); // add src to the img tag to show the image
            $('#remove_image_button_'+index).show(); // show the remove image button

        })
            .open();
    });

    // var button = $(this),

  // });

  /*
   * Remove image event
   */
  $('body').on('click', '.remove-image-button', function(){
      var index = $(this).context.dataset.index;
      $(this).hide();
      $('#section_image_'+index+' > img').attr('src', '');
      $('#section_image_src_'+index).val('');
      $('#image_button_'+index).text('Add Section Image');

      return false;
  });

});
