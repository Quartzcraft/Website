<?php
/**
* Basic QuartzCore Database class
*
*/
class QC_Database {
	
	public $QCConfig = array();	
	
    /**
    * Retrieves the QuartzCore database connection.
    */
    public static function getQuartzcoreDatabase() {
		$QCConfig['QC_host'] = '127.0.0.1';
		$QCConfig['QC_username'] = 'root';
		$QCConfig['QC_password'] = 'database1';
		$QCConfig['QC_database'] = 'QuartzCore';
        $con = mysqli_connect($QCConfig['QC_host'],$QCConfig['QC_username'],$QCConfig['QC_password'],$QCConfig['QC_database']);

		// Check connection
		if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		} else {
			return $con;
		}		
	}
}