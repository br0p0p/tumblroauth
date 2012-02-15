<?php
	session_start();
	require_once('config.php');
	
	// include the tumblr oauth class
	require_once(SITE_ROOT.'/includes/classes/oauth/tumblroauth.php');
	
	
	// process form...
	if(isset($_POST['submit'])) {
		
		// clean post data
		$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
		$text  = filter_var($_POST['text'],FILTER_SANITIZE_STRING);

		// if the post to tumblr checkbox has been ticked...
		if(isset($_POST['tumble']) && $_POST['tumble'] == 1) {
			// get user's tumblr tokens from our database
			if($oauth = $db->get_row("SELECT oauth_token,oauth_secret FROM users_oauth WHERE uo_usr_id = ".$db->escape($_SESSION['usr']['id'])." AND oauth_provider = 'tumblr' LIMIT 1")) {
				
				// build the tumblr oauth object with the user's tokens
				$tumblroauth = new TumblrOAuth(TUMBLR_OAUTH_KEY, TUMBLR_OAUTH_SECRET, $oauth->oauth_token, $oauth->oauth_secret);
				
				// make sure the user authenticates with tumblr
				if($tumblroauth->authenticate()) {
													
					// build the post into an array for sending to tumblr
					// type = regular tells tumblr this is a text post
					// tumblr will not accept the post if the values are empty
					// you could also accept meta tags, photos, videos, etc., as well as linking back to your site
					// see the tumblr api for more: http://www.tumblr.com/docs/en/api
					$tumblr_post = array(
						'type'		=> 'regular',
						'title'		=> $title,
						'body' 		=> $text,
						'generator' => SITE_URL
					);
					
					// send post data to tumblr
					$response = $tumblroauth->write($tumblr_post);
					
					if($response) {
						// this is where you could redirect the user or display success message after a successful post
						// we're just going to print the text...
						echo '<h1>Posted to Tumblr!</h1>';
						echo nl2br($text);
						echo '<br><br>';
					} else {
						echo 'Could not post to Tumblr. Perhaps the API is down?';
					}
				} else {
					echo 'Could not authenticate user.';
				}
			} else {
				// user does not have tumblr tokens
				echo 'You need to authenticate with Tumblr first!';
			}
		}
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset=utf-8>
	<title>Tumblr OAuth Example</title>
	<style>
		body { font-family: 'Lucida sans', sans-serif; padding:40px; }
		ul { margin-left:-40px; list-style:none; }
		li { line-height:40px; }
		label { display:block; margin-bottom:-10px; }
		input[type="text"] { min-width:300px; padding:5px; }
		textarea { width:300px; height:150px; padding:5px; }
	</style>
</head>
<body>
	<?php
		if(check_tumblr_oauth_access()) {
			// user has authenticated with tumblr, show the form
			echo '
			<img src="images/sign-in-with-tumblr-connected.png" border="0" alt="tumblr" title="You are connected to Tumblr">
			<h2>Post Something</h2>
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<ul>
					<li><label for="title">Title:</label><input type="text" name="title"></li>
					<li>Text:<br><textarea name="text"></textarea></li>
					<li><label for="tumble"><input type="checkbox" name="tumble" id="tumble" value="1"> send to Tumblr</label></li>
					<li><input type="submit" name="submit" value="Submit"></li>
				</ul>
			</form>';
		} else {
			// user has not authenticated with tumblr. show 'sign in with tumblr' button
			echo '
			<h2>Please authorize our site with Tumblr</h2>
			<p><a href="auth/tumblr_oauth.php?redirect=true" border="0" alt="tumblr" title="Authorize our site with Tumblr"><img src="images/sign-in-with-tumblr-d.png" border="0" alt="tumblr"></a></p>';
		}
	?>
</body>
</html>
