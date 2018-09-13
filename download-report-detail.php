<?

$arr_parameter["a.area"] = array("=", "'". main::formatting_query_string( $_REQUEST["area"] ) ."'");
$arr_parameter["a.periode"] = array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'");
$arr_sort["a.nama_user"] = "ASC";
$rs_komisi = komisi::load_data_komisi( $arr_parameter, $arr_sort);
$id_user = "";

while( $komisi = sqlsrv_fetch_array( $rs_komisi ) ){
	
	$nama_user = $komisi["nama_user"];
	$sheet_indeks = $komisi["nomor"];
	$arr_data_komisi = $komisi;

	if( @$tambahin_satu_lagi ){
		$id_user = $komisi["id_user"]; 
		break;
	}
	
	if( @$_REQUEST["id_user"] == "" && $sheet_indeks == 1){
		$id_user = $komisi["id_user"];
		break;
	}elseif( $_REQUEST["id_user"] ==  $komisi["id_user"] && $sheet_indeks < sqlsrv_num_rows($rs_komisi) )
		$tambahin_satu_lagi = true;
	elseif($sheet_indeks >= sqlsrv_num_rows($rs_komisi) )
		goto DOWNLOAD;
	
}

if( @$_REQUEST["rand"] != "" && file_exists("temp/report-komisi-detail-". $_REQUEST["area"] ."-". $formatted_periode ."-". @$_REQUEST["rand"] .".xls" ) ) goto PROCEED;


RANDOM: // bikin file excel baru
$rand = rand(0, 1000);
$file_excel = "temp/report-komisi-detail-". $_REQUEST["area"] ."-". $formatted_periode ."-". $rand .".xls";
if( file_exists( $file_excel ) ) goto RANDOM;
goto TULIS;


PROCEED: // load file excel yg sudah ada, diterusin tambah datanya
$rand = $_REQUEST["rand"];
$file_excel = "temp/report-komisi-detail-". $_REQUEST["area"] ."-". $formatted_periode ."-". $rand .".xls";
$excelReader = PHPExcel_IOFactory::createReaderForFile($file_excel);
$objPHPExcel = $excelReader->load($file_excel); echo $sheet_indeks;
$objWorkSheet = $objPHPExcel->createSheet($sheet_indeks - 1);


TULIS: 
include "download-report-detail.php.function.php";
$objPHPExcel->setActiveSheetIndex($sheet_indeks - 1)->setTitle( $nama_user );
penjualan_detail_isi 	( 
						$objPHPExcel->getActiveSheet(),
						$id_user,
						penjualan_detail_header( $objPHPExcel->getActiveSheet(), $arr_data_komisi )
						);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save( $file_excel );

echo "<script src=\"js/main.js\"></script>";
echo "	<script>
		var isi = '<div style=\"margin:0px 0px 0px 17px; font-size:10px; line-height:17px\"><img src=\"images/checkbox-checked.png\" style=\"height:11px; margin-right:7px\" />Bikinin report untuk komisi SPG/M : ". str_replace("'", "\'", $nama_user) .".</div>';
		parent.document.getElementById('kontainer_status').innerHTML += isi;		
		location.href='?c=detail&rand=". $rand ."&id_user=". $id_user ."&area=". $_REQUEST["area"] ."&periodeid=".$_REQUEST["periodeid"]."';
		</script>
	";
exit;

DOWNLOAD:
echo "<script src=\"js/main.js\"></script>";
echo "		
	<script>
	parent.sembunyikan_kotak_loading();
	var isi = '['+ waktu_sekarang() +'] Selesai bikinin report excel komisi SPG/M.<br /><br />';
	isi += '<input type=\"button\" value=\"Kembali\" onclick=\"location.reload();\" style=\"width:177px; background-color:green\" />';
	parent.document.getElementById('kontainer_status').innerHTML += isi;
	parent.document.getElementById('img_progress').setAttribute('src', 'images/thumbsup.gif');
	parent.document.getElementById('label_progress').innerHTML = 'Siippp.. dah kelar bro !';
	location.href='download.php?f=temp/report-komisi-detail-". $_REQUEST["area"] ."-". $formatted_periode ."-". $_REQUEST["rand"] .".xls';
	</script>
";

exit;


?>