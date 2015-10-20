<?php
  class Players extends CI_Controller {

	  public function index() {
	  	echo 'Players index!';
	  }

	  public function viewPlayer($playerId) {
	    echo 'The specified id is ' . $playerId;
	  }
  }
?>
