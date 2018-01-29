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
        
        <!-- LR Social Login Interface -->
	<script src='//auth.lrcontent.com/v2/js/LoginRadiusV2.js'></script>

        <!-- Popup Styling -->
        <link rel="stylesheet" href="assets/css/lr-disqus-sso-popup.css" >

        <script type="text/javascript">
            var commonOptions = {};
            commonOptions.apiKey = "<?php echo LR_API_KEY; ?>";
            commonOptions.hashTemplate = true;
            commonOptions.callbackUrl = window.location.href;
            commonOptions.verificationUrl = window.location;
            var LRObject = new LoginRadiusV2(commonOptions);
            
            function loginUser(token) {
                $.ajax({
                    type: 'POST',
                    url: 'lib/disqus/disqus-sso.php',
                    data: {
                        token: token
                    },
                    success: function (data, textStatus, XMLHttpRequest) {
                        // Close window after success received
                        window.close();
                    }
                });
            }

            $(document).ready(function ($) {
                if (window.opener != null && typeof document.getElementById('disqus_thread') != null) {
                    var loginform = document.getElementById('interfacecontainerdiv');
                    loginform.innerHTML = '<div class="lr_disqus_sso_container"><div class="lr_disqus_sso"></div></div>';

                    var custom_interface_option = {};
                    custom_interface_option.templateName = 'loginradiuscustom_tmpl';
                    LRObject.util.ready(function () {
                        LRObject.customInterface(".lr_disqus_sso", custom_interface_option);
                    });
                    
                    var sl_options = {};
                    sl_options.onSuccess = function(response) {
                        loginUser(response.access_token);
                    };
                    sl_options.onError = function(errors) {                    
                        console.log(errors);
                    };
                    sl_options.container = "sociallogin-container";

                    LRObject.util.ready(function() {
                        LRObject.init('socialLogin', sl_options);
                    });
                }
            });

        </script>
    </head>				

    <body class="lr_disqus_sso_popup">
        <script type="text/html" id="loginradiuscustom_tmpl">
            <span class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#= Name.toLowerCase() #>" onclick="return <#=ObjectName#>.util.openWindow('<#= Endpoint #>');" title="Sign up with <#= Name #>" alt="Sign in with <#= Name #>"> 
                <span class="lr-sl-icon lr-sl-icon-<#= Name.toLowerCase() #>"></span> 
                Login with <#= Name #>       
            </span>
        </script>
        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
        <div id="sociallogin-container"></div>
    </body>
</html>
