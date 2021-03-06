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
				->setCellValue('F2', 'JAM KERJA')
				->setCellValue('G2', 'HARI KERJA')
				->setCellValue('H2', 'TRAINING')
				->setCellValue('I2', 'KOMISI SPESIAL CAMPAIGN (Rp)')
				->setCellValue('J2', 'POTONGAN SELISIH (Rp)')
				//->setCellValue('H2', 'REALISASI')
				//->setCellValue('I2', 'BANK')
				//->setCellValue('J2', 'NO REKENING')
				;
	
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray( $style_header ); // give style to header
	
	$objPHPExcel->getActiveSheet()
			->getStyle("B")
			->getNumberFormat()
			->setFormatCode(
				PHPExcel_Style_NumberFormat::FORMAT_NUMBER
			);
	
	// $sql = "SELECT a.id_user, periode, a.nama_user, store, area, [target], b.nik  FROM komisi a
			// inner join openquery(MYSQLDMZ, 'select * from nolppco_modena.`user` ') b on a.id_user = b.id_user
			// where periode = ( select top 1 id from periode order by id desc ) and status = 1
			// and tipe_promoter = 'MITRA'";
			
	$sql = "SELECT *, dbo.ambil_nilai(a.nama_user) namaUser  FROM 
		openquery(MYSQLDMZ, 'select a.nik, a.nama_user, a.alamat_user, b.area, b.store 
			from ".$GLOBALS['db_mysql'].".`user` a
			inner join ".$GLOBALS['db_mysql'].".area_store b on a.idarea = b.idarea
			where a.status = 1') a
		WHERE dbo.ambil_kode(a.alamat_user) = 'MITRA'";
			$arr_area = explode("|",$_REQUEST["area"]);
			if(count( @$arr_area ) > 0){
				$sql .= "and a.area in (";
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
				->setCellValue("C".$m, $param['namaUser'])
				->setCellValue("D".$m, $param['store'])
				->setCellValue("E".$m, $param['area'])
				;
		
		$objPHPExcel->getActiveSheet()->getStyle("A".$m.":J".$m)->applyFromArray( $style_content );
		$objPHPExcel->getActiveSheet()->getStyle("I".$m.":J".$m)->getNumberFormat()->setFormatCode('#,###');
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
	header("Content-Disposition: attachment; filename=Absensi_mitra.xls"); 

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	//exit;
//}
?>