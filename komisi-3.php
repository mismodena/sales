<?
include "lib/mainclass.php";
require_once dirname(__FILE__) . "/lib/excel/PHPExcel.php";

// upload data item campaign
// isi ke tabel item_campaign

set_time_limit(100);

$folder = "temp/";

foreach($_FILES as $file => $arr_properti){
	if( $arr_properti["error"] == UPLOAD_ERR_OK ){
		$asal = $_FILES[ $file ]["tmp_name"];
		$tujuan = $_FILES[ $file ]["name"];
		move_uploaded_file($asal, $folder . $tujuan);
	}
}
$file_excel = $folder . $tujuan;

$excelReader = PHPExcel_IOFactory::createReaderForFile($file_excel);
$excelReader->setReadDataOnly();
$excelReader->setLoadAllSheets();

$excelObj = $excelReader->load($file_excel);
$excelObj->getActiveSheet()->toArray(null, true,true,true);

$worksheetNames = $excelObj->getSheetNames($file_excel);
$return = array();
foreach($worksheetNames as $key => $sheetName){
	
	if($key != 1) continue;

	$excelObj->setActiveSheetIndexByName($sheetName);
	$return = $excelObj->getActiveSheet()->toArray(null, true,true,true);
}

$counter = 0; $arr_kode_item = array();
$sql = "delete from item_campaign;";
foreach($return as $cell){	
	
	if( $cell["B"] != "" && !in_array( trim($cell["B"]), $arr_kode_item ) ){
		$sql .= "insert into item_campaign(kode_item) values('" . trim($cell["B"]) . "');";
		$arr_kode_item[] = trim($cell["B"]);
		$counter++;
	}
}
$rs = sql::execute( $sql );

unlink($file_excel);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses upload data item campaign - ". $counter ." item berhasil diimpor ke database.<br />';
isi += '['+ waktu_sekarang() +'] Memulai proses perhitungan komisi SPG/M awal.';
isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
parent.document.getElementById('kontainer_status').innerHTML += isi;
parent.document.getElementById('label_progress').innerHTML = 'Sabar yah bro !';
location.href = 'komisi-4.php';
</script>";

?>