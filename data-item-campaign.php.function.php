<?

$arr_bg = array("merah", "kuning", "hijau", "biru");

if( !isset($_REQUEST["c"]) ) goto SkipCommand;

if( $_REQUEST["c"] =="cari_item" ){
	$rs_campaign = komisi::load_data_item_campaign( $_REQUEST["t_item"] );
	while( $data_campaign = sqlsrv_fetch_array( $rs_campaign ) )
		@$s_item_campaign .= "<div class=\"item-campaign ". $arr_bg[ rand(0,3) ] ."\"><span>" . $data_campaign["model"] . "</span>" . $data_campaign["fmtitemno"] . "</div>";
	echo @$s_item_campaign;	
}

SkipCommand:

// ########################################## VIEW #####################################################

$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
if( !is_array($data_periode) ) goto Skip;

$periode = /*$data_periode["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_periode["periode"]->format("m") ] . " " . $data_periode["periode"]->format("Y");

// data item campaign
$rs_campaign = komisi::load_data_item_campaign( @$_REQUEST["t_item"] );
while( $data_campaign = sqlsrv_fetch_array( $rs_campaign ) )
	@$s_item_campaign .= "<div class=\"item-campaign ". $arr_bg[ rand(0,3) ] ."\"><span>" . $data_campaign["model"] . "</span>" . $data_campaign["fmtitemno"] . "</div>";

$s_item_campaign = @$s_item_campaign != "" ? $s_item_campaign : "Tidak ada data ditemukan!";

Skip:

?>