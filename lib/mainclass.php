<?

include "var.php";
include "cls_main.php";
include "sql.php";
include "cls_user.php";
include "cls_komisi.php";
include "cls_penjualan.php";
include "cls_konfigurasi_komisi.php";

// page
$arr_page=preg_split("/\//", $_SERVER['SCRIPT_FILENAME']);
$page=$arr_page[count($arr_page)-1];

// filter user session
if( @$_SESSION["user_login"] == "" && $page != "login.php" ) header("location:login.php");

$arr_session_area = @$_SESSION["area"] != "" ? explode("|", $_SESSION["area"]) : array(); 	sort($arr_session_area);

// filter hak akses
$data_akses_pengguna = akses_pengguna::otorisasi_akses_pengguna( $page, @$_SESSION["user_login"] );
if( !$data_akses_pengguna[0] ) 	
	header("location:terlarang.php");
@$script .= $data_akses_pengguna[1];


// include halaman fungsi
if( file_exists( $page . ".function" . ".php" ) )
	include $page . ".function" . ".php";

?>