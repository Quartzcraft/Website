<?php
	require_once('config.php');
	require_once('libs/Bootstrap.php');
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	$token = $peregrine->session->getUsername('username').$peregrine->server->getRaw('REMOTE_ADDR');
	if($auth->checkToken($token,$peregrine->session->getRaw('token'))){
    	define('AUTHENTICATED', true);	
	} else {
    	define('AUTHENTICATED', false);
	}
		
	if(!AUTHENTICATED) {
		header("Location: login.php");
	}
	
	function displayAnnouncements() {
		$post_url = XenAPI_URL;
		$post_data = array('action' => 'getthreads',
		                   'hash'  => 'API_KEY',
							'node_id' => STAFF_ACCOUNCEMENTS_FORUM,
							'order_by' => 'post_date',
							'order' => 'desc',
							'limit' => '5');
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $post_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($handle);
		$http_status_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		$json_decode = json_decode($output, true);
		if ($http_status_code == 200) {
			$threads = $json_decode['threads'];
								
			foreach ($threads as $thread) {
				echo '<li><a href="http://quartzcraft.co.uk/threads/' . $thread['thread_id'] . '">' . $thread['title'] . '</a></li>';
			}
					
			return false;
		} else {
			return false;
		}
	}
	
	function displayReports() {
		
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prism - QuartzCraft Moderation Panel</title>
        <meta charset="utf-8" />
        <link href="./css/bootstrap.min.css" media="all" rel="stylesheet">
        <link href="./css/app.css" media="all" rel="stylesheet">
    </head>
    <body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<a class="brand" href="http://quartzcraft.co.uk" style="float: right;" target="_blank">QuartzCraft</a>
			    <ul class="nav">
					<li class="divider-vertical"></li>
			   		<li class="active"><a href="index.php">Prism Home</a></li>
					<li><a href="reports.php">Reports</a></li>
				   	<li><a href="search.php">Search Logs</a></li>
				    <li><a href="player.php">Players</a></li>
					<li class="divider-vertical"></li>
				</ul>
				<form class="navbar-form pull-left" action="player.php" method="get">
			  		<input type="text" class="span2" placeholder="nfell2009" id="username" name="username">
					<button type="submit" class="btn">Find Players</button>
				</form>
		 	</div>
		</div>
        <article>
         	<div class="container">
            	<h1>Prism</h1>
				<div class="row">
					<div class="span6">
			 			<div class="well">
							<h4>Staff Announcements and Updates</h4>
						   	<div class="row">
									<ul>
										<?php displayAnnouncements(); ?>
									</ul>	
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="span6">
			    		<div class="well">
							<h4>Recent Reports</h4>
			          		<div class="row">
								<ul>
									<?php 
										while ($report = mysqli_fetch_array($qc->getLatestReports())) {
											//echo '<li><a href="reports.php?id=' . $report['id'] . '">' . $qc->getPlayer($report['reporting_user_id'])['DisplayName'] . ' reported ' . $qc->getPlayer($report['reported_user_id'])['DisplayName'] . '</a></li>';
										} 
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			   	<footer><p>Prism WebUI <?php print WEB_UI_VERSION ?> &mdash; By Viveleroi. Modified for QuartzCraft by mba2012.</p></footer>
            </div>
        </article>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/underscore.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
