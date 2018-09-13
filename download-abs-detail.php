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
			->setCellValue("B5", "NAMA MM")
			->setCellValue("C5", "DEALER")
			->setCellValue("D5", "CABANG")
			->setCellValue("E5", "TARIF POINT")
			->setCellValue("F5", "JAM KERJA")
			->setCellValue("G5", "HARI KERJA")
			->setCellValue("H5", "TRAINING")
			->setCellValue("I5", "TARGET")
			->setCellValue("J5", "REALISASI")
			->setCellValue("K5", "%")
			->setCellValue("L5", "REKENING")
			->setCellValue("M5", "BANK");

	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_font_style);		
	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($arr_border_style);
	
	$objPHPExcel->getActiveSheet()
			->getStyle("L")
			->getNumberFormat()
			->setFormatCode(
				PHPExcel_Style_NumberFormat::FORMAT_NUMBER
			);
	
	// bagian isi tabel
	$start_nomor = 5; $end_nomor = $start_nomor;
	$arr_parameter["a.area"] = array("=", "'". main::formatting_query_string( $_REQUEST["area"] ) ."'");
	$arr_parameter["a.periode"] = array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'");
	$arr_parameter["ab.poin_total"] = array(">", 0);
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
			->setCellValue("B" . ($end_nomor), strtoupper($komisi["nama_new"]) )
			->setCellValue("C" . ($end_nomor), strtoupper($komisi["store"]) )
			->setCellValue("D" . ($end_nomor), $komisi["area"] )
			->setCellValue("E" . ($end_nomor), $komisi["tarif"] )
			->setCellValue("F" . ($end_nomor), $komisi["jam_kerja"] )
			->setCellValue("G" . ($end_nomor), $komisi["hari_kerja"] )
			->setCellValue("H" . ($end_nomor), $komisi["training"] )
			->setCellValue("I" . ($end_nomor), $komisi["target"] )
			->setCellValue("J" . ($end_nomor), $komisi["realisasi_android"] )
			->setCellValue("K" . ($end_nomor), $komisi["target"] > 0 ? "=round(J". $end_nomor ."/I". $end_nomor . " * 100, 0)" : "0" )
			->setCellValue("L" . ($end_nomor), $komisi["rekening"] )
			->setCellValue("M" . ($end_nomor), $komisi["bank"] );
		
		$objPHPExcel->getActiveSheet()->getStyle('E' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
			
	}
	
	$objPHPExcel->getActiveSheet()
			->setCellValue("H" . ($end_nomor + 1), "TOTAL" )
			->setCellValue("I" . ($end_nomor + 1), "=sum(I". ($start_nomor + 1) .":I". $end_nomor .")" )
			->setCellValue("J" . ($end_nomor + 1), "=sum(J". ($start_nomor + 1) .":J". $end_nomor .")" )
			->setCellValue("K" . ($end_nomor + 1), "=round(J". ($end_nomor + 1) ."/I". ($end_nomor + 1) . " * 100, 0)" );
		
	$sum1 = "J" . ($end_nomor + 1);
	
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		
	//2
	$start_nomor = $end_nomor + 4;		
	$end_nomor = $start_nomor;
	$objPHPExcel->getActiveSheet()
			->setCellValue("A" . $start_nomor, "NO")
			->setCellValue("B" . $start_nomor, "NAMA MM")
			->setCellValue("C" . $start_nomor, "POIN JAM KERJA")
			->setCellValue("D" . $start_nomor, "POIN HARI KERJA")
			->setCellValue("E" . $start_nomor, "TRAINING")
			->setCellValue("F" . $start_nomor, "POIN OMZET")
			->setCellValue("G" . $start_nomor, "TOTAL POIN")
			->setCellValue("H" . $start_nomor, "KOMISI POIN")
			->setCellValue("I" . $start_nomor, "KOMISI PENJUALAN")
			->setCellValue("J" . $start_nomor, "KOMISI SPECIAL CAMPAIGN")
			->setCellValue("K" . $start_nomor, "TOTAL KOMISI")
			->setCellValue("L" . $start_nomor, "STATUS NPWP")
			->setCellValue("M" . $start_nomor, "POTONGAN PPh21")
			->setCellValue("N" . $start_nomor, "POTONGAN SELISIH")
			->setCellValue("O" . $start_nomor, "INSENTIF DiBAYARKAN");
	$objPHPExcel->getActiveSheet()->getStyle('A' . $start_nomor. ':O' . $start_nomor)->applyFromArray($arr_font_style);		
	$objPHPExcel->getActiveSheet()->getStyle('A' . $start_nomor. ':O' . $start_nomor)->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $start_nomor. ':O' . $start_nomor)->applyFromArray($arr_border_style);	
	
	
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
			->setCellValue("B" . ($end_nomor), strtoupper($komisi["nama_new"]) )
			->setCellValue("C" . ($end_nomor), $komisi["poin_jk"] )
			->setCellValue("D" . ($end_nomor), $komisi["poin_hk"] )
			->setCellValue("E" . ($end_nomor), $komisi["poin_tr"] )
			->setCellValue("F" . ($end_nomor), $komisi["poin_omzet"] )
			->setCellValue("G" . ($end_nomor), $komisi["poin_total"] )
			->setCellValue("H" . ($end_nomor), $komisi["komisi_poin"] )
			->setCellValue("I" . ($end_nomor), $komisi["komisi_penjualan"] )
			->setCellValue("J" . ($end_nomor), $komisi["komisi_spesial"] )
			->setCellValue("K" . ($end_nomor), $komisi["komisi_total"] )
			->setCellValue("L" . ($end_nomor), $komisi["npwp"] )
			->setCellValue("M" . ($end_nomor), $komisi["pph"] )
			->setCellValue("N" . ($end_nomor), $komisi["potongan"] )
			->setCellValue("O" . ($end_nomor), $komisi["komisi_final"] );
		
		$objPHPExcel->getActiveSheet()->getStyle('H' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('K' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('M' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('N' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('O' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		
		if($komisi["poin_total"]<30)
			$objPHPExcel->getActiveSheet()->getStyle("A".($end_nomor).":O".($end_nomor))->applyFromArray($arr_font_red);
	}
	
	
	$objPHPExcel->getActiveSheet()
			->setCellValue("G" . ($end_nomor + 1), "TOTAL" )
			->setCellValue("H" . ($end_nomor + 1), "=sum(H". ($start_nomor + 1) .":H". $end_nomor .")" )
			->setCellValue("I" . ($end_nomor + 1), "=sum(I". ($start_nomor + 1) .":I". $end_nomor .")" )
			->setCellValue("J" . ($end_nomor + 1), "=sum(J". ($start_nomor + 1) .":J". $end_nomor .")" )
			->setCellValue("K" . ($end_nomor + 1), "=sum(K". ($start_nomor + 1) .":K". $end_nomor .")" )
			->setCellValue("M" . ($end_nomor + 1), "=sum(M". ($start_nomor + 1) .":M". $end_nomor .")" )
			->setCellValue("N" . ($end_nomor + 1), "=sum(N". ($start_nomor + 1) .":N". $end_nomor .")" )
			->setCellValue("O" . ($end_nomor + 1), "=sum(O". ($start_nomor + 1) .":O". $end_nomor .")" );
		
	$sum2 = "O" . ($end_nomor + 1);
	
		$objPHPExcel->getActiveSheet()->getStyle('H' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('K' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('M' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('N' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('O' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
		
	$objPHPExcel->getActiveSheet()
			->setCellValue("N" . ($end_nomor + 2), "COST RATIO" )
			->setCellValue("O" . ($end_nomor + 2), "=round(".$sum2."/".$sum1."*100,2)" );
		
	//$objPHPExcel->getActiveSheet()->getStyle('N' . ($end_nomor + 2) )->getNumberFormat()->setFormatCode('#,###');
	
	
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="report-insentif-mitra-'. $_REQUEST["area"] .'-'. $formatted_periode .'.xls"');
	$lokasi_simpan_file = "php://output";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save( $lokasi_simpan_file );
	
	exit;

?>