<?php
include "conf_config.php";
include "conf_dbconnect.php";
// include "karyawan-conf-function.php";
?> 
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kepkop- Kepingin.Kopi</title>
    <meta name="description" content="Welcome">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/logoo.png">
        <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
        <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="bg">
    <div class="background=orange">
    </div>

    <div class="p-3 mb-2 bg-white text-success">
    <div class="Kepkop-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                <img class="align-content" src="images/logo.jpeg" height="90" width="250" alt=""></img>
                </div>
                <div class="login-form">
                       <form name="login" id="login" action="karyawan-conf-login.php" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" >
                        </div>
                       
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                        <div class="register-link text-center mt-2">
                            <p>Belum memiliki akun?<a href="karyawan-register.php"> Register</a></p>
                        </div>
                        <div class="register-link text-center ">
                            <p><a href="index.php">Kembali ke halaman awal</a></p>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>

</html>
