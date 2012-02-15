<?php
	// check if user is is authorized with Tumblr
	function check_tumblr_oauth_access() {
		global $db;
		if($oauth = $db->get_row("SELECT oauth_username,oauth_token,oauth_secret FROM users_oauth WHERE uo_usr_id = ".$db->escape($_SESSION['usr']['id'])." AND oauth_provider = 'tumblr' LIMIT 1")) {
			require_once(SITE_ROOT.'/includes/classes/oauth/tumblroauth.php');
			$tumblroauth = new TumblrOAuth(TUMBLR_OAUTH_KEY, TUMBLR_OAUTH_SECRET, $oauth->oauth_token, $oauth->oauth_secret);
			$user = $tumblroauth->authenticate();
			$user = simplexml_load_string($user);
			if($user->tumblelog['name'] == $oauth->oauth_username){
				return true;
			} else {
				return false;
			}
		}
	}
	