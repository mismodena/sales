<?
include "includes/top.php";

list($halaman, $parameter) = $_SESSION["halaman_ditolak"];
$info_halaman = akses_pengguna::akses_halaman( $halaman, "nama_file" );
echo "<h1 style=\"color:red\">Cari halaman yang lain aja ya...</h1>";
echo "<div style='width:300px'><img src='images/tearful-smiley.png' style='width:177px' /></div>";	

echo "Dilarang untuk mengakses halaman berikut :<br />" . 
	$info_halaman . " (". $halaman .") <br />Parameter : " . http_build_query( $parameter );	

include "includes/bottom.php";
?>