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
	
	if($peregrine->get->getUsername('username')) {
		$player = $qc->getPlayerFromName($peregrine->get->getUsername('username'));
		header('Location: player.php?id=' . $player['id']);
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prism - Players</title>
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
			   		<li><a href="index.php">Prism Home</a></li>
					<li><a href="reports.php">Reports</a></li>
				   	<li><a href="search.php">Search Logs</a></li>
				    <li class="active"><a href="player.php">Players</a></li>
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
				<?php if($peregrine->get->getInt('id')): ?>
					<?php $player = $qc->getPlayer($peregrine->get->getInt('id'));?>
					<h1>Prism - Profile of <?php echo $player['DisplayName']; ?></h1>
				<?php else: ?>
				<h1>Prism - Find Players</h1>
				<form id="frm-search" action="#" method="post">
				    <input type="hidden" id="curr_page" name="curr_page" value="1" />
				    <input type="hidden" id="per_page" name="per_page" value="25" />
					<div class="row">
						<fieldset class="span6">
					    	<div class="well">
					 		    <h4>Quick Search</h4>
					          	<div class="row">
					              	<div class="control-group span1">
					                   <label class="control-label" for="playerid">Player ID</label>
					                  	<div class="controls">
					                  		<input type="text" class="span1" placeholder="1" id="playerid" name="playerid" value="">
					              		</div>
					              	</div>
					             	<div class="control-group span4">
								       <label class="control-label" for="name">Player Name</label>
									   <div class="controls">
								  		   <input type="text" class="span4" name="name" id="name" placeholder="SoulPunisher" />
								 	   </div>
							    	</div>
					      	    </div>
							    <div class="row">
				   	               <div class="control-group span5">				                       <label class="control-label" for="uuid">UUID</label>
										<div class="controls">
											<input type="text" class="span5" placeholder="7f6f3a38-2a6c-4bf1-ac97-b90a172e9748" id="uuid" name="uuid" value="">
								 		</div>					           			</div>
					        	</div>
					   		</div>
					    </fieldset>
					    <fieldset class="span6">
					        <div class="well">
					    	    <h4>Advanced Search</h4>
				    	    </div>
					    </fieldset>
				 	</div>
			   		<button id="submit" type="submit" class="">Search</button>
				</form>
			<?php endif; ?>
                <footer><p>Prism WebUI <?php print WEB_UI_VERSION ?> &mdash; By Viveleroi. Modified for QuartzCraft by mba2012.</p></footer>
            </div>
        </article>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/underscore.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
