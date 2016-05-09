(function($) {
		
	var method = {};

	method.getAuthToken = function( userId, displayName ) {
		var returnData;
		$.ajax( {
			type: 'POST',
			url: 'server/ajax/authToken-ajax.php',
			async: false,
			data: {
				userId: userId,
				displayName: displayName
			},
			success: function ( data, textStatus, XMLHttpRequest ) {
				returnData = $.parseJSON( data );
			}
		} );
		return returnData;
	}

	method.getCollectionMetaChecksumToken = function ( title, articleId, url ) {
		var returnData;
		$.ajax( {
			type: 'POST',
			url: 'server/ajax/collectionMetaToken-ajax.php',
			async: false,
			data: {
				title: title,
				articleId: articleId,
				url: url
			},
			success: function ( data, textStatus, XMLHttpRequest ) {	
				returnData = $.parseJSON( data );
			}
		} );
		return returnData;
	}

	method.renderLoginView = function ( callback ) {
		$('#lr-pop-group').remove();

		$('body').append('<div id="lr-pop-group" class="lr-livefyre-container lr-show-layover"><div id="lr-overlay" class="lr-livefyre-overlay"></div><div class="lr-livefyre-popup lr-popup-container lr-show"><div class="lr-popup-header"><span class="lr-popup-close-span"><span class="lr-popup-close-btn">x</span></span><div class="lr-header-logo"> <p class="lr-header-caption">Login</p></div></div> <div class="lr_livefyre_interface"></div> </div> </div>');
        
            var options = {};
			options.login = true;
			LoginRadius_SocialLogin.util.ready( function () {
				$ui = LoginRadius_SocialLogin.lr_login_settings;
				$ui.apikey = LR_API_KEY;
				$ui.callback = window.location.href;
				$ui.lrinterfacecontainer = "lr_livefyre_interface";
				$ui.is_access_token = true;
				LoginRadius_SocialLogin.init( options );
				LoginRadiusSDK.setLoginCallback( callback );
			});

        	

        jQuery('.lr-livefyre-overlay,.lr-livefyre-popup .lr-popup-close-span').click(function(){
            window.location.hash = '';
            $('#lr-pop-group').remove();
        });
	}

	method.renderProfileView = function() {
		alert('Profile View');
	}

	method.renderEditView = function () {
		alert('Edit Profile View');
	}
	
	window.lr_livefyre = method;
}(jQuery));
