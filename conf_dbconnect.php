<?php

include "conf_config.php";

class Db_connect
{


	public function closedb()
	{
		global $dbconnect;
		mysqli_close($dbconnect);
	}

	public function myerror($er)
	{
		switch ($er) {
			case '1216':
				echo "<div align=\"center\">Form Tidak Boleh Kosong<br/><a href=\"javascript:history.back(1)\">Kembali</a></div>";
				break;
			case '1062':
				echo "<script type ='text/javascript'> alert('Data Yang Dimasukkan Sudah Ada');</script>";
				break;
			case '1217':
				echo "<div align=\"center\">Data tidak dapat di update atau dihapus, karena dipakai oleh data lain <br/><a href=\"javascript:history.back(1)\">Kembali</a></div>";
				break;
			case '1452':
				echo "<div align=\"center\">Form Tidak Boleh Kosong<br/><a href=\"javascript:history.back(1)\">Kembali</a></div>";
				break;
			default:
				echo "";
				break;
		}
	}
	public function querydb($conn, $query)
	{
		$result = mysqli_query($conn, $query);
		return $result;
	}
	public function getOneRecord($conn, $sql)
	{
		$func = new Db_connect();
		$rs = $func->querydb($conn, $sql);
		$dataRec = mysqli_fetch_array($rs);
		return $dataRec;
	}
	public function isExist($conn, $sql)
	{
		$func = new Db_connect();
		$rs = $func->querydb($conn, $sql);
		if (mysqli_num_rows($rs) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function jmlRecord($conn, $sql)
	{
		$func = new Db_connect();
		$rs = $func->querydb($conn, $sql);
		$jml = mysqli_num_rows($rs);
		return $jml;
	}
	public function fetch($rs)
	{
		$fetch = mysqli_fetch_array($rs);
		return $fetch;
	}


	public function odbc_RecCount($sql_id, $CurrRow = 0)
	{
		$NumRecords = 0;

		odbc_fetch_row($sql_id, 0);
		while (odbc_fetch_row($sql_id)) {
			$NumRecords++;
		}
		odbc_fetch_row($sql_id, $CurrRow);
		return $NumRecords;
	}
}
