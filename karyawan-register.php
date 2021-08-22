<?php

include "conf_config.php";
include "conf_dbconnect.php";

opendb();
$action = $_POST['action'];
$data = mysql_query("SELECT * FROM customer");
$id =  mysql_num_rows($data) + 10001;

$username = $_POST['username'];
$nama = $_POST['nama'];
$tlp = $_POST['telp'];
$pass = $_POST['pass'];
$kota = $_POST['kota'];
$jk= $_POST['jk'];
$email= $_POST['email'];
$tgl = date("Y-m-d");

$cek_user = mysql_query("select * from customer where nama ='$nama'");
$cek = mysql_fetch_assoc($cek_user);


?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OKOS - Pesan kos mu secara online</title>
    <meta name="description" content="OKOS - Pesan kos mu secara online">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="images/house-icon.jpg">
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

    <div class="okos-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                
                <div class="login-logo">
                    <a href="home.html">
                        <img class="align-content" src="images/okos.png" height="50" width="200" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <?php
                    if ($action == 'Simpan Data') {
                        if ($cek[nama] == $nama) {
                            echo "<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>
                                    <i class='fa fa-times'></i>
                                    Username sudah digunakan
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button>
                                </div> ";
                        } else {
                            $query_input = "insert into customer (id_customer, nama, pass, nama_lengkap, telp, email, kota_asal, jenis_kelamin, date_created, hak_akses) values ('CUST$id', '$username', '$pass', '$nama', '$tlp', '$email', '$kota', '$jk', '$tgl', '1')";
                            querydb($query_input);

                            $query_saldo_customer = "insert into saldo_customer (id_saldo, saldo, id_customer) values ('SS$id','0', 'CUST$id')";
                            querydb($query_saldo_customer);

                            echo "<div class='sufee-alert alert with-close alert-success alert-dismissible fade show'>
                                    <i class='fa fa-check'></i>
                                    Data berhasil disimpan
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                    </button>
                                </div>";
                        } 

                    } 
                    ?>
                    <form name="login" id="login" action="" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input type="text" name="telp" class="form-control" placeholder="No. Telp" required>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <label>Kota asal</label>
                            <td><label class="control-label mb-1">&nbsp;:&nbsp;</label></td>
                            <td><select name="kota" id="select" class="form-control">
                                <option value="0">-- Pilih Kota --</option>
                                <?php
                                $data_kota = mysql_query("SELECT * FROM kota");
                                while ($kota=mysql_fetch_assoc($data_kota)) {
                                ?>
                                    <option value="<?php echo $kota[nama]; ?>"><?php echo $kota[nama]; ?></option>
                                <?php } ?>
                                    
                            </select></td> 
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="input-group">
                            <div class="form-check form-check-inline">
                                <div class="radio">
                                    <label for="radio1" class="form-check-label ">
                                        <input type="radio"class="form-check-input" name="jk" value="laki-laki">Laki-laki&nbsp;&nbsp;
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="radio2" class="form-check-label ">
                                        <input type="radio" class="form-check-input" name="jk" value="perempuan">Perempuan&nbsp;&nbsp;
                                    </label>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        
                        <button name="action" value="Simpan Data" id="action" type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>        
                        <div class="register-link text-center mt-2">
                                <p>Sudah memiliki akun?<a href="customer-login.php"> Sign in</a></p>
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
