<?php
// Please refer to http://apidocs.loginradius.com/docs/disqus for additional setup information
// This sample project is provided to you as an example, you may customize this as needed and use this in your own implementation
// Please contact us at http://loginradius.com if you do not have a LoginRadius account

// Find these Disqus Keys here https://disqus.com/api/applications/
define('DISQUS_SECRET_KEY', '{{ SECRET HERE }}');
define('DISQUS_PUBLIC_KEY', '{{ PUBLIC KEY HERE }}');

// Find your site shortname by navigating to https://(YOUR SITE).disqus.com/admin/settings/
// Scroll down to the "Site Identity" section
// You should see "Your website's shortname is ......."
define('DISQUS_SHORTNAME', '{{ SHORTNAME HERE}}');

// LoginRadius API KEY found on your LoginRadius Dashboard https://secure.loginradius.com/account#dashboard
define('LR_API_KEY', '{{ LOGINRADIUS API KEY HERE }}');

?>