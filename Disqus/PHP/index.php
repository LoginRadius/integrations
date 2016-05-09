<?php
	require_once('lib/disqus/disqus-sso.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Disqus integration with LoginRadius Social Login (PHP)</title>
	</head>
	<body>
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			var disqus_config = function() {
				<?php if( isset($_SESSION['message']) && isset($_SESSION['hmac']) && isset($_SESSION['timestamp']) ) { ?>
			    	this.page.remote_auth_s3 = "<?php echo $_SESSION['message'] . ' ' . $_SESSION['hmac'] . ' ' . $_SESSION['timestamp']; ?>";
				<?php } else { ?>
					this.page.remote_auth_s3 = {};
				<?php } ?>
			    	this.page.api_key = "<?php echo DISQUS_PUBLIC_KEY; ?>";

				    // This adds the custom login/logout functionality
				    this.sso = {
				          name:   "LoginRadius", // Your site's name. We will display it in the Post As window.
				          button: "http://<?php echo $_SERVER['HTTP_HOST'] . str_replace( 'index.php','', $_SERVER['PHP_SELF'] ); ?>assets/images/lr-btn.png", // Address of the image that acts as a button. Disqus 2012 users, see style guide below.
				          url:    "http://<?php echo $_SERVER['HTTP_HOST'] . str_replace( 'index.php','', $_SERVER['PHP_SELF'] ); ?>login.php", // Address of your login page. The page will be opened in a new window and it must close itself after authentication is done. That's how we know when it is done and reload the page.
				          logout: "http://<?php echo $_SERVER['HTTP_HOST'] . str_replace( 'index.php','', $_SERVER['PHP_SELF'] ); ?>logout.php", // Address of your logout page. This page must redirect user back to the original page after logout.
				          width:  "500", // Width of the login popup window. Default is 800.
				          height: "400" // Height of the login popup window. Default is 400.
				    };
			}
		</script>
		<script type="text/javascript">
		    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		    var disqus_shortname = '<?php echo DISQUS_SHORTNAME; ?>'; // Required - tells Disqus which website account (called a forum on Disqus) this system belongs to.
		    var disqus_identifier = window.location.href; // Required - tells Disqus how to uniquely identify the current page. '{{example}}'
		    var disqus_url = window.location.href; // Required - tells Disqus the location of the page for permalinking purposes.
		    var disqus_title = document.title; // Optional - If undefined, Disqus will use the <title> attribute of the page. If that attribute could not be used, Disqus will use the URL of the page.
		    //var disqus_category_id = '123456'; // Optional - example shows category Sports which has ID 123456 See https://help.disqus.com/customer/portal/articles/472098-javascript-configuration-variables for more info
		    
		    /* * * DON'T EDIT BELOW THIS LINE * * */
		    (function() {
		        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		    })();
		</script>
		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	</body>
</html>