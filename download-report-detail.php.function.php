<?

function penjualan_detail_header( $excel_sheet, $arr_data_komisi ){
	
	$GLOBALS["arr_font_style"]["font"]["bold"] = true;	
	
	$arr_header = array(1 => "nama", "periode", "dealer", "kelas");
	$arr_nilai = array(1 => $arr_data_komisi["nama_user"], $GLOBALS["formatted_periode"], $arr_data_komisi["store"], $arr_data_komisi["kelas"] );
	foreach($arr_header as $index => $label){
		$excel_sheet->setCellValue( "A" . $index, strtoupper($label) );
		$excel_sheet->getStyle( "A" . $index )->applyFromArray( $GLOBALS["arr_font_style"] );
		$excel_sheet->setCellValue( "B" . $index, strtoupper( $arr_nilai[$index] ) );
		$excel_sheet->getStyle( "B" . $index )->applyFromArray( $GLOBALS["arr_font_style"] );
	}
	
	$arr_header = array(1 => "Target Rupiah", "Realisasi Rupiah", "Persentase Realisasi", "Komisi Fix", "komisi", "komisi campaign", "komisi poin", "komisi spesial campaign", "komisi total");
	$arr_nilai = array(1 => $arr_data_komisi["target"], $arr_data_komisi["realisasi_android"], 
						($arr_data_komisi["target"] > 0 ? round($arr_data_komisi["realisasi_android"] / $arr_data_komisi["target"], 2) * 100 : 0), 
						$arr_data_komisi["komisi_fix"], $arr_data_komisi["komisi_variabel"], $arr_data_komisi["komisi_campaign"], $arr_data_komisi["komisi_poin"], $arr_data_komisi["komisi_spesial"], $arr_data_komisi["komisi_total"]);
	foreach($arr_header as $index => $label){
		$excel_sheet->setCellValue( "C" . $index, strtoupper($label) );
		$excel_sheet->getStyle( "C" . $index )->applyFromArray( $GLOBALS["arr_font_style"] );
		$excel_sheet->setCellValue( "D" . $index, strtoupper( $arr_nilai[$index] ) );
		$excel_sheet->getStyle( "D" . $index )->applyFromArray( $GLOBALS["arr_font_style"] );
		$excel_sheet->getStyle( "D" . $index )->getNumberFormat()->setFormatCode('#,###');
	}
	
	$start_tabel = count( $arr_header ) + 2;
	$arr_header_tabel = array("A" => "ITEM", "B" => "Jumlah", "C" => "harga", "D" => "campaign");
	foreach($arr_header_tabel as $index => $label){
		$excel_sheet->setCellValue( $index . $start_tabel, strtoupper($label) );
		$excel_sheet->getStyle( $index . $start_tabel )->applyFromArray( $GLOBALS["arr_font_style"] );
		$excel_sheet->getStyle( $index . $start_tabel )->applyFromArray( $GLOBALS["arr_bgcolor_style"] );
		$excel_sheet->getStyle( $index . $start_tabel )->applyFromArray( $GLOBALS["arr_border_style"] );
	}
	
	return $start_tabel + 1;
}

function penjualan_detail_isi( $excel_sheet, $id_user, $start_tabel ){
	
	$arr_par = array(
		"a.id_user" => array("=", "'". main::formatting_query_string( $id_user ) ."'"),
		"a.periode" => array("=", "'". main::formatting_query_string( $_REQUEST["periodeid"] ) ."'" )
	);
	$rs_penjualan_ringkas = komisi::load_data_penjualan_rekap( $arr_par );
	
	$counter = $start_tabel;
	while( $penjualan_ringkas = sqlsrv_fetch_array( $rs_penjualan_ringkas ) ){
		$excel_sheet
			->setCellValue( "A" . $counter, $penjualan_ringkas["nama_model_singkat"] )
			->setCellValue( "B" . $counter, $penjualan_ringkas["qty"] )
			->setCellValue( "C" . $counter, $penjualan_ringkas["harga"] * $penjualan_ringkas["qty"] )
			->setCellValue( "D" . $counter, $penjualan_ringkas["komisi_campaign"] )
			->setCellValue( "E" . $counter, ( $penjualan_ringkas["komisi_campaign"] > 0 ? "campaign" : "" ) )
			->setCellValue( "F" . $counter, ( $penjualan_ringkas["komisi_campaign"] > 0 ? $penjualan_ringkas["persentase_komisi"] : "" ) );
			
		$GLOBALS["arr_font_style"]["font"]["bold"] = false;	
		$excel_sheet->getStyle( "A" . $counter . ":D" . $counter )->applyFromArray( $GLOBALS["arr_font_style"] );
		$excel_sheet->getStyle( "A" . $counter . ":D" . $counter )->applyFromArray( $GLOBALS["arr_border_style"] );	
		$excel_sheet->getStyle( "C" . $counter . ":D" . $counter )->getNumberFormat()->setFormatCode('#,###');
		
		$counter++;
	}

	// baris data total
	$excel_sheet->setCellValue( "A" . ($counter + 1), "TOTAL" );
	$excel_sheet->setCellValue( "B" . ($counter + 1), "=sum(B". $start_tabel .":B" . $counter . ")" );
	$excel_sheet->setCellValue( "C" . ($counter + 1), "=sum(C". $start_tabel .":C" . $counter . ")" );
	$excel_sheet->setCellValue( "D" . ($counter + 1), "=sum(D". $start_tabel .":D" . $counter . ")" );	
	
	$GLOBALS["arr_font_style"]["font"]["bold"] = true;	
	$excel_sheet->getStyle( "A" . ($counter +1 ) . ":D" . ($counter + 1) )->applyFromArray( $GLOBALS["arr_font_style"] );
	$excel_sheet->getStyle( "A" . ($counter +1 ) . ":D" . ($counter + 1) )->applyFromArray( $GLOBALS["arr_bgcolor_style"] );
	$excel_sheet->getStyle( "A" . ($counter +1 ) . ":D" . ($counter + 1) )->applyFromArray( $GLOBALS["arr_border_style"] );
	$excel_sheet->getStyle( "A" . ($counter + 1) . ":D" . ($counter + 1) )->getNumberFormat()->setFormatCode('#,###');
	
	$excel_sheet->mergeCells("A" . ($counter +2 ) . ":B" . ($counter +2 ) );
	$excel_sheet->setCellValue("A" . ($counter +2 ), "Realisasi Campaign" );
	$excel_sheet->setCellValue("C" . ($counter +2 ), "=SUMIF(E". $start_tabel .":E" . $counter . ",\"campaign\",C". $start_tabel .":C" . $counter . ")/1.1" );
	
	$excel_sheet->getStyle( "A" . ($counter +2 ) . ":C" . ($counter + 2) )->applyFromArray( $GLOBALS["arr_font_style"] );
	$excel_sheet->getStyle( "A" . ($counter +2 ) . ":C" . ($counter + 2) )->applyFromArray( $GLOBALS["arr_bgcolor_style"] );
	$excel_sheet->getStyle( "A" . ($counter +2 ) . ":C" . ($counter + 2) )->applyFromArray( $GLOBALS["arr_border_style"] );
	$excel_sheet->getStyle( "C" . ($counter + 2) )->getNumberFormat()->setFormatCode('#,###');
}

?>