<?

$arr_parameter = array();
//if( @$_REQUEST["periodeid"] != "" ) $arr_parameter["id"] = array("=", $_REQUEST["periodeid"]);
$rs_tpk =  komisi::load_data_periode($arr_parameter, array("periode" => "desc"));

$periodeid_terbaru = "";

$counter = 1;
$arr_selected_tpk = array();
$formatted_periode = "";

while( $data_tpk = sqlsrv_fetch_array( $rs_tpk ) ){
	$selected = "";
	if( @$_REQUEST["periodeid"] ==  $data_tpk["id"] ) {
		$selected = "selected";
		$arr_selected_tpk["id"] = $data_tpk["id"];
		$arr_selected_tpk["periode"] = $data_tpk["periode"];
		$arr_selected_tpk["dt"] = $data_tpk["dt"];
		$formatted_periode = /*$data_tpk["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_tpk["periode"]->format("m") ] . " " . $data_tpk["periode"]->format("Y");
	}else{
		if($counter <= 1) {
			$arr_selected_tpk["id"] = $data_tpk["id"];			
			$arr_selected_tpk["periode"] = $data_tpk["periode"];
			$arr_selected_tpk["dt"] = $data_tpk["dt"];			
		}
		if( $page == "index.php" || $page == "setting-m.php" )
		$formatted_periode = /*$data_tpk["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_tpk["periode"]->format("m") ] . " " . $data_tpk["periode"]->format("Y");
	}
	
	if($counter <= 1)	$periodeid_terbaru = $arr_selected_tpk["id"];
		
//	$formatted_periode = /*$data_tpk["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_tpk["periode"]->format("m") ] . " " . $data_tpk["periode"]->format("Y");
	$formatted_tpk = $data_tpk["dt"]->format("d") . " " . $arr_month[ (int)$data_tpk["dt"]->format("m") ] . " " . $data_tpk["dt"]->format("Y") . 
									" " . $data_tpk["dt"]->format("H:i:s");
	@$s_opsi_tpk .= "<option value=\"". $data_tpk["id"] ."\" ". $selected .">". $formatted_periode ." - Perhitungan Tgl ". $formatted_tpk ."</option>";
	@$s_opsi_set .= "<option value=\"". $data_tpk["id"] ."\" ". $selected .">". $formatted_periode ."</option>";
	$counter++;
}

if( count($arr_selected_tpk) <= 0 ) goto SkipView;
	
$periode = /*$arr_selected_tpk["periode"]->format("d") . " " . */$arr_month[ (int)$arr_selected_tpk["periode"]->format("m") ] . " " . $arr_selected_tpk["periode"]->format("Y");
$tanggal_perhitungan_komisi = $arr_selected_tpk["dt"]->format("d") . " " . $arr_month[ (int)$arr_selected_tpk["dt"]->format("m") ] . " " . $arr_selected_tpk["dt"]->format("Y") . 
								" " . $arr_selected_tpk["dt"]->format("H:i:s");

SkipView:
?>