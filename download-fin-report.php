<?

// Set document properties
$objPHPExcel->getProperties()->setCreator("MZF")
							 ->setLastModifiedBy("Dari aplikasinya MZF")
							 ->setTitle("Report excel rekapan aplikasi komisi SPG/M")
							 ->setSubject("Report excel rekapan aplikasi komisi SPG/M")
							 ->setDescription("Report excel rekapan aplikasi komisi SPG/M");	
$objPHPExcel->setActiveSheetIndex(0)->setTitle("komisi");

// bagian headernya report
$objPHPExcel->getActiveSheet()
			->setCellValue("A1", "KOMISI SPG / SPM CABANG " . strtoupper($_REQUEST["area"]))
			->setCellValue("A2", "PERIODE " . strtoupper($formatted_periode))
			->setCellValue("A3", "PT. INDOMO MULIA ");
$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->applyFromArray($arr_font_style);

// ngisi nilai & styling bagian header tabel
	$arr_font_style["font"]["size"] = 7;
	$objPHPExcel->getActiveSheet()
			->setCellValue("A5", "NO")
			->setCellValue("B5", "NAMA SPG/M")
			->setCellValue("C5", "NPWP")
			->setCellValue("D5", "BANK")
			->setCellValue("E5", "NOMOR REKENING")
			->setCellValue("F5", "KOMISI TOTAL")
			->setCellValue("G5", "PPh21")
			->setCellValue("H5", "KOMISI FINAL")
			->setCellValue("I5", "KOMISI YANG DIBAYARKAN");
			//->setCellValue("N5", "KETERANGAN");
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($arr_font_style);		
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($arr_border_style);
	
	// bagian isi tabel
	$start_nomor = 5; $end_nomor = $start_nomor;
	$arr_parameter["a.area"] = array("=", "'". main::formatting_query_string( $_REQUEST["area"] ) ."'");
	$arr_parameter["a.periode"] = array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'");
	$arr_parameter["ab.poin_total"] = array(">", 0);
	$arr_sort["a.nama_user"] = "ASC";
	$rs_komisi = komisi::load_data_komisi_final( $arr_parameter, $arr_sort);
	
	while( $komisi = sqlsrv_fetch_array( $rs_komisi ) ){
		
		$s_keterangan = array();
		$arr_par["a.id_user"] = array("=", $komisi["id_user"]);
		$arr_par["a.periode"] = array("=", $komisi["periode"]);		
		/*$rs_keterangan = komisi::load_data_penjualan_rekap($arr_par);
		while( $data_keterangan = sqlsrv_fetch_array( $rs_keterangan ) )
			$s_keterangan[] = $data_keterangan["nama_model_singkat"];*/
		$s_keterangan = array();
		$end_nomor = $start_nomor+$komisi["nomor"];
		$objPHPExcel->getActiveSheet()
			->setCellValue("A" . ($end_nomor) , $komisi["nomor"] )
			->setCellValue("B" . ($end_nomor), strtoupper($komisi["nama_user"]) )
			->setCellValue("C" . ($end_nomor), strtoupper($komisi["npwp"]) )
			->setCellValue("D" . ($end_nomor), $komisi["bank"] )
			->setCellValue("E" . ($end_nomor), $komisi["rekening"] )
			->setCellValue("F" . ($end_nomor), $komisi["komisi_total"] )
			->setCellValue("G" . ($end_nomor), $komisi["pph"] )
			->setCellValue("H" . ($end_nomor), $komisi["komisi_final"] )
			->setCellValue("I" . ($end_nomor), ceil($komisi["komisi_final"] / 50) * 50 );
			//->setCellValue("N" . ($end_nomor), implode(",", $s_keterangan) );
		
		$objPHPExcel->getActiveSheet()->getStyle('F' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('G' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('H' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
			
	}
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="report-komisi-finance-'. $_REQUEST["area"] .'-'. $formatted_periode .'.xls"');
	$lokasi_simpan_file = "php://output";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save( $lokasi_simpan_file );
	
	exit;

?>