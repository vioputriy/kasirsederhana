<?php
session_start();
//$sesi=session_id();
//include "session.php";
include "conf_config.php";

function redirect($url){
	echo "<script language='javascript'>window.location.href='".$url."'</script>";
}

$username=$_POST['username'];
$passwd=$_POST['password'];

$url="index.php";
		
		$jam = date("H:i:s");		
		mysqli_query($conn, "UPDATE log_akses 
					SET timelogout='$jam', status='2' 
					WHERE username = '$_SESSION[username]' AND status ='1' ");
					unset($_SESSION['username']);
					unset($_SESSION['karyawan_id']);
					unset($_SESSION['login_id']);
					
		session_destroy();
		redirect($url."");
		
?>