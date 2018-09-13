<?

if( !isset($_REQUEST["c"]) ) goto Skip;

if( $_REQUEST["c"] == "simpan_data" ){
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
	
	$counter = 1;
	
	$sql = "";
	
	while( true == true ){
		
		if( !isset( $_POST["id_user_" . $counter ] ) ) break;
		
		if( $_POST["target_" . $counter ] != "" )
			$sql .= "update `user` set 
						nama_user = '". 	main::formatting_query_string( $_POST["nama_spg_" . $counter] ) . " | " . 
											main::formatting_query_string( str_replace(",", "", $_POST["target_" . $counter ] ) ) ."' 
					where id_user = '". main::formatting_query_string( $_POST["id_user_" . $counter] ) ."';";
		
		$counter++;
	}	

	if( $sql != "" ) mysqli_multi_query( $mysqlcon, $sql );
	
	header("location:target-spgm.php?area=". $_REQUEST["area"] );
	
}

Skip:

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

		number_format( $data_penjualan["target"] ),

		"<input type=\"text\" name=\"target_". $counter ."\" id=\"target_". $counter ."\" style=\"width:177px\" onfocus=\"fokusinput(this)\" onblur=\"unfokusinput(this); cek(this)\" onKeyPress=\"return numbersonly(this, event)\" /> 
		<input type=\"hidden\" name=\"nama_spg_". $counter ."\" value=\"". $data_penjualan["nama_spg"] ."\" />
		<input type=\"hidden\" name=\"id_user_". $counter ."\" value=\"". $data_penjualan["id_user"] ."\" />
		"
			
		);	
	@$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
}

if( @$s_data_penjualan =="" ) $s_data_penjualan = "<tr><td colspan='9' style='padding:17px; text-align:center'>Pilih Periode Penjualan</td></tr>";
			
?>