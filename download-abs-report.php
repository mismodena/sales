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
			->setCellValue("B5", "DEALER")
			->setCellValue("C5", "NAMA MM")
			->setCellValue("D5", "JAM KERJA")
			->setCellValue("E5", "HARI KERJA")
			->setCellValue("F5", "TRAINING")
			->setCellValue("G5", "POIN JAM KERJA")
			->setCellValue("H5", "POIN HARI KERJA")
			->setCellValue("I5", "POIN TRAINING")
			->setCellValue("J5", "POIN OMZET")
			->setCellValue("K5", "POIN TOTAL")
			->setCellValue("L5", "KOMISI POIN")
			->setCellValue("M5", "KOMISI SPECIAL CAMPAIGN");
			//->setCellValue("N5", "KETERANGAN");
	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_font_style);		
	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_border_style);
	
	// bagian isi tabel
	$start_nomor = 5; $end_nomor = $start_nomor;
	$arr_parameter["a.area"] = array("=", "'". main::formatting_query_string( $_REQUEST["area"] ) ."'");
	$arr_parameter["a.periode"] = array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'");
	$arr_sort["a.nama_user"] = "ASC";
	$rs_komisi = komisi::load_data_komisi_poin( $arr_parameter, $arr_sort);
	
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
			->setCellValue("B" . ($end_nomor), strtoupper($komisi["store"]) )
			->setCellValue("C" . ($end_nomor), strtoupper($komisi["nama_user"]) )
			->setCellValue("D" . ($end_nomor), $komisi["jam_kerja"] )
			->setCellValue("E" . ($end_nomor), $komisi["hari_kerja"] )
			->setCellValue("F" . ($end_nomor), $komisi["training"] )
			->setCellValue("G" . ($end_nomor), $komisi["poin_jk"] )
			->setCellValue("H" . ($end_nomor), $komisi["poin_hk"] )
			->setCellValue("I" . ($end_nomor), $komisi["poin_tr"] )
			->setCellValue("J" . ($end_nomor), $komisi["poin_omzet"] )
			->setCellValue("K" . ($end_nomor), $komisi["poin_total"] )
			->setCellValue("L" . ($end_nomor), $komisi["komisi_poin"] )
			->setCellValue("M" . ($end_nomor), $komisi["komisi_spesial"] );
		

		$objPHPExcel->getActiveSheet()->getStyle('L' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('M' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
			
	}
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="report-komisi-poin-'. $_REQUEST["area"] .'-'. $formatted_periode .'.xls"');
	$lokasi_simpan_file = "php://output";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save( $lokasi_simpan_file );
	
	exit;

?>