<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] == "simpan_data" ){
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
	
	$counter = 1;
	
	$sql = "";
	
	while( true == true ){
		
		if( !isset( $_POST["id_user_" . $counter ] ) ) break;
		
			$sql .= "update absensi set 
						jam_kerja = ". $_POST["jk_" . $counter] .",
						hari_kerja = ". $_POST["hk_" . $counter] .",
						training = ". $_POST["tr_" . $counter] .",
						poin_jk = ". $_POST["poin_jk_" . $counter] .",
						poin_hk = ". $_POST["poin_hk_" . $counter] .",
						poin_tr = ". $_POST["poin_tr_" . $counter] .",
						poin_total = ". $_POST["poin_total_" . $counter] ."
					where id_user = ". $_POST["id_user_" . $counter] ."
					and periode = ". $_POST["periode"] .";
					update komisi set 
						komisi_poin = ". main::formatting_query_string( str_replace(",", "", $_POST["komisi_" . $counter ] ) ) ." 
					where id_user = ". $_POST["id_user_" . $counter] ."
					and periode = ". $_POST["periode"] .";";
		
		$counter++;
	}	

	if( $sql != "" ) {
		$sql .= "exec usp_hitung_komisi_poin '". $_REQUEST["area"] ."' ;";
		sql::execute($sql);
	}
	
	header("location:data-upload-absen.php?area=". $_REQUEST["area"] );
	
}

Skip:
//view
include "data-upload-absen.view.function.php";

//period
include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
$periode = /*$data_periode["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_periode["periode"]->format("m") ] . " " . $data_periode["periode"]->format("Y");

$data_max =  sqlsrv_fetch_array( sql::execute("select * from setting_max where periode = ".$periodeid_terbaru) );


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

// LOAD DATA komisi
$rs_komisi = komisi::load_data_komisi_poin( 
					array(
						"a.periode" => array("=", $arr_selected_tpk["id"]),
						"a.tipe_promoter" => array("=", "'MITRA'"),
						"a.area" => array("=", "'". $default_area . "'")
						) 
				);

$counter = 1;
$s_data_komisi = "";

while( $data_komisi = sqlsrv_fetch_array($rs_komisi) ){
	$arr_data_komisi = array(
		$counter,
		strtoupper($data_komisi["nama_user"]),
		strtoupper($data_komisi["toko"]),
		$data_komisi["jam_kerja"],
		$data_komisi["hari_kerja"],
		$data_komisi["training"],
		//isian_jk($counter, $data_komisi["jam_kerja"]),
		//isian_hk($counter, $data_komisi["hari_kerja"]),
		//isian_tr($counter, $data_komisi["training"]),
		isian_poin_jk($counter, $data_komisi["poin_jk"]),
		isian_poin_hk($counter, $data_komisi["poin_hk"]),
		isian_poin_tr($counter, $data_komisi["poin_tr"]),
		isian_poin_omzet($counter, $data_komisi["poin_omzet"]),
		isian_poin_total($counter, $data_komisi["poin_total"]),
		isian_komisi($counter, $data_komisi["komisi_poin"]),
		number_format($data_komisi["komisi_spesial"]),
		number_format($data_komisi["potongan"]).
		"<input type=\"hidden\" name=\"id_user_". $counter ."\" value=\"". $data_komisi["id_user"] ."\" />
		<input type=\"hidden\" id=\"tarif_". $counter ."\" value=\"". $data_komisi["tarif"] ."\" />"
		
		);
	$s_data_komisi .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_komisi) . "</td></tr>";
	$counter++;
}

$s_data_komisi .= "<input type=\"hidden\" name=\"periode\" id=\"periode\" value=\"". $arr_selected_tpk["id"] ."\" />";
$s_data_komisi .= "<input type=\"hidden\" name=\"max_jk\" id=\"max_jk\" value=\"". $data_max["max_jk"] ."\" />";
$s_data_komisi .= "<input type=\"hidden\" name=\"max_hk\" id=\"max_hk\" value=\"". $data_max["max_hk"] ."\" />";

SkipView:
			
?>