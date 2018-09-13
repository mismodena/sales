<?

set_time_limit(100);

if( @$_REQUEST["c"] == "" ) goto SkipCommand;

$data_tpk =  sqlsrv_fetch_array(
			komisi::load_data_periode(array("[id]" => array("=", "'" . main::formatting_query_string(@$_REQUEST["periodeid"]) . "'" )), array("periode" => "desc"))
			);
$formatted_periode = /*$data_tpk["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_tpk["periode"]->format("m") ] . " " . $data_tpk["periode"]->format("Y");

require_once dirname(__FILE__) . "/lib/excel/PHPExcel.php";

$objPHPExcel = new PHPExcel();		

// font styling
$arr_font_style = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Tahoma'
    ));
// styling tabel header, kasih warna kuning
$arr_bgcolor_style = array(
			 'fill' => array(
			     'type' => PHPExcel_Style_Fill::FILL_SOLID,
			     'color' => array('rgb' => 'ffff00')
			 )
		);	
// border styling
$arr_border_style = array(
	'borders' => array(
			'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
	)
);		

// pembuatan file excel-nya
//include "download-report-". $_REQUEST["c"] .".php";    
include "download-app-report.php";    

SkipCommand:

?>