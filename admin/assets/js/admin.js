( function ( $ ) {
    
    var redirectionLink = " https://premiumaddons.com/pro/?utm_source=wp-menu&utm_medium=wp-dash&utm_campaign=get-pro&utm_term=";
    "use strict";
    
    $(".pr-checkbox").on("click", function() {
       if($(this).prop("checked") == true) {
           $(".pr-elements-table input").prop("checked", 1);
       }else if($(this).prop("checked") == false){
           $(".pr-elements-table input").prop("checked", 0);
       }
    });

    $( 'form#pr-settings' ).on( 'submit', function(e) {
		e.preventDefault();
		$.ajax( {
			url: settings.ajaxurl,
			type: 'post',
			data: {
                action: 'pr_save_admin_addons_settings',
                security: settings.nonce,
				fields: $( 'form#pr-settings' ).serialize(),
			},
            success: function( response ) {
				swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
				);
			},
			error: function() {
				swal(
				  'Oops...',
				  'Something Wrong!',
				);
			}
		} );

	} );
        
    $('form#pr-maps').on('submit',function(e){
       e.preventDefault();
       $.ajax( {
            url: settings.ajaxurl,
            type: 'post',
            data: {
                action: 'pr_maps_save_settings',
                security: settings.nonce,
                fields: $('form#pr-maps').serialize(),
            },
            success: function (response){
                swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
                );
            },
            error: function(){
                swal(
                    'Oops...',
                    'Something Wrong!',
                );
            }
        });
    });
    
} )(jQuery);