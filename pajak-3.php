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
$sheet = $excelObj->getActiveSheet()->toArray(null, true,true,true);

$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
$id_periode = $data_periode['id'];

//$sqlAll = "delete from absensi where periode =".$id_periode.";";
//sql::execute( $sqlAll );

// echo "<script src=\"js/main.js\"></script>";
// echo "<script>
		// parent.sembunyikan_kotak_loading();
// </script>";
$numrow=1;
foreach($sheet as $row){
	
	if ($numrow > 2) {
		$no = $row['A']; 
		$nik = $row['B']; 
		$pph = $row['H']==''?0:str_replace(",", "", $row['H'] ); 
		
		if(empty($nik)) continue;
		
		$sql = "select id_user from openquery(MYSQLDMZ, 'select * from nolppco_modena.`user` ') where nik = '".$nik."'";
		$data = sqlsrv_fetch_array(sql::execute( $sql ));
		$id_user = $data[0];
		
		$sqlC = "update komisi set pph = ".$pph." where id_user =".$id_user." and periode =".$id_periode;
		sql::execute( $sqlC );
		
		// echo "<script>
		// parent.sembunyikan_kotak_loading();
		// var isi = '['+ waktu_sekarang() +'] $no - $sqlC<br />';
		// parent.document.getElementById('kontainer_status').innerHTML += isi;
		// </script>";
	}
	 $numrow++; 
}

//sql::execute( $sqlAll );

unlink($file_excel);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses proses upload data PPh21 Komisi.<br />';
		isi += '['+ waktu_sekarang() +'] Memulai proses pengiriman email notifikasi.';
		isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
		parent.document.getElementById('kontainer_status').innerHTML += isi;		
		location.href = 'pajak-4.php?area=".$_REQUEST['area']."';
</script>";

?>