<?

if( !isset($_REQUEST["c"]) ) goto SkipCommand;


SkipCommand:

// ########################################## VIEW #####################################################

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
		strtoupper($data_komisi["alamat_user"]),
		str_replace(" | ", "<br />", strtoupper($data_komisi["store"])),
		//strtoupper($data_komisi["kelas"]),
		number_format($data_komisi["target"]),
		number_format($data_komisi["realisasi_android"]),
		$data_komisi["target"] > 0 ? round($data_komisi["realisasi_android"] / $data_komisi["target"], 2) * 100 : 0,
		number_format($data_komisi["komisi_fix"]),
		number_format($data_komisi["komisi_variabel"]),
		number_format($data_komisi["komisi_campaign"]),
		number_format($data_komisi["komisi_poin"]),
		number_format($data_komisi["komisi_spesial"]),
		number_format($data_komisi["komisi_total"]),
		"<a href=\"penjualan.php?user_id=". $data_komisi["id_user"] ."&periodeid=". $data_komisi["periode"] ."&area=". $data_komisi["area"] ."\">DETAIL</a>"
		);
	$s_data_komisi .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_komisi) . "</td></tr>";
	$counter++;
}

// cek tombol hitung ulang disabled ato tidak.. disabled klo (1) belum disetting item campaign oleh akunting, (2) periode komisi yg dipilih bukan periode komisi terbaru
$disable_hitung_ulang = false;
$rs_item_campaign = komisi::load_data_item_campaign();
if( sqlsrv_num_rows( $rs_item_campaign ) <= 0 || (@$_REQUEST["periodeid"] != "" && @$_REQUEST["periodeid"] != $periodeid_terbaru) )
	$disable_hitung_ulang = true;

if( $disable_hitung_ulang )
	@$script .= "
			/*$(document).ready(function(){*/
			document.getElementById('label_hitung_ulang').innerHTML = 'Hitung ulang komisi tidak diaktifkan karena data item campaign bulanan belum disetting oleh Akunting atau periode komisi yang dipilih bukan periode komisi yang terbaru!';
			document.getElementById('b_itung').setAttribute('style', 'display:none');
			/*})*/
		";

SkipView:

?>