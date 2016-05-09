<?php
	// This page generates the Social Login custom popup
	// Please style as desired
	// Additional Social Login themes can be found on your LoginRadius dashboard
	require_once('config.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

		<!-- LR JS SDK -->
		<script src='assets/js/LoginRadiusSDK.2.0.0.js'></script>

		<!-- LR Social Login Interface -->
		<script src='//hub.loginradius.com/include/js/LoginRadius.js'></script>
		
		<!-- Popup Styling -->
		<link rel="stylesheet" href="assets/css/lr-disqus-sso-popup.css" >

		<script type="text/javascript">

				function loginUser(token) {
					$.ajax( {
						type: 'POST',
						url: 'lib/disqus/disqus-sso.php',
						data: {
							token: token
						},
						success: function ( data, textStatus, XMLHttpRequest ) {
							// Close window after success received
							window.close();
						}
					} );
				}

				function AfterLogin(element) {
					// Grab token from session storage and call loginUser function
					var token = sessionStorage.getItem("LRTokenKey");
					loginUser( token );
				}

				$(document).ready(function($) {
					if ( window.opener != null && typeof document.getElementById( 'disqus_thread' ) != null ) {
						var loginform = document.getElementById('login');
						loginform.innerHTML = '<div class="lr_disqus_sso_container"><div class="lr_disqus_sso"></div></div>';

						var options = {};
						options.login = true;
						LoginRadius_SocialLogin.util.ready( function () {
							$ui = LoginRadius_SocialLogin.lr_login_settings;
							$ui.apikey = "<?php echo LR_API_KEY; ?>";
							$ui.callback = window.location.href;
							$ui.lrinterfacecontainer = "lr_disqus_sso";
							$ui.is_access_token = true;
							LoginRadius_SocialLogin.init( options );
							LoginRadiusSDK.onlogin = AfterLogin;
						});
					}
				});

		</script>
	</head>				

	<body class="lr_disqus_sso_popup">
		<div id="login"></div>
	</body>
</html>
