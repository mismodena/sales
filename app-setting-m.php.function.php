<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] == "simpan_data" ){

	$counter = 1;
	
	$sql = "";
	
	// while( true == true ){
		
		//if( !isset( $_POST["kode_" . $counter ] ) ) break;
		$jk = $_POST["hide_jk_" . $counter ];
		$hk = $_POST["hide_hk_" . $counter ];
		if( $_POST["jk_" . $counter ] != "" && $_POST["jk_" . $counter ] != "0" )  $jk = $_POST["jk_" . $counter ];
		if( $_POST["hk_" . $counter ] != "" && $_POST["hk_" . $counter ] != "0" )  $hk = $_POST["hk_" . $counter ];
		
			$sql .= "insert into setting_max_app ([periode],[max_jk],[max_hk],[createDate],[status]) values
					(".$_REQUEST["periodeid"].", ".$jk.", ".$hk.", '".date('Y-m-d h:m:s')."',0);";
			// $sql .= "update setting_max set max_jk = ".$_POST["jk_" . $counter]. "
						// where periode = ".$_REQUEST["periodeid"].";";
					
			// $sql .= "update setting_max set max_hk = ".$_POST["hk_" . $counter]. "
						// where periode = ".$_REQUEST["periodeid"].";";
		
		// $counter++;
	// }	

	if( $sql != "" ) sql::execute($sql);
	//echo $_POST["jk_1" ];
	header("location:setting-m.php?periodeid=". $_REQUEST["periodeid"] );
	
}

Skip:
include "app-setting-m.view.function.php";

include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

//$default_periode = @$_REQUEST["periodeid"] != "" ? $_REQUEST["periodeid"] : $arr_selected_tpk["id"];

$sql = "select a.max_jk, a.max_hk, b.max_jk jk_a, b.max_hk hk_a from setting_max a
		left join setting_max_app b on a.periode = b.periode and b.status = 0
		where a.periode = ".$arr_selected_tpk["id"];
$rs_penjualan = sql::execute($sql);
$counter=1;
$pengajuan = false;
while( $data_penjualan = sqlsrv_fetch_array( $rs_penjualan ) ){	
	$arr_data_penjualan = array(
		$data_penjualan["max_jk"],
		$data_penjualan["max_hk"].
		"<input type=\"hidden\" name=\"hide_jk_". $counter."\" id=\"hide_jk_". $counter."\" value=\"". $data_penjualan["max_jk"] ."\" />".
		"<input type=\"hidden\" name=\"hide_hk_". $counter."\" id=\"hide_hk_". $counter."\" value=\"". $data_penjualan["max_hk"] ."\" />",
		empty($data_penjualan["jk_a"])?isian_jk($counter, ""):isian_jk_dis($counter, $data_penjualan["jk_a"]),
		empty($data_penjualan["hk_a"])?isian_hk($counter, ""):isian_hk_dis($counter, $data_penjualan["hk_a"])
		);	
	@$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	
	if(!empty($data_penjualan["jk_a"])) $pengajuan = true;
}

@$s_data_penjualan .= "<input type=\"hidden\" name=\"periodeid\" id=\"periodeid\" value=\"". $arr_selected_tpk["id"] ."\" />";

$disable_hitung_ulang = false;
if(@$_REQUEST["periodeid"] != "" && @$_REQUEST["periodeid"] != $periodeid_terbaru) 
	$disable_hitung_ulang = true;

if( $disable_hitung_ulang or $pengajuan )
	@$script .= "
			disabled_tombol_transaksi();	
		";

SkipView:	
?>