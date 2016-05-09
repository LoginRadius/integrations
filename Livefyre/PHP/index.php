<?php
// have config drive doc root
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Livefyre integration with LoginRadius</title>

    <!-- jQuery & JQuery Cookie -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.cookie.min.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- LoginRadius Files -->
    <script src="//hub.loginradius.com/include/js/LoginRadius.js"></script>
    <script src="assets/js/LoginRadiusSDK.2.0.0.js"></script>
    
    <!-- Livefyre -->
    <script src="//cdn.livefyre.com/Livefyre.js"></script>

    <!-- Global Variables -->
    <script type="text/javascript">
      // Livefyre configuration used globally.
      var LIVEFYRE_NETWORK = "<?php echo LIVEFYRE_NETWORK; ?>";
      var LIVEFYRE_SITE_ID = "<?php echo LIVEFYRE_SITE_ID; ?>";
      var LIVEFYRE_COOKIE_NAME = "<?php echo LIVEFYRE_COOKIE_NAME; ?>";
      var title = document.title;
      var articleId = "<?php echo ARTICLE_ID; ?>";
      var url = "<?php echo URL; ?>";
      var LR_API_KEY = "<?php echo LR_API_KEY; ?>";
    </script>

    <!-- Client Side JS Files -->
    <!-- lr_livefyre contains AJAX calls and views to render -->
    <script src="client/js/lr_livefyre.js" type="text/javascript"></script>
    <script src="client/js/init.js" type="text/javascript"></script>
  </head>
  <body>
    <div>
      <ul>
        <!-- Login In/ Log Out Buttons -->
        <li id="login"><button class="login">Log In</button></li>
        <li id="logout"><button class="logout">Log Out</button></li>
      </ul>
    </div>
    <!-- Livefyre Div - Commenting will be rendered here -->
    <div id="livefyre"></div>
  </body>
</html>