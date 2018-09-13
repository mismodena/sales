<?

include "lib/cls_kelas_dealer.php";

$arr_parameter = array();

if( @$_REQUEST["cari"] != "" )
	$arr_parameter = array(
			" (b.namecust " => array("", " like '%". @$_REQUEST["cari"] ."%' or a.dealer like '". @$_REQUEST["cari"] ."%' ) ")
		);

	
$rs = kelas_dealer::data_kelas_dealer( $arr_parameter );

$arr_data_perpage = array(10, 30, 50, 70);
$data_perpage = 	$arr_data_perpage[ @$_REQUEST["s_perhalaman"] != "" ? @$_REQUEST["s_perhalaman"] : 0 ];

$counter=1; 

$page_counter = @$_REQUEST["s_halaman"] != "" ? $_REQUEST["s_halaman"] + 1 : 1;
$page_number = ( ( $page_counter - 1 ) * $data_perpage ) + 1;	
$page_total=ceil( sqlsrv_num_rows( $rs ) / $data_perpage );

$s_data_kelas = "<tr><td colspan=\"5\" style=\"padding:17px;\"><h3>Tidak ada data ditemukan!</h3></td></tr>";

if( sqlsrv_num_rows( $rs ) <= 0 ) goto Skip;

unset( $s_data_kelas );

while( true == true ){
	
	$kelas_dealer = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC, SQLSRV_SCROLL_ABSOLUTE, $page_number-1 );

	$periode_kelas_dealer = strtoupper( $arr_month[ (int)$kelas_dealer["periode"]->format("m") ] . " " . $kelas_dealer["periode"]->format("Y") );
	$rata_rata_omset_periode = 	strtoupper( $arr_month[ (int)$kelas_dealer["b3"]->format("m") ] . " " . $kelas_dealer["b3"]->format("Y") . " - " .
									$arr_month[ (int)$kelas_dealer["b1"]->format("m") ] . " " . $kelas_dealer["b1"]->format("Y") );
	
	$arr_data_kelas_dealer = array(
		$page_number,
		strtoupper($kelas_dealer["dealer"]),
		strtoupper($kelas_dealer["namecust"]),
		number_format($kelas_dealer["ratarata_omset"]),
		strtoupper( $kelas_dealer["kelas"] )
		);
	@$s_data_kelas .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_kelas_dealer) . "</td></tr>";
	
	if( $counter == $data_perpage || $page_number==sqlsrv_num_rows( $rs ) )break;
	$counter++; $page_number++;
	
}

Skip:

?>