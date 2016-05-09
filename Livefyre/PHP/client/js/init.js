(function(root, $, Livefyre, lr_livefyre ) {
	"use strict";

	if ( ! lr_livefyre ) {
		console.log("MISSING LOGINRADIUS LIVEFYRE - Please ensure that Livefyre is properly set up");
		return;
	}

	if ( ! Livefyre ) {
		console.log("MISSING LIVEFYRE - Please ensure that Livefyre is properly set up");
		return;
	}

	var networkConfig = {
		network: LIVEFYRE_NETWORK
	};

	// Gets CollectionMeta and Checksum
	var data = lr_livefyre.getCollectionMetaChecksumToken( title, articleId, url );

	var convConfig = {
      siteId: LIVEFYRE_SITE_ID,
      articleId: articleId,
      el: 'livefyre', // Id of the div to render commenting interface
      collectionMeta: data.collectionMetaToken,
      checksum: data.checksum
    };

	Livefyre.require(['fyre.conv#3','auth'], function(Conv,auth) {
	    
	    new Conv( networkConfig, [convConfig], function( commentsWidget ) {}());

		// Login/Logout Buttons
		var login_btn = $(".login");
		var logout_btn = $(".logout");

		// Login user function
		// get LR Token after login and create Livefyre User Token
		var loginLivefyre = function(promise) {

			if( ! $.cookie( LIVEFYRE_COOKIE_NAME ) ) {
				
				var lrToken = sessionStorage.getItem('LRTokenKey');
				if( "" !== lrToken ) {
					LoginRadiusSDK.getUserprofile( function( profile ) {
					  var user = lr_livefyre.getAuthToken( profile.ID, profile.FullName );
					  if( user.userAuthToken ) {
					  	$.cookie( LIVEFYRE_COOKIE_NAME, user.userAuthToken );

					  	authLivefyre();

					  	if (promise) {
					  		promise.success();
					  	}
					  }
					});
				}
			} else {
				// Already logged in
				authLivefyre();

				if (promise) {
					promise.success();
				}
			}
		};

		var authLivefyre = function () {
			if( $.cookie( LIVEFYRE_COOKIE_NAME ) ) {
				try {
					auth.authenticate({
						livefyre: $.cookie( LIVEFYRE_COOKIE_NAME )
					});
					$('#lr-pop-group').remove();
				} catch(e) {
					error(e);
				}
			}
		};

		// Livefyre authDelegate
		var authDelegate = {
				login: function(errback) {
					if( ! $.cookie( LIVEFYRE_COOKIE_NAME ) ) {
						lr_livefyre.renderLoginView( loginLivefyre );
					} else {
						// Already logged in
						authLivefyre();
					}
				},

				logout: function(errback) {
					if( $.cookie( LIVEFYRE_COOKIE_NAME ) ) {
						sessionStorage.removeItem('LRTokenKey');
						$.removeCookie( LIVEFYRE_COOKIE_NAME );
					}
					errback(null);
				},

				viewProfile: function(user) {
					//No view configured
					//To set up you'll need to implement ping for pull see Livefyre.com for more details
					lr_livefyre.renderProfileView();
				},

				editProfile: function(user) {
					//No view configured
					//To set up you'll need to implement ping for pull see Livefyre.com for more details
					lr_livefyre.renderEditView();
				}
		};

		// Use for Livefyre SSO
		authDelegate.forEachAuthentication = function (authenticate) {
		  window.addEventListener('userAuthenticated', function(data) {
		    authenticate({livefyre: data.token});
		  });
		}

		auth.delegate(authDelegate);

		// Login/Logout Button click events
		$(document).ready(function() {
			login_btn.on("click", function() {
				Livefyre.require(['auth'], function(auth) {
					auth.login();
				});
				return false;
			});

			logout_btn.on("click", function() {
				Livefyre.require(['auth'], function(auth) {
					auth.logout();
				});
				return false;
			});
		});
	});

}( this, jQuery, Livefyre, lr_livefyre ));
