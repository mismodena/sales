<?

set_time_limit(100);

$_REQUEST["user_id"] = $_SESSION["user_login"];

if( !isset($_REQUEST["c"]) ) goto SkipCommand;

if( $_REQUEST["c"] =="simpan_data" ){	
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
		
	// simpan data penjualan
	$counter = 1;	
	$sql_update_delete = "";
	
	while( true === true ){

		if( !isset( $_POST["transaksi_" . $counter] ) ) break;
		
		@list( $id_penjualan, $id_detail_penjualan ) = explode("|", $_POST["transaksi_" . $counter]);
				
		if( $id_penjualan != "" && $id_detail_penjualan != "" ){
			
			// hapus
			if( $_POST["qty_" . $counter] <= 0 || $_POST["qty_" . $counter] == "" )
				$sql_update_delete .= "delete  from penjualan_detail where id_penjualan = '". main::formatting_query_string( $id_penjualan ) ."' and 
					id_detail_penjualan = '". main::formatting_query_string( $id_detail_penjualan ) ."';";
			
			// update
			else
				$sql_update_delete .= "update penjualan_detail set 
					id_model = '". main::formatting_query_string( $_POST["item_" . $counter] ) ."', 
						harga = '". main::formatting_query_string( str_replace(",", "", $_POST["harga_" . $counter] ) ) ."', 
						qty = '". main::formatting_query_string( $_POST["qty_" . $counter] ) ."' 
					where 
					id_penjualan = '". main::formatting_query_string( $id_penjualan ) ."' and 
					id_detail_penjualan = '". main::formatting_query_string( $id_detail_penjualan ) ."';";
			
		// insert
		}else{
			
			if( $_POST["qty_" . $counter] <= 0 || $_POST["qty_" . $counter] == "" ) goto Skip;
			
			$sql ="insert into penjualan(faktur, id_sales, nama_customer, tanggal)
				values(
				'". main::formatting_query_string( $_POST["faktur_" . $counter] ) ."', 
				'". main::formatting_query_string( $_POST["user_id"] ) ."', 
				'". main::formatting_query_string( $_POST["namakonsumen_" . $counter ] ) ."', 
				'". main::formatting_query_string( $_POST["tglf_" . $counter] ) ."');";
			mysqli_query( $mysqlcon, $sql );
			
			$id = mysqli_fetch_array( mysqli_query( $mysqlcon, "select LAST_INSERT_ID() id_penjualan" ));
			
			$sql = "insert into penjualan_detail(id_penjualan, id_model, harga, qty,keterangan)
				values(
				'". main::formatting_query_string( $id["id_penjualan"] ) ."', 
				'". main::formatting_query_string( $_POST["item_" . $counter] ) ."', 
				'". main::formatting_query_string( str_replace(",", "", $_POST["harga_" . $counter] ) ) ."', 
				'". main::formatting_query_string( $_POST["qty_" . $counter] ) ."',
				'". main::formatting_query_string( $_POST["keterangan_" . $counter] ) ."');";
			mysqli_query( $mysqlcon, $sql );
			
		}Skip:
		$counter++;
		
	}
	
	if( $sql_update_delete != "" ) mysqli_multi_query( $mysqlcon, $sql_update_delete ) or die("error update delete");
	
	if( isset($_REQUEST["kembali"]) ) header("'location:sales-monitoring.php");
	
	header("location:spg-verifikasi-penjualan-detail.php?tanggal_awal=". $_REQUEST["t_tanggal_awal"] ."&tanggal_akhir=". $_REQUEST["t_tanggal_akhir"]);
}

SkipCommand:

// ########################################## VIEW #####################################################

include "penjualan.view.function.php";

// HEADER PENJUALAN
$tanggal_sekarang = date(" Y-n-j");
$tanggal_satu = date(" Y-n-1");
$s_tanggal_awal_formatted = trim(@$_REQUEST["tanggal_awal"] != "" ? @$_REQUEST["tanggal_awal"] : $tanggal_satu );
$s_tanggal_akhir_formatted = trim(@$_REQUEST["tanggal_akhir"] != "" ? @$_REQUEST["tanggal_akhir"] : $tanggal_sekarang );

$arr_tanggal_awal = explode("-", $s_tanggal_awal_formatted);
$s_tanggal_awal = $arr_tanggal_awal[2] . " " . $arr_month[ (int)$arr_tanggal_awal[1] ] . " " . $arr_tanggal_awal[0];

$arr_tanggal_akhir = explode("-", $s_tanggal_akhir_formatted);
$s_tanggal_akhir = $arr_tanggal_akhir[2] . " " . $arr_month[ (int)$arr_tanggal_akhir[1] ] . " " . $arr_tanggal_akhir[0];

/*$s_tanggal_awal_formatted_v = trim(@$_REQUEST["tanggal_awal"] != "" ? @$_REQUEST["tanggal_awal"] : $tanggal_satu );
$s_tanggal_akhir_formatted_v = trim(@$_REQUEST["tanggal_akhir"] != "" ? @$_REQUEST["tanggal_akhir"] : $tanggal_sekarang );

$arr_tanggal_awal_v = explode("-", $s_tanggal_awal_formatted_v);
$s_tanggal_awal_v = $arr_tanggal_awal_v[2] . " " . $arr_month[ (int)$arr_tanggal_awal_v[1] ] . " " . $arr_tanggal_awal_v[0];

$arr_tanggal_akhir_v = explode("-", $s_tanggal_akhir_formatted_v);
$s_tanggal_akhir_v = $arr_tanggal_akhir_v[2] . " " . $arr_month[ (int)$arr_tanggal_akhir_v[1] ] . " " . $arr_tanggal_akhir_v[0];*/

$rs_penjualan = penjualan::data_penjualan
			( 
			array("b.id_user", @$_REQUEST["user_id"]), 
			$s_tanggal_awal_formatted, 
			$s_tanggal_akhir_formatted
			);
$data_penjualan = sqlsrv_fetch_array( $rs_penjualan );


// LOAD DAFTAR ITEM ANDROID
$rs_daftar_item = komisi::load_data_item();
while( $daftar_item = sqlsrv_fetch_array( $rs_daftar_item ) ){
	$arr_daftar_item[] = $daftar_item["nama_model"];
	$arr_harga_item[] =/*$daftar_item["unitprice"] * (100 - $data_penjualan["level_diskon"]) / 100*/ 0 ;
	$arr_harga_sellin[] =$daftar_item["unitprice"] * (100 - $data_penjualan["level_diskon"]) / 100;
	$arr_idmodel_item[] = $daftar_item["id_model"];
	$arr_item_info[] = array(
						"nama_model" => $daftar_item["nama_model"], 
						"harga" =>/*$daftar_item["unitprice"] * (100 - $data_penjualan["level_diskon"]) / 100*/ 0,
						"id_model" => $daftar_item["id_model"]
						);
	$arr_opsi_selectbox_item[ $daftar_item["id_model"] ] = $daftar_item["nama_model"];
}
$json_daftar_item = json_encode($arr_daftar_item);
$json_item_info = json_encode($arr_item_info);


// DETAIL PENJUALAN
$arr_parameter = array(
		 "a.tanggal" => array( ">=",  "''". main::formatting_query_string( $s_tanggal_awal_formatted ) ."'' and a.tanggal <= ''". main::formatting_query_string( $s_tanggal_akhir_formatted ) ."''"), 
		 "a.id_sales" => array( " = ",  $_REQUEST["user_id"])
	);
$rs_detail_penjualan = penjualan::detail_penjualan($arr_parameter);

$counter = 1;
$s_data_penjualan = "";
$s_grand_total = $s_grand_total_sellin = $s_grand_total_item=0;

while( $detail_penjualan = sqlsrv_fetch_array($rs_detail_penjualan) ){
	$sellin_price = $detail_penjualan["UNITPRICE"] * (100 - $data_penjualan["level_diskon"]) / 100;
	$subtotal_sellin_price = $sellin_price * $detail_penjualan["qty"];
	$arr_data_penjualan = array(
		$counter,
		strtoupper($detail_penjualan["tanggal"]->format("d") . " " . $arr_month[ (int)$detail_penjualan["tanggal"]->format("m")] . " " . $detail_penjualan["tanggal"]->format("Y")),
		strtoupper($detail_penjualan["faktur"]),
		strtoupper($detail_penjualan["nama_customer"]),
		
		check_box($counter) . 
		pilihan_item($counter, bikin_opsi_selectbox( $arr_opsi_selectbox_item, $detail_penjualan["nama_model"] ) ) . 
		( $detail_penjualan["error_kode_accpac"] == 1 ? 
			"<div style=\"padding:5px; background-color:yellow; font-weight:900\">Isikan kode ACCPAC di master item!</div>" 
			: "" ),
		
		isian_harga_tidakreadonly($counter, $detail_penjualan["harga"]),
		isian_harga_sellin($counter, $sellin_price ),
		margin($counter, ( ($detail_penjualan["harga"] - $sellin_price) / $sellin_price ) * 100 ),
		
		isian_qty($counter, $detail_penjualan["qty"]),
		
		isian_hidden($counter, $detail_penjualan["subtotal"], $detail_penjualan["id_model"], $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"]),
		isian_hidden_sellin($counter, $subtotal_sellin_price, $detail_penjualan["id_model"], $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"]),
strtoupper($detail_penjualan["keterangan"])		
		);
	$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	$s_grand_total += $detail_penjualan["subtotal"];
	$s_grand_total_sellin += $subtotal_sellin_price;
	$s_grand_total_item += $detail_penjualan["qty"];
	
}



?>