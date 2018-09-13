<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] == "simpan_data" ){

	$counter = 1;
	
	$sql = "";
	
	while( true == true ){
		
		if( !isset( $_POST["kode_" . $counter ] ) ) break;
		
		// if( $_POST["tarif_" . $counter ] != "" && $_POST["tarif_" . $counter ] != "0" ) $tarif = $_POST["tarif_" . $counter ];
		// else $tarif = $_POST["tarif_old_" . $counter ];
		
		$tarif = $_POST["tarif_" . $counter ];
		
		if( $_POST["tarif_" . $counter ] != "" && $_POST["tarif_" . $counter ] != "0" )
		// $sql .= "insert into tarif_dealer_app (tarif_id,tarif,createDate,status) values (
				// ".$_REQUEST["id_" . $counter].", ".main::formatting_query_string( str_replace(",", "", $tarif ) ).", '".date('Y-m-d h:m:s')."',0);";
					
			$sql .= "update tarif_dealer set 
						tarif = ".main::formatting_query_string( str_replace(",", "", $_POST["tarif_" . $counter ] ) ) ." 
						where id = ".$_POST["id_" . $counter ].";";
		
		$counter++;
	}	

	if( $sql != "" ) sql::execute($sql);
	
	header("location:tarif-m.php?area=". $_REQUEST["area"] );
	
}

Skip:
include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

// LOAD DATA AREA/CABANG
$rs_area = komisi::load_data_area();
$counter = 1;

$default_area = @$_REQUEST["area"] != "" ? $_REQUEST["area"] : @$arr_session_area[0];

while( $data_area = sqlsrv_fetch_array($rs_area) ){
	
	if( count( $arr_session_area ) > 0 ){
		if( !in_array($data_area["area"], $arr_session_area ) ) continue;
	}
	
	$selected = "";
	if( @$_REQUEST["area"] == $data_area["area"] ) $selected = "selected";
	if( @$_REQUEST["area"] == "" && $counter == 1 ) $default_area = $data_area["area"];
	@$s_area .= "<option value=\"". $data_area["area"] ."\" ". $selected .">". $data_area["area"] ."</option>";
	$counter++;
}

// LOAD DATA TARGET PENJUALAN SPG
$tanggal_satu = date(" Y-n-1");
$s_tanggal_awal_formatted = trim(@$_REQUEST["tanggal_awal"] != "" ? @$_REQUEST["tanggal_awal"] : $tanggal_satu );
$s_tanggal_akhir_formatted = trim(@$_REQUEST["tanggal_akhir"] != "" ? @$_REQUEST["tanggal_akhir"] : $tanggal_satu );

$rs_penjualan = komisi::load_data_store
			( 
			$default_area, $periodeid_terbaru
			);

$counter = 1;
$dis = "";
while( $data_penjualan = sqlsrv_fetch_array( $rs_penjualan ) ){	
	$input="";
	if(!empty($data_penjualan["tarif_b"])) {
		$dis = "disabled";
		$input=number_format($data_penjualan["tarif_b"]);
	}
	
	$arr_data_penjualan = array(
		$counter,
		strtoupper($data_penjualan["kode"]),
		strtoupper($data_penjualan["store"]),
		number_format( $data_penjualan["tarif"] ),

		"<input type=\"text\" name=\"tarif_". $counter ."\" id=\"tarif_". $counter ."\" value=\"\" style=\"width:177px;\" onfocus=\"fokusinput(this)\" onblur=\"unfokusinput(this); cek(this)\" onKeyPress=\"return numbersonly(this, event)\" /> 
		<input type=\"hidden\" name=\"kode_". $counter ."\" value=\"". $data_penjualan["kode"] ."\" />
		<input type=\"hidden\" name=\"id_". $counter ."\" value=\"". $data_penjualan["id"] ."\" />
		<input type=\"hidden\" name=\"tarif_old_". $counter ."\" value=\"". number_format( $data_penjualan["tarif"] ) ."\" />
		"
			
		);	
	$dis = "";
	@$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
}

@$s_data_penjualan .= "<input type=\"hidden\" name=\"periodeid\" id=\"periodeid\" value=\"". $periodeid_terbaru ."\" />";

SkipView:
		
?>