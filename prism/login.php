<?php
	require_once('config.php');
	require_once('libs/Bootstrap.php');

	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
		header("Location: login.php");
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	// If login form submitted
	if(!$peregrine->post->isEmpty('username')){

	    // Verify username/password - then set an auth token
	    if($auth->authUser($peregrine->post->getUsername('username'), $peregrine->post->getRaw('password'))){
	        $_SESSION['username'] = $peregrine->post->getUsername('username');
	        $token = $peregrine->post->getUsername('username').$peregrine->server->getRaw('REMOTE_ADDR');
	        $_SESSION['token'] = $auth->hashString( $token );
	        header("Location: index.php");
	    } else {
	        header("Location: login.php?auth_failed=1");
	    }
	    // No need to refresh cage, we're redirecting so a reload
	    // won't cause a new POST
	    exit;
	} else {

	    $token = $peregrine->session->getUsername('username').$peregrine->server->getRaw('REMOTE_ADDR');
	    if($auth->checkToken($token,$peregrine->session->getRaw('token'))){
	        define('AUTHENTICATED', true);
			header("Location: index.php");
	    } else {
	        define('AUTHENTICATED', false);
	    }
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prism - Login</title>
        <meta charset="utf-8" />
        <link href="./css/bootstrap.min.css" media="all" rel="stylesheet">
        <link href="./css/app.css" media="all" rel="stylesheet">
    </head>
    <body>
		<article>
            <div class="container">
				<h1>Prism - Login</h1>
				<div class="row">
					<div class="span6">
				    	<div class="well">
				          	<div class="row">
								<?php if($peregrine->get->getInt('auth_failed')): ?>
									<p class="text-error">Authentication failed.</p>
								<?php endif; ?>
							 	<form id="frm-login" action="#" method="post">
							   		<div class="control-group span4">
								      	<div class="controls">
								       		<input type="text" placeholder="Username" id="username" name="username" value="">
											<input type="password" class="span3" placeholder="Password" id="password" name="password" value="">
								      	</div>
								 	</div>
								 	<div class="control-group span4">
										<input type="submit" value="Login" class="btn btn-success">
								 	</div>
								</form>
							</div>
						</div>
					</div>
			 	</div>
                <footer><p>Prism WebUI <?php print WEB_UI_VERSION ?> &mdash; By Viveleroi. Modified for QuartzCraft by mba2012.</p></footer>
            </div>
        </article>
	  	<script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
