<?php
session_start();
//$sesi=session_id();
//include "session.php";
include "conf_functions.php";
include "conf_config.php";


$username = $_POST['username'];
$passwd = $_POST['password'];
$email = $_POST['email'];
$conpassword = $_POST['conpassword'];
$date = date('Y-m-d');
$hakakses = 2;

$url = "owner-login.php";

if ($username == "") {
	echo "<script type ='text/javascript'> alert('register Gagal, Isikan Username dan Password Dengan Benar');</script>";
	redirect($url . "");
} else {
	mysqli_query($conn, "INSERT INTO owner (username,password,email,status,date_created,hak_akses) VALUES('$username','$passwd','$email',1,'$date','$hakakses')");
	if (mysqli_affected_rows($conn) > 0) {
		echo "<script language='javascript'>window.location.href='owner-login.php'</script>";
	}else{
		echo "<script language='javascript'>window.location.href='owner-register.php'</script>";
	}
}
