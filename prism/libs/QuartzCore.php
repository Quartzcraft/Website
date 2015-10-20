<?php
	
class QuartzCore {
	
	private $qc_db;
	
	public function __construct(){
 	   
	}
	
	public function init() {
		$this->qc_db = mysqli_connect(QC_HOSTNAME, QC_USERNAME, QC_PASSWORD, QC_DATABASE);
		if(mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
	}
	
	public function getPlayer($id) {
		$result = mysqli_query($this->qc_db, "SELECT * FROM PlayerData WHERE id='" . $id . "' LIMIT 1;");
		if($result == 0) {
			echo '<p style="color:white">An unexpected database error occured retrieving player data from id</p>';
			echo '<p style="color:black">An unexpected database error occured retrieving player data from id</p>';
			exit();
		}
		$row = mysqli_fetch_array($result);
		return $row;
	}
	
	public function getPlayerFromName($displayname) {
		$result = mysqli_query($this->qc_db, 'SELECT * FROM PlayerData WHERE DisplayName="' . $displayname . '" LIMIT 1;');
		if($result == 0) {
			echo '<p style="color:white">An unexpected database error occured retrieving player data from name</p>';
			echo '<p style="color:black">An unexpected database error occured retrieving player data from name</p>';
			exit();
		}
		$row = mysqli_fetch_array($result);
		return $row;
	}
	
	public function findReports($reported) {
		$result = mysqli_query($this->qc_db, "SELECT * FROM Reports WHERE reported_user_id=" . $reported['id'] . " ORDER BY id DESC LIMIT 25;");
		if($result == 0) {
			return 0;
		}
		return $result;
	}
	
	public function findSelectReports($reported) {
		$result = mysqli_query($this->qc_db, "SELECT * FROM Reports WHERE reported_user_id=" . $reported['id'] . " ORDER BY id DESC LIMIT 25;");
		if($result == 0) {
			return 0;
		}
		return $result;
	}
	
	public function getLatestReports() {
		$result = mysqli_query($this->qc_db, "SELECT * FROM Reports ORDER BY id DESC LIMIT 5;");
		if($result == 0) {
			return 0;
		}
		return $result;
	}
	
	public function getReport($id) {
		$result = mysqli_query($this->qc_db, "SELECT * FROM Reports WHERE id='" . $id . "' LIMIT 1;");
		if($result == 0) {
			echo '<p style="color:white">An unexpected database error occured retrieving report from id</p>';
			echo '<p style="color:black">An unexpected database error occured retrieving report from id</p>';
			exit();
		}
		$row = mysqli_fetch_array($result);
		return $row;
	}
}
?>