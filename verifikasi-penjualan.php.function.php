<?

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


// LOAD DATA PENJUALAN SPG
$tanggal_sekarang = date(" Y-n-j");
$tanggal_satu = date(" Y-n-1");
$s_tanggal_awal_formatted = trim(@$_REQUEST["tanggal_awal"] != "" ? @$_REQUEST["tanggal_awal"] : $tanggal_satu );
$s_tanggal_akhir_formatted = trim(@$_REQUEST["tanggal_akhir"] != "" ? @$_REQUEST["tanggal_akhir"] : $tanggal_sekarang );

$arr_tanggal_awal = explode("-", $s_tanggal_awal_formatted);
$s_tanggal_awal = $arr_tanggal_awal[2] . " " . $arr_month[ (int)$arr_tanggal_awal[1] ] . " " . $arr_tanggal_awal[0];

$arr_tanggal_akhir = explode("-", $s_tanggal_akhir_formatted);
$s_tanggal_akhir = $arr_tanggal_akhir[2] . " " . $arr_month[ (int)$arr_tanggal_akhir[1] ] . " " . $arr_tanggal_akhir[0];

$rs_penjualan = penjualan::data_penjualan
			( 
			array("c.area", $default_area), 
			$s_tanggal_awal_formatted, 
			$s_tanggal_akhir_formatted
			);
			
$counter = 1;
while( $data_penjualan = sqlsrv_fetch_array( $rs_penjualan ) ){	
	$arr_data_penjualan = array(
		$counter,
		strtoupper($data_penjualan["nama_spg"]),
		strtoupper($data_penjualan["store"]),
		$data_penjualan["kelas"],
		$data_penjualan["level_diskon"],
		number_format( $data_penjualan["target"] ),
		number_format( $data_penjualan["total_penjualan"] ),
		( $data_penjualan["target"] > 0 ? round( $data_penjualan["total_penjualan"] / $data_penjualan["target"], 2) * 100 : 0 ),
		"<a href=\"verifikasi-penjualan-detail.php?area=". $default_area ."&user_id=". $data_penjualan["id_user"] ."&tanggal_awal=". $s_tanggal_awal_formatted ."&tanggal_akhir=". $s_tanggal_akhir_formatted ."\">DETAIL</a> | 
		<a target=\"_blank\" href=\"download_kuitansi.php?user_id=". $data_penjualan["id_user"] ."&nama_spg=". $data_penjualan["nama_spg"] ."&tanggal_awal=". $s_tanggal_awal_formatted ."&tanggal_akhir=". $s_tanggal_akhir_formatted ."\">DOWNLOAD KUITANSI</a>"
	);	
	@$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
}

if( @$s_data_penjualan =="" ) $s_data_penjualan = "<tr><td colspan='9' style='padding:17px; text-align:center'>Pilih Periode Penjualan</td></tr>";

?>
