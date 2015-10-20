<?php
include_once('carousel.php');
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - <?php echo $options['website_title']; ?></title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap-united.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">	
			<div class="navbar-header">
			    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				    <span class="icon-bar"></span>
			  		<span class="icon-bar"></span>
		   	   		<span class="icon-bar"></span>
				</button>
		 	   	<a class="navbar-brand" href="#">News Item</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav" style="float:right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Username <b class="caret"></b></a>
						<ul class="dropdown-menu">
				    		<li><a href="#">Action</a></li>
				    		<li><a href="#">Another action</a></li>
				    		<li><a href="#">Something else here</a></li>
				    		<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Staff <b class="caret"></b></a>
						<ul class="dropdown-menu">
					 		<li><a href="#">Moderation Panel</a></li>
							<li class="divider"></li>
							<li><a href="#">Staff Forums</a></li>
							<li class="divider"></li>
							<li><a href="#">Site Admin</a></li>
							<li><a href="#">XenForo Admin</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Username <b class="caret"></b></a>
					<ul class="dropdown-menu">
					    <li><a href="#">Action</a></li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li class="divider"></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				</li>
			</ul>
			-->
		</div>
	</div>
	
	<?php if($displayCarousel) {
				echo displayCarousel();
			} else {
				echo 'Logo goes here';
			}
	?>
	
	<div class="container" style="padding-top:60px; background: white;">
	
	<div class="navbar navbar-default">
		  <div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
		      <span class="icon-bar"></span>
		      <span class="icon-bar"></span>
		      <span class="icon-bar"></span>
		    </button>
		    <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $options['website_title'] ?></a>
		  </div>
		  <div class="navbar-collapse collapse navbar-responsive-collapse">
		    <ul class="nav navbar-nav">
		      <li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Games<b class="caret"></b></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">Game 2</a></li>
		          <li><a href="#">Game 1</a></li>
		          <li><a href="#">Game 3</a></li>
		          <li class="divider"></li>
		          <li class="dropdown-header">Coming Soon!</li>
		          <li><a href="#">Game 4</a></li>
		        </ul>
		      </li>
			  <li><a href="#">Players</a></li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="#">Link</a></li>
		      <li class="dropdown">
		        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">Action</a></li>
		          <li><a href="#">Another action</a></li>
		          <li><a href="#">Something else here</a></li>
		          <li class="divider"></li>
		          <li><a href="#">Separated link</a></li>
		        </ul>
		      </li>
		    </ul>
		  </div>
		</div>