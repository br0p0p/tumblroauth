<?php
	// create a fake user account for this example
	$_SESSION['usr']['id'] = 1;
	
	// define path to root and site url
	defined('SITE_ROOT') ? null : define('SITE_ROOT', '/home/mysite/public_html');
	defined('SITE_URL')  ? null : define('SITE_URL',  'http://mysite.com');
	
	// define database
	require_once(SITE_ROOT.'/includes/db.php');
	
	// include functions
	require_once(SITE_ROOT.'/includes/functions.php');
	
	// define Tumblr OAuth
	defined('TUMBLR_OAUTH_KEY')      ? null : define('TUMBLR_OAUTH_KEY', 'YOUR-KEY-GOES-HERE');
	defined('TUMBLR_OAUTH_SECRET')   ? null : define('TUMBLR_OAUTH_SECRET', 'YOUR-SECRET-GOES-HERE');
	defined('TUMBLR_OAUTH_CALLBACK') ? null : define('TUMBLR_OAUTH_CALLBACK', SITE_URL.'/auth/tumblr_oauth.php?callback=true');
	
