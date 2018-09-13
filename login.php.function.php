<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] =="login" ){
	
	$rs = akses_pengguna::pengguna( 
		array(
			"pengguna_nama" =>array("=", "'". main::formatting_query_string($_POST["t_username"]) . "'"), 
			"password" => array("=", "'". main::formatting_query_string($_POST["t_password"]) . "'" ) 
			)
		);
	if( sqlsrv_num_rows( $rs ) > 0 ){
		$data = sqlsrv_fetch_array( $rs );
		$_SESSION["user_login"] = $data["pengguna_id"];
		$_SESSION["user_nama"] = $data["pengguna_nama"];
		$_SESSION["area"] = $data["parameter"];
		
		// untuk approval
		if($_SESSION["user_nama"]=="sonny") header("location:data-upload-pph.php");
		else if($_SESSION["user_nama"]=="userfin") header("location:finance.php");
		else header("location:index.php");


	}else{
		
		// cek untuk spg login
		$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
		$rs = akses_pengguna::spg_login( 
			array(
				"username" =>array("=", "'". main::formatting_query_string($_POST["t_username"]) . "'"), 
				"password" => array("=", "'". main::formatting_query_string(md5($_POST["t_password"])) . "'" ) 
				) );
		if( mysqli_num_rows( $rs ) > 0 ){
			$data = mysqli_fetch_array( $rs );
			$_SESSION["user_login"] = $data["id_user"];
			$_SESSION["user_nama"] = $data["nama_user"];
			header("location:sales-monitoring.php");
			
		}else
			header("location:login.php");
	}
	
}elseif( $_REQUEST["c"] =="logout" ){
	unset($_SESSION["user_login"]);
	header("location:login.php");
}

Skip:

?>