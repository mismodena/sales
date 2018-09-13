<?

if( !isset($_REQUEST["c"]) ) goto SkipCommand;


SkipCommand:

// ########################################## VIEW #####################################################

include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

if( @$_REQUEST["app"] == "1"){
	$sql = "select * from  stat_periode_header where periode=".$periodeid_terbaru." and area ='".@$_REQUEST["area"]."'";
	$rs_ = sql::execute($sql);
	if( sqlsrv_num_rows( $rs_ ) <= 0 ){
		$sql = "insert into stat_periode_header values (".$periodeid_terbaru.",'".@$_REQUEST["area"]."',1) ";
		sql::execute($sql);
		echo "<script>alert('Berhasil Verifikasi')</script>";
	}
}

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

// LOAD DATA KOMISI
$rs_komisi = komisi::load_data_komisi( 
					array(
						"a.periode" => array("=", $arr_selected_tpk["id"]),
						"a.area" => array("=", "'". $default_area . "'")
						) 
				);

$counter = 1;
$s_data_komisi = "";

while( $data_komisi = sqlsrv_fetch_array($rs_komisi) ){
	$arr_data_komisi = array(
		$counter,
		strtoupper($data_komisi["nama_user"]),
		str_replace(" | ", "<br />", strtoupper($data_komisi["store"])),
		number_format($data_komisi["komisi_fix"]),
		number_format($data_komisi["komisi_variabel"]),
		number_format($data_komisi["komisi_campaign"]),
		number_format($data_komisi["komisi_poin"]),
		number_format($data_komisi["komisi_spesial"]),
		number_format($data_komisi["komisi_total"]),
		number_format($data_komisi["pph"]),
		number_format($data_komisi["komisi_final"])
		);
	$s_data_komisi .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_komisi) . "</td></tr>";
	$counter++;
}

// cek tombol hitung ulang disabled ato tidak.. disabled klo (1) belum disetting item campaign oleh akunting, (2) periode komisi yg dipilih bukan periode komisi terbaru
$disable_hitung_ulang = false;
$sql = "select * from  stat_periode_header where periode=".$periodeid_terbaru." and area ='".$default_area."'";
$rs_ = sql::execute($sql);
if( sqlsrv_num_rows( $rs_ ) > 0 ) $disable_hitung_ulang = true;

if( $disable_hitung_ulang)
	@$script .= "
			disabled_tombol_transaksi();	
		";

SkipView:

?>