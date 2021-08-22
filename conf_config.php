<?php	
	// if(preg_match("/config.php/", $_SERVER['PHP_SELF'])){
	// 	header("Location: index.php");
	// 	die;
	// }		
	$host = 'localhost'; 				
	$dbname = 'kepkop';			
	$user = 'root';					
	$pass = '';			
	ini_set("display_errors", "0");

	$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Failed to connecting database.");
