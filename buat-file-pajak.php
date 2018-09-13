<?
include "lib/mainclass.php";
require_once dirname(__FILE__) . "/lib/excel/PHPExcel.php";

$objPHPExcel = new PHPExcel();	

//if(isset($_GET["dlw"])){								 
	$objPHPExcel->getProperties()->setCreator("FDA")
							 ->setLastModifiedBy("Automatic oleh aplikasinya FDA")
							 ->setTitle("Template absesni mitra")
							 ->setSubject("Template absesni mitra")
							 ->setDescription("Template absesni mitra");	
	
	// create style
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN
		//'color' => array('rgb'=>'766f6e')
	);
	$style_header = array(
		'borders' => array(
			'allborders' => $default_border,
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb'=>'FFFF00'),
		),
		'font' => array(
			'bold' => true,
			'size' => 14,
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)
	);
	$style_content = array(
		'borders' => array(
			'allborders' => $default_border,
		),
		/*'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb'=>'ffffff'),
		),*/
		'font' => array(
			'size' => 12,
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		)
	);
	
	$style_right = array(
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		)
	);
	
	// Create Header
	$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
	$periode = /*$data_periode["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_periode["periode"]->format("m") ] . " " . $data_periode["periode"]->format("Y");

	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', "Periode : ")
				->setCellValue('B1', $periode)
				->setCellValue('A2', 'No')
				->setCellValue('B2', 'NIK')
				->setCellValue('C2', 'NAMA')
				->setCellValue('D2', 'STORE')
				->setCellValue('E2', 'AREA')
				->setCellValue('F2', 'NPWP')
				->setCellValue('G2', 'TOTAL KOMISI')
				->setCellValue('H2', 'PPH21')
				;
	
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray( $style_header ); // give style to header
	
	$objPHPExcel->getActiveSheet()
			->getStyle("B")
			->getNumberFormat()
			->setFormatCode(
				PHPExcel_Style_NumberFormat::FORMAT_NUMBER
			);
			
	$objPHPExcel->getActiveSheet()
			->getStyle("F")
			->getNumberFormat()
			->setFormatCode(
				PHPExcel_Style_NumberFormat::FORMAT_TEXT
			);
	
	$sql = "SELECT a.id_user, a.periode, a.nama_user, store, area, [target], b.nik, komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) komisi_total  
			, b.npwp
			FROM komisi a
			inner join absensi abs on abs.id_user = a.id_user and abs.periode = a.periode
			inner join openquery(MYSQLDMZ, 'select * from ".$GLOBALS['db_mysql'].".`user` ') b on a.id_user = b.id_user
			where a.periode = ( select top 1 id from periode order by id desc ) and status = 1
			and komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) > 0 ";
			//and area = '".$_REQUEST["area"]."' ";
			$arr_area = explode("|",$_REQUEST["area"]);
			if(count( $arr_area ) > 0){
				$sql .= "and area in (";
				foreach ($arr_area as $area) {
					$sql .= "'".$area."',";
				}
			$sql = substr($sql,0,-1);
			$sql .= ")";
			}
	$sql .=	"order by a.nama_user --, area, store
			";
	$rs = sql::execute( $sql );
	
	$m = 3; $counter=1;
	while($param=sqlsrv_fetch_array($rs)){
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A".$m, $counter)
				->setCellValue("B".$m, $param['nik'])
				->setCellValue("C".$m, $param['nama_user'])
				->setCellValue("D".$m, $param['store'])
				->setCellValue("E".$m, $param['area'])
				->setCellValue("F".$m, $param['npwp'])
				->setCellValue("G".$m, $param['komisi_total'])
				;
		
		$objPHPExcel->getActiveSheet()->getStyle("A".$m.":H".$m)->applyFromArray( $style_content );
		
		$objPHPExcel->getActiveSheet()->getStyle("G".$m.":H".$m)->applyFromArray( $style_right );
		$objPHPExcel->getActiveSheet()->getStyle("G".$m.":H".$m)->getNumberFormat()->setFormatCode('#,###');
		$m++;
		$counter++;
	}
	
	
	foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    }
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Mitra');
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=PPh21_komisi.xls"); 

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	//exit;
//}
?>