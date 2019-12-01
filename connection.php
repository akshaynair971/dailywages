<?php
	global $db;
	include_once('core.php');	
	include_once('mysql.php'); 

	date_default_timezone_set('Asia/Kolkata');

	function prnt($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	$db = new ezSQL_mysql('root','','dailywagesdb','localhost');
	define("site_root",'http://localhost/inhand/dailywages/',TRUE);


	// $db = new ezSQL_mysql('id11174054_dailywagesdb','id11174054_dailywagesdb','id11174054_dailywagesdb','localhost');	
	// define("site_root",'https://dailywagesdemo.000webhostapp.com/',TRUE);
	
	error_reporting(0);	
?>
