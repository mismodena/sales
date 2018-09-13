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
			->setCellValue("C5", "SPG/M")
			->setCellValue("D5", "CLASS")
			->setCellValue("E5", "PER")
			->setCellValue("F5", "TARGET")
			->setCellValue("G5", "REALISASI")
			->setCellValue("H5", "% REALISASI")
			->setCellValue("I5", "KOMISI FIX")
			->setCellValue("J5", "KOMISI")
			->setCellValue("K5", "KOMISI CAMPAIGN")
			->setCellValue("L5", "KOMISI POIN")
			->setCellValue("M5", "KOMISI SPECIAL CAMPAIGN")
			->setCellValue("N5", "KOMISI TOTAL")
			->setCellValue("O5", "KOMISI PEMBULATAN");
			//->setCellValue("N5", "KETERANGAN");
	$objPHPExcel->getActiveSheet()->getStyle('A5:O5')->applyFromArray($arr_font_style);		
	$objPHPExcel->getActiveSheet()->getStyle('A5:O5')->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->getStyle('A5:O5')->applyFromArray($arr_border_style);
	
	// bagian isi tabel
	$start_nomor = 5; $end_nomor = $start_nomor;
	$arr_parameter["a.area"] = array("=", "'". main::formatting_query_string( $_REQUEST["area"] ) ."'");
	$arr_parameter["a.periode"] = array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'");
	$arr_sort["a.nama_user"] = "ASC";
	$rs_komisi = komisi::load_data_komisi( $arr_parameter, $arr_sort);
	
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
			->setCellValue("D" . ($end_nomor), $komisi["kelas"] )
			->setCellValue("E" . ($end_nomor), strtoupper($formatted_periode) )
			->setCellValue("F" . ($end_nomor), $komisi["target"] )
			->setCellValue("G" . ($end_nomor), $komisi["realisasi_android"] )
			->setCellValue("H" . ($end_nomor), $komisi["target"] > 0 ? "=round(G". $end_nomor ."/F". $end_nomor . " * 100, 2)" : "0" )
			->setCellValue("I" . ($end_nomor), $komisi["komisi_fix"] )
			->setCellValue("J" . ($end_nomor), $komisi["komisi_variabel"] )
			->setCellValue("K" . ($end_nomor), $komisi["komisi_campaign"] )
			->setCellValue("L" . ($end_nomor), $komisi["komisi_poin"] )
			->setCellValue("M" . ($end_nomor), $komisi["komisi_spesial"] )
			->setCellValue("N" . ($end_nomor), $komisi["komisi_total"] )
			->setCellValue("O" . ($end_nomor), ceil($komisi["komisi_total"] / 50) * 50 );
			//->setCellValue("N" . ($end_nomor), implode(",", $s_keterangan) );
		
		$objPHPExcel->getActiveSheet()->getStyle('F' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('G' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('K' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('L' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('M' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('N' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
		$objPHPExcel->getActiveSheet()->getStyle('O' . ($end_nomor) )->getNumberFormat()->setFormatCode('#,###');
			
	}
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="report-komisi-ringkas-'. $_REQUEST["area"] .'-'. $formatted_periode .'.xls"');
	$lokasi_simpan_file = "php://output";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save( $lokasi_simpan_file );
	
	exit;
	// styling baris data
	$arr_font_style["font"]["bold"] = false;
	$objPHPExcel->getActiveSheet()->getStyle( 'A'. ( $start_nomor + 1) .':O' . $end_nomor )->applyFromArray($arr_font_style);
	$objPHPExcel->getActiveSheet()->getStyle( 'A'. ( $start_nomor + 1 ).':O' . ( $end_nomor + 1) )->applyFromArray($arr_border_style);
	
	// ngisi nilai & styling baris total (yg paling bawah)
	$arr_font_style["font"]["bold"] = true;	
	$objPHPExcel->getActiveSheet()->getStyle( 'A'. ( $end_nomor + 1) .':O' . ( $end_nomor + 1 ) )->applyFromArray($arr_font_style);
	$objPHPExcel->getActiveSheet()->getStyle( 'A'. ( $end_nomor + 1) .':O' . ( $end_nomor + 1 ) )->applyFromArray($arr_bgcolor_style);
	$objPHPExcel->getActiveSheet()->mergeCells('A'. ( $end_nomor + 1) .':H' . ( $end_nomor + 1) );
	$objPHPExcel->getActiveSheet()
			->setCellValue("A" . ($end_nomor + 1), "TOTAL" )
			->setCellValue("I" . ($end_nomor + 1), "=sum(I". ($start_nomor + 1) .":I". $end_nomor .")" )
			->setCellValue("J" . ($end_nomor + 1), "=sum(J". ($start_nomor + 1) .":J". $end_nomor .")" )
			->setCellValue("K" . ($end_nomor + 1), "=sum(K". ($start_nomor + 1) .":K". $end_nomor .")" )
			->setCellValue("L" . ($end_nomor + 1), "=sum(L". ($start_nomor + 1) .":L". $end_nomor .")" )
			->setCellValue("M" . ($end_nomor + 1), "=sum(M". ($start_nomor + 1) .":M". $end_nomor .")" )
			->setCellValue("N" . ($end_nomor + 1), "=sum(N". ($start_nomor + 1) .":N". $end_nomor .")" )
			->setCellValue("O" . ($end_nomor + 1), "=sum(O". ($start_nomor + 1) .":O". $end_nomor .")" );
	$objPHPExcel->getActiveSheet()->getStyle('A' . ($end_nomor + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('I' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('J' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('K' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('L' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('M' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('N' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
	$objPHPExcel->getActiveSheet()->getStyle('O' . ($end_nomor + 1) )->getNumberFormat()->setFormatCode('#,###');
			
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="report-komisi-ringkas-'. $_REQUEST["area"] .'-'. $formatted_periode .'.xls"');
	$lokasi_simpan_file = "php://output";
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save( $lokasi_simpan_file );
	
	exit;

?>