<?php
function displayCarousel() {
	echo '<div id="myCarousel"
		       class="carousel slide"
		       data-ride="carousel">
		    <ol class="carousel-indicators">
		        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		        <li data-target="#myCarousel" data-slide-to="1"></li>
		        <li data-target="#myCarousel" data-slide-to="2"></li>
		    </ol>
		    <div class="carousel-inner">
		      <div class="item active">
		        <img src="assets/img/slide1.png"
		             alt="First slide">

		        <div class="container">
		          <div class="carousel-caption">
		            <h1>Minecraft Server</h1>

		            <p>The awesome network that lets you play large
		            varieties of Minecraft PvP anytime, anywhere.</p>

		            <p><a class="btn btn-lg btn-primary"
		               href="play.php"
		               role="button">Play Now &#187;</a></p>
		          </div>
		        </div>
		      </div>

		      <div class="item">
		        <img src="assets/img/slide2.png"
		             alt="Second slide">

		        <div class="container">
		          <div class="carousel-caption">
		            <h1>Minecraft Server</h1>

		            <p>The awesome network that lets you play large
		            varieties of Minecraft PvP anytime, anywhere.</p>

		            <p><a class="btn btn-lg btn-primary"
		               href="play.php"
		               role="button">Play Now &#187;</a></p>
		          </div>
		        </div>
		      </div>

		      <div class="item">
		        <img src="assets/img/slide3.png"
		             alt="Third slide">

		        <div class="container">
		          <div class="carousel-caption">
		            <h1>Minecraft Server</h1>

		            <p>The awesome network that lets you play large
		            varieties of Minecraft PvP anytime, anywhere.</p>

		            <p><a class="btn btn-lg btn-primary"
		               href="play.php"
		               role="button">Play Now &#187;</a></p>
		          </div>
		        </div>
		      </div>
		    </div><a class="left carousel-control"
		         href="#myCarousel"
		         data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control"
		         href="#myCarousel"
		         data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		  </div>
';
}
?>
