<?php

include 'conf_dbconnect.php';

class Conf_function
{
	public $conn;

	public function redirect($url)
	{
		echo "<script language='javascript'>window.location.href='" . $url . "'</script>";
	}

	public function sc($value)
	{
		$dbconnect = $this->conn;
		$value = trim($value);

		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}

		$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));

		$value = strip_tags($value);
		$value = mysqli_real_escape_string($dbconnect, $value);
		$value = htmlspecialchars($value);
		return $value;
	}

	public function login($conn, $username, $passwd, $hakakses)
	{
		session_start();
		$dbconnect = new Db_connect();
		$nama = $username;
		$passwd = $passwd;
		$url = "index.php";
		$url_owner = "owner-home.php";
		$url_karyawan = "karyawan-home.php";
		$url_login = "karyawan-login.php";


		if ($hakakses == 1) {
			$query_cekuser = "SELECT * FROM  karyawan WHERE nama ='$nama' ";
			$rs_cekuser = $dbconnect->querydb($conn,$query_cekuser);

			if (mysqli_num_rows($rs_cekuser) < 0) {
				echo "<script type ='text/javascript'>alert('Login Gagal, User Anda Tidak Aktif.Hubungi Admin Sistem');</script>";
				$this->redirect($url . "");
			} else {
				$tgl = date("Y-m-d");

				$query_login = "SELECT * FROM karyawan WHERE nama ='$nama' AND pass ='$passwd'";
				$rs_login = $dbconnect->querydb($conn,$query_login);
				if (mysqli_num_rows($rs_login) > 0) {
					$data_login = mysqli_fetch_array($rs_login);
					$_SESSION['karyawan_id'] = $data_login['id_karyawan'];
					$_SESSION['username'] = $data_login['nama'];
					$_SESSION['hak_akses'] = $data_login['hak_akses'];
					$jam = date("H:i:s");
					$tgl = date("Y-m-d");
					$this->redirect($url_karyawan . "");
					$dbconnect->querydb($conn,"INSERT INTO log_akses(username ,date_login, timelogin,timelogout, status)
											VALUES('$_SESSION[username]','$tgl','$jam','','1')");
				} else {
					unset($_SESSION['karyawan_id']);
					unset($_SESSION['username']);
					unset($_SESSION['hak_akses']);
					echo "<script type ='text/javascript'>alert('Login Gagal,Pastikan User Anda Sudah Aktif');</script>";
					$this->redirect($url_login . "");
				}
			}
		}
		if ($hakakses == 2) {
			$query_cekuser = "	SELECT 	*
									  FROM  	owner
									  WHERE 	username ='$nama' 
									  ";
			$rs_cekuser = $dbconnect->querydb($conn,$query_cekuser);

			if (mysqli_num_rows($rs_cekuser) < 0) {
				echo "<script type ='text/javascript'>alert('Login Gagal, User Anda Tidak Aktif.Hubungi Admin Sistem');</script>";
				$this->redirect($url_owner . "");
			} else {
				$query_login = "	SELECT 	*
											  FROM  	owner
											  WHERE 	username ='$nama'
											  AND 	password ='" . ($passwd) . "' ";
				//echo $query_login;
				$rs_login = $dbconnect->querydb($conn,$query_login);
				if (mysqli_num_rows($rs_login) > 0) {
					$data_login = mysqli_fetch_array($rs_login);
					$_SESSION['login_id'] = $data_login['login_id'];
					$_SESSION['username'] = $data_login['username'];
					$_SESSION['status'] = $data_login['status'];
					$_SESSION['username'] = $username;
					$jam = date("H:i:s");
					$tgl = date("Y-m-d");
					$this->redirect($url_owner . "");
					$dbconnect->querydb($conn,"INSERT INTO log_akses(username ,date_login, timelogin,timelogout, status)
											VALUES('$_SESSION[username]','$tgl','$jam','','1')");
				} else {
					unset($_SESSION['login_id']);
					unset($_SESSION['username']);
					unset($_SESSION['status']);
					echo "<script type ='text/javascript'>alert('Login Gagal,Pastikan User Anda Sudah Aktif');</script>";
					$this->redirect($url_owner . "");
				}
			}
		}
	}



	public function rp($angka)
	{
		$number = number_format($angka, 2, ',', '.');
		return $number;
	}
	public function norp($angka)
	{
		$number = number_format($angka, 0, ',', '.');
		return $number;
	}
}
