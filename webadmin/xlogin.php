<?php
///////////////////////////////////////////////
///          Copyright AFDL YUSRA           ///
///          No Hp  : 085278458544          ///
///      E-Mail : afdalyusra94@gmail.com    ///
///        AMIK - STMIK JAYANUSA PADANG     ///
///////////////////////////////////////////////
include "config/koneksi.php";
function anti_injection($data){
  		$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  		return $filter;
}
$username = anti_injection($_POST[un]);
$pass     = anti_injection(md5($_POST[ps]));
$pass_inject     = anti_injection($_POST[ps]);


if (!ctype_alnum($username) OR !ctype_alnum($pass_inject)){
?>
			<script language="javascript">
		{
				alert("Mohon maaf, Penggunaan Simbol Tidak Diizinkan");
				javascript:history.back();
		}
		</script>
<?php
}

	else{
	$sql = mysql_query("SELECT *FROM user WHERE username = '$username' AND password = LEFT('$pass',20) AND status = 'Y' ");
	$data = mysql_fetch_array($sql);
	$jml = mysql_num_rows($sql);

	if ($jml == 1)
	{
		$sqlx = mysql_query("select*from tool where id=1");
		$datax = mysql_fetch_array($sqlx);

		session_start();
		$_SESSION[userid]	 = $data[username];
		$_SESSION[aksesid]	 = $data[akses];
		$_SESSION[nu]		 = $data[nama];
		$_SESSION[foto]		 = "don.png";
		$_SESSION[tool_nama] = $datax[instansi];


		$ip      = $_SERVER['REMOTE_ADDR'];
		mysql_query("UPDATE user SET last_login=now(), ip_login='$ip' where username='$username'");
		header("Location:media.php?".MD5("modul")."=".MD5("home"));

	
	}
	else if ($jml != 1)
	{
		?>
			<script language="javascript">
		{
				alert("Mohon Maaf, Username atau Password yang Anda Masukan Tidak Terdaftar");
				javascript:history.back();
		}
		</script>
			<?php
	}
	else
	{
		session_start();
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	
}
?>
