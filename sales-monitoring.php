<?
//die("<h4>Mohon maaf, halaman ini ditutup sampai dengan tanggal 13 Desember 2016.<br />Silahkan akses halaman ini pada tanggal 14 Desember 2016.</h4>");
include "includes/top_blank_logout.php";

// HEADER PENJUALAN
$tanggal_sekarang = date(" Y-n-j");
$tanggal_satu = date(" Y-n-1");
$s_tanggal_awal_formatted = trim(@$_REQUEST["tanggal_awal"] != "" ? @$_REQUEST["tanggal_awal"] : $tanggal_satu );
$s_tanggal_akhir_formatted = trim(@$_REQUEST["tanggal_akhir"] != "" ? @$_REQUEST["tanggal_akhir"] : $tanggal_sekarang );

$arr_tanggal_awal = explode("-", $s_tanggal_awal_formatted);
$s_tanggal_awal = $arr_tanggal_awal[2] . " " . $arr_month[ (int)$arr_tanggal_awal[1] ] . " " . $arr_tanggal_awal[0];

$arr_tanggal_akhir = explode("-", $s_tanggal_akhir_formatted);
$s_tanggal_akhir = $arr_tanggal_akhir[2] . " " . $arr_month[ (int)$arr_tanggal_akhir[1] ] . " " . $arr_tanggal_akhir[0];

$rs_penjualan = penjualan::data_penjualan
			( 
			array("b.id_user", $_SESSION["user_login"]), 
			$s_tanggal_awal_formatted, 
			$s_tanggal_akhir_formatted
			);
$data_penjualan = sqlsrv_fetch_array( $rs_penjualan );

$arr_parameter = array(
		 "a.tanggal" => array( ">=",  "''". main::formatting_query_string( $s_tanggal_awal_formatted ) ."'' and a.tanggal <= ''". main::formatting_query_string( $s_tanggal_akhir_formatted ) ."''"), 
		 "a.id_sales" => array( " = ",  $_SESSION["user_login"])
	);
$rs_detail_penjualan = penjualan::detail_penjualan($arr_parameter);

$counter = 1;
$s_data_penjualan = "";
$s_grand_total = 0;
$file_upload = "<input type=\"file\" name=\"file_#counter#\" id=\"file_#counter#\" onchange=\"__upload(this)\" class=\"#upload_file_class#\" />";

// DETAIL PENJUALAN
while( $detail_penjualan = sqlsrv_fetch_array($rs_detail_penjualan) ){
	
	$folder_tanggal = $detail_penjualan["tanggal"]->format("Y") . $detail_penjualan["tanggal"]->format("m");
	$nama_file = $detail_penjualan["id_sales"] . "_" . $detail_penjualan["faktur"] . ".jpg";
	$id_isian_file = $detail_penjualan["id_penjualan"] . "|" . $detail_penjualan["id_detail_penjualan"] . "|" . $detail_penjualan["id_sales"] . "|" . $detail_penjualan["faktur"];
	
	$arr_data_penjualan = array(

		"<div class=nomor>#" . $counter . "</div>",

		"<div class=tanggal>" . strtoupper($detail_penjualan["tanggal"]->format("d") . " " . $arr_month[ (int)$detail_penjualan["tanggal"]->format("m")] . " " . $detail_penjualan["tanggal"]->format("Y")) . "</div>",
		
		"<div id=\"file_upload_". $id_isian_file ."\" class=\"nomor\">Upload kuitansi : " . 
			( file_exists("upload/". $folder_tanggal ."/" . $nama_file) ? "<a href=\"javascript:void(0)\" onclick=\"window.open('upload/$folder_tanggal/$nama_file', 'img_faktur');return false\" target=\"_blank\">Lihat</a> | " . 
				str_replace(array("#upload_file_class#", "#counter#"), array("", $id_isian_file), $file_upload) : 
				str_replace(array("#upload_file_class#", "#counter#"), array("upload_file_class", $id_isian_file), $file_upload) ) . "</div>",

		"<div class=konsumen>[Faktur : " . strtoupper($detail_penjualan["faktur"]) . "] An. " . strtoupper($detail_penjualan["nama_customer"]) . "<br />
			Tel:" . strtoupper($detail_penjualan["notelp_customer"]) . ". Email:" . strtoupper($detail_penjualan["alamat_customer"]) . "</div>",

		"<div class=sales>" . $detail_penjualan["nama_model"] . "<br />Rp" . number_format( $detail_penjualan["harga"] ) . " x " . $detail_penjualan["qty"] . " unit." .
		( $detail_penjualan["error_kode_accpac"] == 1 ? 
			"<div style=\"padding:5px; background-color:yellow; font-weight:900\">Isikan kode ACCPAC di master item!</div>" 
			: "" ) . "</div>",
		
		"<div class=subtotal>Rp" . number_format( $detail_penjualan["subtotal"] ) . "</div>"
		
		);
	//$s_data_penjualan .= "<tr class=\"". ($counter % 2 == 0 ? "selang" : "seling") ."\"><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$s_data_penjualan .= "<tr class=\"". ($counter % 2 == 0 ? "selang" : "seling") ."\"><td style=\"padding:0px 7px 0px 7px\">" . implode("", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	$s_grand_total += $detail_penjualan["subtotal_netprice"];
}

$s_grand_total = $s_grand_total * (100-$data_penjualan["level_diskon"]) / 100;

if( $s_data_penjualan == "" ) $s_data_penjualan = "<tr><td colspan='5'>Belum ada data penjualan!</td></tr>";

include "sales-monitoring.php.tampilan.php";

include "includes/bottom_blank.php";
?>