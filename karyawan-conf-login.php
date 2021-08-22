<?php
session_start();
//$sesi=session_id();
//include "session.php";
include "conf_functions.php";
include "conf_config.php";


$username=$_POST['username'];
$passwd=$_POST['password'];
$hakakses = 1;

$url="karyawan-login.php";

	if ($username == "") 
	{
			echo "<script type ='text/javascript'> alert('Login Gagal, Isikan Username dan Password Dengan Benar');</script>";
			redirect($url."");
	}
	else
	{
		$conf_func = new Conf_function();
		$conf_func->login($conn,$username,$passwd,$hakakses);
	}
