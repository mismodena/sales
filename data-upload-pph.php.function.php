<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] == "simpan_data" ){
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
	
	$counter = 1;
	
	$sql = "";
	
	while( true == true ){
		
		if( !isset( $_POST["id_user_" . $counter ] ) ) break;
		
		if( $_POST["pph_" . $counter ] != "" )
			$sql .= "update komisi set 
						pph = ". main::formatting_query_string( str_replace(",", "", $_POST["pph_" . $counter ] ) ) ."
					where id_user = ". $_POST["id_user_" . $counter] ."
					and periode = ". $_POST["periode"] .";";
		
		$counter++;
	}	

	if( $sql != "" ) {
		sql::execute($sql);
	}
	
	header("location:data-upload-pph.php?area=". $_REQUEST["area"] );
	
}

Skip:
//view
include "data-upload-pph.view.function.php";

//period
include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
$periode = /*$data_periode["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_periode["periode"]->format("m") ] . " " . $data_periode["periode"]->format("Y");

$data_max =  sqlsrv_fetch_array( sql::execute("select * from setting_max where periode = ".$periodeid_terbaru) );


// LOAD DATA AREA/CABANG
$rs_area = komisi::load_data_area();
//$rs_area = komisi::load_data_cabang();
$counter = 1;

$default_area = @$_REQUEST["area"] != "" ? $_REQUEST["area"] : @$arr_session_area[0];

while( $data_area = sqlsrv_fetch_array($rs_area) ){
	
	if( count( $arr_session_area ) > 0 ){
		if( !in_array($data_area["area"], $arr_session_area ) ) continue;
	}
	
	$selected = "";
	if( @$_REQUEST["area"] == $data_area["area"] ) $selected = "selected";
	if( @$_REQUEST["area"] == "" && $counter == 1 ) $default_area = $data_area["area"];
	@$s_area .= "<option value=\"". $data_area["area"] ."\" ". $selected .">". strtoupper($data_area["area"]) ."</option>";
	$counter++;
}

// LOAD DATA komisi
$rs_komisi = komisi::load_data_komisi_poin( 
					array(
						"a.periode" => array("=", $arr_selected_tpk["id"]),
						"a.area" => array("=", "'". $default_area . "'"),
						//"a.pph" => array(" ", "IS NOT NULL")
						"ab.poin_total" => array(">", 0)
						) 
				);

$counter = 1;
$s_data_komisi = "";

while( $data_komisi = sqlsrv_fetch_array($rs_komisi) ){
	$arr_data_komisi = array(
		$counter,
		strtoupper($data_komisi["nama_user"]),
		strtoupper($data_komisi["store"]),
		strtoupper($data_komisi["npwp"]),
		number_format($data_komisi["komisi_total"]),
		number_format($data_komisi["pph"]),
		//isian_total_komisi($counter, $data_komisi["komisi_total"]),
		//isian_pph($counter, $data_komisi["pph"]),
		isian_total_final($counter, $data_komisi["komisi_final"])."<input type=\"hidden\" name=\"id_user_". $counter ."\" value=\"". $data_komisi["id_user"] ."\" />"
		
		// "<input type=\"text\" name=\"tarif_". $counter ."\" id=\"pph_". $counter ."\" value=\"".number_format( $data_komisi["pph"] )."\" style=\"width:177px;text-align: right;\" onfocus=\"fokusinput(this)\" onblur=\"unfokusinput(this); cek(this)\" onKeyPress=\"return numbersonly(this, event)\" /> 
		// <input type=\"hidden\" name=\"id_user_". $counter ."\" value=\"". $data_komisi["id_user"] ."\" />",
		// number_format( $data_komisi["komisi_fimal"] )
		
		);
	$s_data_komisi .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_komisi) . "</td></tr>";
	$counter++;
}

$s_data_komisi .= "<input type=\"hidden\" name=\"periode\" value=\"". $arr_selected_tpk["id"] ."\" />";
$s_data_komisi .= "<input type=\"hidden\" name=\"max_jk\" id=\"max_jk\" value=\"". $data_max["max_jk"] ."\" />";
$s_data_komisi .= "<input type=\"hidden\" name=\"max_hk\" id=\"max_hk\" value=\"". $data_max["max_hk"] ."\" />";

SkipView:
			
?>