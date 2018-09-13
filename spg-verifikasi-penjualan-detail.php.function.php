<?

set_time_limit(100);

$_REQUEST["user_id"] = $_SESSION["user_login"];
$file_upload = "<input type=\"file\" name=\"file_#counter#\" id=\"file_#counter#\" onchange=\"__upload(this)\" class=\"#upload_file_class#\" />";

if( !isset($_REQUEST["c"]) ) goto SkipCommand;

if( $_REQUEST["c"] =="simpan_data" ){	
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
		
	// simpan data penjualan
	$counter = 1;	
	$sql_update_delete = "";
	
	while( true === true ){

		if( !isset( $_POST["transaksi_" . $counter] ) ) break;
		
		@list( $id_penjualan, $id_detail_penjualan ) = explode("|", $_POST["transaksi_" . $counter]);
		
		$serial = $_POST["sn_" . $counter];
		if($serial!=""){
			$cek = file_get_contents("http://air.modena.co.id/csapps/?c=load_barcode&sn=".$_POST["sn_" . $counter]);
			$cek = json_decode($cek, true);
			if($cek['item_id']==""){
				$serial = "";
			}else{
				$cJ = mysqli_num_rows( mysqli_query( $mysqlcon, "select * from penjualan_detail 
							where sn='". main::formatting_query_string( $serial ) ."' and
							id_penjualan <> '". main::formatting_query_string( $id_penjualan ) ."' and 
							id_detail_penjualan <> '". main::formatting_query_string( $id_detail_penjualan ) ."'" ));
				if($cJ>0){
					$serial = "";
				}
			}
		}
						
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
						qty = '". main::formatting_query_string( $_POST["qty_" . $counter] ) ."',
						sn = '". main::formatting_query_string( $serial ) ."'
					where 
					id_penjualan = '". main::formatting_query_string( $id_penjualan ) ."' and 
					id_detail_penjualan = '". main::formatting_query_string( $id_detail_penjualan ) ."';";
			
		// insert
		}else{
			
			if( $_POST["qty_" . $counter] <= 0 || $_POST["qty_" . $counter] == "" ) goto Skip;
			
			$sql ="insert into penjualan(faktur, id_sales, nama_customer, notelp_customer, alamat_customer, tanggal)
				values(
				'". main::formatting_query_string( $_POST["faktur_" . $counter] ) ."', 
				'". main::formatting_query_string( $_POST["user_id"] ) ."', 
				'". main::formatting_query_string( $_POST["namakonsumen_" . $counter ] ) ."', 
				'". main::formatting_query_string( $_POST["telepon_" . $counter ] ) ."', 
				'". main::formatting_query_string( $_POST["email_" . $counter ] ) ."', 
				'". main::formatting_query_string( $_POST["tglf_" . $counter] ) ."');";
			mysqli_query( $mysqlcon, $sql );
			
			$id = mysqli_fetch_array( mysqli_query( $mysqlcon, "select LAST_INSERT_ID() id_penjualan" ));
			
			$sql = "insert into penjualan_detail(id_penjualan, id_model, harga, qty,keterangan,sn)
				values(
				'". main::formatting_query_string( $id["id_penjualan"] ) ."', 
				'". main::formatting_query_string( $_POST["item_" . $counter] ) ."', 
				'". main::formatting_query_string( str_replace(",", "", $_POST["harga_" . $counter] ) ) ."', 
				'". main::formatting_query_string( $_POST["qty_" . $counter] ) ."',
				'". main::formatting_query_string( $_POST["keterangan_" . $counter] ) ."',
				'". main::formatting_query_string( $serial ) ."');";
			mysqli_query( $mysqlcon, $sql );
			
		}Skip:
		$counter++;
		
	}
	
	if( $sql_update_delete != "" ) mysqli_multi_query( $mysqlcon, $sql_update_delete ) or die("error update delete");
	
	if( isset($_REQUEST["kembali"]) ) header("'location:sales-monitoring.php");
	
	header("location:spg-verifikasi-penjualan-detail.php?tanggal_awal=". $_REQUEST["t_tanggal_awal"] ."&tanggal_akhir=". $_REQUEST["t_tanggal_akhir"]);
}elseif( $_REQUEST["c"] =="upload" ){	
	
	$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");

	$id = explode("_", $_REQUEST["id"]);
	list( $id_penjualan, $id_detail_penjualan, $id_sales, $faktur ) = explode("|", $id[1]);
	
	// cek tanggal faktur dan bikin folder tanggal
	$arr_parameter_tanggal_faktur = array(
		 "b.id_penjualan" => array( "=",  "''". main::formatting_query_string( $id_penjualan ) ."''"), 
		 "b.id_detail_penjualan" => array( " = ",  "''". main::formatting_query_string( $id_detail_penjualan ) ."''")
	);
	$rs_detail_penjualan_cek_tanggal_faktur = penjualan::detail_penjualan($arr_parameter_tanggal_faktur);
	$detail_penjualan_cek_tanggal_faktur = sqlsrv_fetch_array( $rs_detail_penjualan_cek_tanggal_faktur );
	$folder_tanggal = $detail_penjualan_cek_tanggal_faktur["tanggal"]->format("Y") . $detail_penjualan_cek_tanggal_faktur["tanggal"]->format("m");
	if( !file_exists( "upload/" . $folder_tanggal ) ) mkdir("upload/" . $folder_tanggal);
	
	$tmp_name = $_FILES["file_" . $id[1]]["tmp_name"];
	$name = basename($id_sales . "_" . $faktur . ".jpg");
	move_uploaded_file($tmp_name, "upload/" . $folder_tanggal . "/" . $name);
	
	
	$sql = "update penjualan_detail set 
						keterangan = '". main::formatting_query_string( $name ) ."' 
					where 
					id_penjualan = '". main::formatting_query_string( $id_penjualan ) ."' and 
					id_detail_penjualan = '". main::formatting_query_string( $id_detail_penjualan ) ."';";
	mysqli_query( $mysqlcon, $sql );
	
	$script_string = "<a href=\"javascript:void(0)\" onclick=\"window.open(\'upload/". $folder_tanggal ."/". $name . "\', \'img_faktur\');return false\" target=\"_blank\">Lihat</a> | " . str_replace(array("#upload_file_class#", "#counter#", "\r\n"), array("", $id[1], ""), $file_upload);
	
	$script = "<script>
		parent.document.getElementById('file_upload_". $id[1] ."').innerHTML = '$script_string';
		</script>
	";
	die($script);
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
	$folder_tanggal = $detail_penjualan["tanggal"]->format("Y") . $detail_penjualan["tanggal"]->format("m");
	$nama_file = $detail_penjualan["id_sales"] . "_" . $detail_penjualan["faktur"] . ".jpg";
	$id_isian_file = $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"] . "|" . $detail_penjualan["id_sales"] . "|" . $detail_penjualan["faktur"];
	
	$arr_data_penjualan = array(
		$counter,
		strtoupper($detail_penjualan["tanggal"]->format("d") . " " . $arr_month[ (int)$detail_penjualan["tanggal"]->format("m")] . " " . $detail_penjualan["tanggal"]->format("Y")),
		strtoupper($detail_penjualan["faktur"]),
		strtoupper($detail_penjualan["nama_customer"] . 
			( $detail_penjualan["notelp_customer"] != "" ? "<br />TEL:" . $detail_penjualan["notelp_customer"] : "" ) . 
			( $detail_penjualan["alamat_customer"] != "" ? "<br />EMAIL:" . $detail_penjualan["alamat_customer"] : "" )
			),
		
		check_box($counter) . 
		pilihan_item($counter, bikin_opsi_selectbox( $arr_opsi_selectbox_item, $detail_penjualan["id_model"] ) ) . 
		( $detail_penjualan["error_kode_accpac"] == 1 ? 
			"<div style=\"padding:5px; background-color:yellow; font-weight:900\">Isikan kode ACCPAC di master item!</div>" 
			: "" ),
		
		isian_harga_tidakreadonly($counter, $detail_penjualan["harga"]),
		isian_harga_sellin($counter, $sellin_price ),
		margin($counter, ( ($detail_penjualan["harga"] - $sellin_price) / $sellin_price ) * 100 ),
		
		isian_qty($counter, $detail_penjualan["qty"]),
		
		isian_hidden($counter, $detail_penjualan["subtotal"], $detail_penjualan["id_model"], $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"]),
		isian_hidden_sellin($counter, $subtotal_sellin_price, $detail_penjualan["id_model"], $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"]),
		/*strtoupper($detail_penjualan["keterangan"])		*/
		isian_sn($counter, $detail_penjualan["sn"]),
		"<span id=\"file_upload_". $id_isian_file ."\">" . 
			( file_exists("upload/". $folder_tanggal ."/" . $nama_file) ? "<a href=\"javascript:void(0)\" onclick=\"window.open('upload/$folder_tanggal/$nama_file', 'img_faktur');return false\" target=\"_blank\">Lihat</a> | " . 
				str_replace(array("#upload_file_class#", "#counter#"), array("", $id_isian_file), $file_upload) : 
				str_replace(array("#upload_file_class#", "#counter#"), array("upload_file_class", $id_isian_file), $file_upload) ) . "</span>"
		);
	$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	$s_grand_total += $detail_penjualan["subtotal"];
	$s_grand_total_sellin += $subtotal_sellin_price;
	$s_grand_total_item += $detail_penjualan["qty"];
	
}



?>