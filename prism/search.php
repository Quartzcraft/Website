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
        <title>Prism - Quick Search</title>
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
				   	<li class="active"><a href="search.php">Search Logs</a></li>
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
                <h1>Prism - Quick Search</h1>
                <form id="frm-search" action="#" method="post">
                    <input type="hidden" id="curr_page" name="curr_page" value="1" />
                    <input type="hidden" id="per_page" name="per_page" value="25" />
                    <div class="row">
                        <fieldset class="span6">
                            <div class="well">
                                <div class="row">
                                    <div class="control-group span2">
                                        <label class="control-label" for="world">World</label>
                                        <div class="controls">
                                            <input type="text" class="span2" placeholder="world" id="world" name="world" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span1">
                                        <label class="control-label" for="x">X</label>
                                        <div class="controls">
                                            <input type="text" class="span1" placeholder="" id="x" name="x" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span1">
                                        <label class="control-label" for="y">Y</label>
                                        <div class="controls">
                                            <input type="text" class="span1" placeholder="" id="y" name="y" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span1">
                                        <label class="control-label" for="z">Z</label>
                                        <div class="controls">
                                            <input type="text" class="span1" placeholder="" id="z" name="z" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="control-group span1">
                                        <label class="control-label" for="radius">Radius</label>
                                        <div class="controls">
                                            <input type="text" class="span1" placeholder="20" id="radius" name="radius" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span4">
                                        <label class="control-label" for="players">Players</label>
                                        <div class="controls">
                                            <input type="text" class="span4" placeholder="Jake_bagby" id="players" name="players" value="">
                                        </div>
                                    </div>
                                </div>
    							<div class="row">
                                    <div class="control-group span2">
                                        <label class="control-label" for="entities">Entities</label>
                                        <div class="controls">
                                            <input type="text" class="span2" placeholder="sheep" id="entities" name="entities" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span3">
                                        <label class="control-label" for="keyword">Keyword</label>
                                        <div class="controls">
                                            <input type="text" class="span3" placeholder="/give" id="keyword" name="keyword" value="">
                                        </div>
                                    </div>
								</div>
                            </div>
                        </fieldset>
                        <fieldset class="span6">
                            <div class="well">
                                <div class="control-group">
                                    <label class="control-label" for="actions">Actions</label>
                                    <div class="controls">
                                        <input type="text" class="typeahead span5" name="actions" id="actions" placeholder="block-break,block-place" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="blocks">Blocks/Items</label>
                                    <div class="controls">
                                        <input type="text" class="typeahead span5" name="blocks" id="blocks" placeholder="stone,dirt or 1,3" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="control-group span2">
                                        <label class="control-label" for="after">After</label>
                                        <div class="controls">
                                            <input type="text" class="span2" placeholder="1h" id="after" name="after" value="">
                                        </div>
                                    </div>
                                    <div class="control-group span3">
                                        <label class="control-label" for="before">Before</label>
                                        <div class="controls">
                                            <input type="text" class="span3" placeholder="1h" id="before" name="before" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <button id="submit" type="submit" class="">Search</button>
                </form>
                <div id="results">
                    <div class="meta">
                        <div>Found <span>0</span> records. Page <span>1</span> of <span>1</span></div>
                        <ol>
                           <li>1</li>
                        </ol>
                        <form>
                            <label for="set-per-page">Per Page: </label>
                            <select name="set-per-page" id="set-per-page" class="span1">
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                                <option>500</option>
                            </select>
                        </form>
                    </div>
                    <div class="table-wrap">
                        <div id="loading"></div>
                        <table class="table table-search">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>World</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                    <th>Player</th>
                                    <th>Data</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="7">Awaiting search.</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="meta">
                        <div>Found <span>0</span> records. Page <span>1</span> of <span>1</span></div>
                        <ol>
                            <li>1</li>
                        </ol>
                    </div>
                </div>
                <footer><p>Prism WebUI <?php print WEB_UI_VERSION ?> &mdash; By Viveleroi. Modified for QuartzCraft by mba2012</p></footer>
            </div>
        </article>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/underscore.js"></script>
        <script src="js/app.js"></script>
        <script>
            $('#actions').typeahead({
                source: <?php print json_encode( $prism->getActionTypes() ) ?>,
                updater: updater,
                matcher: matcher,
                highlighter: highlighter
            });
            $('#blocks').typeahead({
                source: <?php print json_encode( array_values($prism->getItemList()) ) ?>,
                updater: updater,
                matcher: matcher,
                highlighter: highlighter
            });
        </script>
        <script type="text/html" id="action-row">
            <% _.each(actions,function(a,key,list){ %>
                <tr>
                    <td><%= a.id %></td>
                    <td><%= a.world %></td>
                    <td><%= a.x %> <%= a.y %> <%= a.z %></td>
                    <td><%= a.action %></td>
                    <td><%= a.player %></td>
                    <td>
                        <% if( typeof a.data === "object"){ _.each(a.data, function(val){ %>
                            <%= val %>
                        <% }); } else { %>
                            <%= a.data %>
                        <% } %>
                    </td>
                    <td><%= a.epoch %></td>
                </tr>
            <% }); %>
        </script>
    </body>
</html>
