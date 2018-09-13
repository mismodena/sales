<?

if( !isset($_REQUEST["c"]) ) goto SkipCommand;

if( $_REQUEST["c"] == "simpan_data" ){
	
	$sql = "delete from persentase_komisi_item_campaign;";
	
	$counter = 1;
	while( true === true ){
		
		if( !isset( $_POST["item_" . $counter] ) ) break;
		
		if( $_POST["item_" . $counter] != "" && $_POST["persentase_" . $counter] != "" )
			$sql .= "insert into persentase_komisi_item_campaign(item, persentase_komisi) 
				values('". main::formatting_query_string($_POST["item_" . $counter]) ."', '". main::formatting_query_string($_POST["persentase_" . $counter]) ."');";
		
		$counter++;
	}
	
	$rs = sql::execute( $sql );
	
}

SkipCommand:

include "penjualan.view.function.php";

$rs = konfigurasi_komisi::persentase_komisi_campaign();
while( $konfigurasi = sqlsrv_fetch_array( $rs ) ){
	$arr_data = array(
			
			"<td>" .  $konfigurasi["nomor"] . "</td>",
			"<td>" .  isian_teks("item", $konfigurasi["nomor"], $konfigurasi["item"]) . "</td>",
			"<td>" .  isian_teks("persentase", $konfigurasi["nomor"], $konfigurasi["persentase_komisi"]) . "</td>",
			
		);
	
	@$s_konfigurasi .= "<tr>". implode("", $arr_data) ."</tr>";
}

?>