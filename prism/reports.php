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

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prism - Reports</title>
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
					<li class="active"><a href="reports.php">Reports</a></li>
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
				<?php if($peregrine->get->getInt('id')): ?>
					<?php 
						$report = $qc->getReport($peregrine->get->getInt('id'));
						$reporting_player = $qc->getPlayer($report['reporting_user_id']);
						$reported_player = $qc->getPlayer($report['reported_user_id']);
					?>
					<h1>Prism - Report on <?php echo $reported_player['DisplayName']; ?></h1>
					<div class="row">
						<div class="span5">
					   		<div class="well">
								<p>Report ID: <?php echo $report['id']; ?><p/>
								<p>Timestamp: <?php echo $report['timestamp']; ?></p>
								<p>Reporting Player: <a href="player.php?id=<?php echo $report['reporting_user_id']; ?>"><?php echo $reporting_player['DisplayName']; ?></a></p>
								<p>Reported Player: <a href="player.php?id=<?php echo $report['reported_user_id']; ?>"><?php echo $reported_player['DisplayName']; ?></a></p>
								<div class="row">
							</div>
						</div>
						<div class="span4">
							<div class="well">
								<p>Test</p>
							</div>
						</div>
					</div>
				<?php else: ?>
				<h1>Prism - Find Reports</h1>
				<div class="row">
					<div class="span6">
				    	<div class="well">
				          	<div class="row">
								<form id="frm-search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
									<input type="hidden" id="search" name="search" value="1" />
								    <input type="hidden" id="curr_page" name="curr_page" value="1" />
								    <input type="hidden" id="per_page" name="per_page" value="25" />
				              		<div class="control-group span4">
				                   		<label class="control-label" for="player">Find reports for player</label>
					                  	<div class="controls">
				                  		    <input type="text" class="span4" placeholder="Jakres" id="player" name="player" value="">
				              			</div>
				              		</div>
								</form>
							</div>
						</div>
					</div>
				 	<div class="span6">
				        <div class="well">
							<p>You can use the actions in the right column to view, flag(claim), discard or reopen a report.<br/>This page only displays the 25 most recent reports for the specified player.</p>
			    	    </div>
				    </div>
			 	</div>
				<div id="results">
				        <div class="table-wrap">
				        	<div id="loading"></div>
				            	<table class="table table-report">
				                	<thead>
				                   		<tr>
					                       	<th>ID</th>
											<th>Timestamp</th>
					                       	<th>Reported Player</th>
					                       	<th>Reporting Player</th>
					                       	<th>Content</th>
											<th>Actions</th>
				                       	</tr>
				                	</thead>
				              		<tbody>
										<?php if($peregrine->get->getInt('search')): ?>
											<?php if($peregrine->get->getUsername('player')): ?>
												<?php
												    $reported_player = $peregrine->get->getUsername('player');
												    $reported_user = $qc->getPlayerFromName($reported_player);
												    $reports = $qc->findReports($reported_user);
												    if($reports == 0) {
												        echo '<tr><td colspan="7">No reports found.</td></tr>';
												    } else {
												        while($report = mysqli_fetch_array($reports)) {
												            $reporting_player = $qc->getPlayer($report['reporting_user_id']);
												            $actions = '<a href="reports.php?id=' . $report['id'] . '">View</a>';  
												            echo '<tr><td>' . $report['id'] . '</td><td>' . $report['timestamp'] . '</td><td>' . $reported_user['DisplayName'] . '</td><td>' . $reporting_player['DisplayName'] . '</td>';
												            echo '<td>' . $report['report_content'] . '</td><td>' . $actions . '</td></tr>';
												        }
												    }
												?>
											<?php else: ?>
											    <tr><td colspan="7">No search parameters are set!</td></tr>
											<?php endif; ?>
										<?php else: ?>
				                  			<tr><td colspan="7">Awaiting search.</td></tr>
										<?php endif; ?>
				                  	</tbody>
				            	</table>
				         	</div>
				  		<div class="meta">
				        	<ol>
				            	<li>1</li>
				           	</ol>
				     	</div>
				</div>
			<?php endif; ?>
                <footer><p>Prism WebUI <?php print WEB_UI_VERSION ?> &mdash; By Viveleroi. Modified for QuartzCraft by mba2012.</p></footer>
            </div>
        </article>
	  	<script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
