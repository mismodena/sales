<?

if( !isset($_REQUEST["c"]) ) goto SkipCommand;

if( $_REQUEST["c"] == "simpan_data" ){
	$sql = ""; $counter = 1;
	$arr_src = array("#id_user#", "#periode#", "#id_model#", "#nama_model#", "#qty#", "#harga#", "#id_transaksi#");
	while( true == true ){
		if( !isset( $_REQUEST["item_" . $counter] ) ) break;
		
		if( $_REQUEST["transaksi_" . $counter] != "" ){
			
			if( $_REQUEST["idmodel_" . $counter] == "" ||  $_REQUEST["qty_" . $counter] == "" || $_REQUEST["harga_" . $counter] =="" )
				$sql .= "delete from penjualan_detail_ringkas 
					where id_user = '#id_user#' and periode = '#periode#' and id_transaksi ='#id_transaksi#' ;";
			else
				$sql .= "update penjualan_detail_ringkas set id_model = '#id_model#', harga = '#harga#', qty = '#qty#', nama_model = '#nama_model#' 
					where id_user = '#id_user#' and periode = '#periode#' and id_transaksi ='#id_transaksi#' ; ";
					
		}else
			
			$sql .= "insert into penjualan_detail_ringkas(id_user, periode, id_model, nama_model, qty, harga) 
					values('#id_user#', '#periode#', '#id_model#', '#nama_model#', '#qty#', '#harga#'); ";
		
		$arr_rpl = array(
					$_REQUEST["user_id"], $_REQUEST["periodeid"], 
					$_REQUEST["idmodel_" . $counter], 
					$_REQUEST["item_" . $counter], 
					$_REQUEST["qty_" . $counter], 
					str_replace(",", "", $_REQUEST["harga_" . $counter]), 
					$_REQUEST["transaksi_" . $counter]
					);
		
		$sql = str_replace($arr_src, $arr_rpl, $sql);
		
		$counter++;
	}
	
	$j = sql::execute( $sql ) or die(print_r(sqlsrv_errors() + array("statement" => $sql) ));
	
	if( isset($_REQUEST["kembali"]) ) header("location:index.php?periodeid=". $_REQUEST["periodeid"] ."&area=" . $_REQUEST["area"]);
	
	if( isset($_REQUEST["ubah_tampilan"]) ) header("location:penjualan.php?v=". $_REQUEST["ubah_tampilan"] ."&user_id=". $_REQUEST["user_id"] ."&periodeid=". $_REQUEST["periodeid"] ."&area=" . $_REQUEST["area"]);
	
}

SkipCommand:

// ########################################## FUNGSI #####################################################

include "penjualan.view.function.php";

// ########################################## VIEW #####################################################

include "periode.function.php";
if( !isset($periode) || !isset($tanggal_perhitungan_komisi) ) goto SkipView;

// MODE TAMPILAN RINGKAS | DETAIL
$mode_tampilan = array("sekarang" => "ringkas", "lain" => "detail");
if( @$_REQUEST["v"] == "detail" ) $mode_tampilan = array("sekarang" => @$_REQUEST["v"], "lain" => "ringkas");

// LOAD DATA KOMISI
$rs_komisi = komisi::load_data_komisi( 
					array(
						"a.periode" => array("=", $_REQUEST["periodeid"]),
						"a.id_user" => array("=", "'". $_REQUEST["user_id"] . "'")
						) 
				);
$data_komisi = sqlsrv_fetch_array( $rs_komisi );				

// LOAD DAFTAR ITEM ANDROID
$rs_daftar_item = komisi::load_data_item();
while( $daftar_item = sqlsrv_fetch_array( $rs_daftar_item ) ){
	$arr_daftar_item[] = $daftar_item["nama_model"];
	$arr_harga_item[] =$daftar_item["unitprice"] * (100 - $data_komisi["level_diskon"]) / 100 ;
	$arr_idmodel_item[] = $daftar_item["id_model"];
	$arr_item_info[] = array(
						"nama_model" => $daftar_item["nama_model"], 
						"harga" =>$daftar_item["unitprice"] * (100 - $data_komisi["level_diskon"]) / 100,
						"id_model" => $daftar_item["id_model"]
						);
	$arr_opsi_selectbox_item[ $daftar_item["nama_model"] ] = $daftar_item["nama_model"];
}
$json_daftar_item = json_encode($arr_daftar_item);
$json_item_info = json_encode($arr_item_info);

// LOAD DATA PENJUALAN RINGKAS | DETAIL
include "penjualan.". $mode_tampilan["sekarang"] .".function.php";

SkipView:

?>