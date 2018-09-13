<?

include "lib/mainclass.php";
require_once dirname(__FILE__) . "/lib/excel/PHPExcel.php";

$objPHPExcel = new PHPExcel();		

// Set document properties
$objPHPExcel->getProperties()->setCreator("MZF")
							 ->setLastModifiedBy("Automatic oleh aplikasinya MZF")
							 ->setTitle("Template data item campaign untuk aplikasi komisi SPG/M")
							 ->setSubject("Template data item campaign untuk aplikasi komisi SPG/M")
							 ->setDescription("Template data item campaign untuk aplikasi komisi SPG/M");	
							 
// daftar produk ada di sheet pertama
$objPHPExcel->setActiveSheetIndex(0)->setTitle("master_produk");

// tulis data master produk
$rs_item = komisi::load_data_item( array("isnull(b.itemno, '')" => array("<>", "''") ), true );
while( $item = sqlsrv_fetch_array( $rs_item ) )
	$objPHPExcel->getActiveSheet()
								->setCellValue("A" . $item["nomor"], $item["model"])
								->setCellValue("B". $item["nomor"], $item["fmtitemno"]);

// daftar item campaign di sheet kedua
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1)->setTitle("data_item_campaign");

// tulis data template
$objPHPExcel->getActiveSheet()->setCellValue("B1", "=IF(A1<>\"\",VLOOKUP(trim(A1), master_produk!\$A\$1:\$B\$". sqlsrv_num_rows($rs_item) .", 2,0), \"\")");

// download / simpan file excel
if( @$_REQUEST["c"] == "" ){
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="data-item-campaign.xls"');
	$lokasi_simpan_file = "php://output";
	
}else 	$lokasi_simpan_file = "temp/data-item-campaign-". date("Ymd") .".xls";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save( $lokasi_simpan_file );

?>