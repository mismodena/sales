<?

// LOAD DATA PENJUALAN DETAIL
$rs_penjualan = komisi::load_data_penjualan(
					array(
						"a.id_sales" => array("=", "'". $_REQUEST["user_id"] . "'")
						)
				);
$counter = 1;
$s_data_penjualan = "";
$s_grand_total = 0;

while( $data_penjualan = sqlsrv_fetch_array($rs_penjualan) ){
	$arr_data_penjualan = array(
		$counter,
		strtoupper($data_penjualan["tanggal"]->format("d") . " " . $arr_month[ (int)$data_penjualan["tanggal"]->format("m")] . " " . $data_penjualan["tanggal"]->format("Y")),
		strtoupper($data_penjualan["faktur"]),
		strtoupper($data_penjualan["nama_customer"]),
		
		isian_item($counter, $data_penjualan["nama_model"]) . 
		( $data_penjualan["error_kode_accpac"] == 1 ? 
			"<div style=\"padding:5px; background-color:yellow; font-weight:900\">Isikan kode ACCPAC di master item!</div>" 
			: "" ),
		
		isian_harga($counter, $data_penjualan["harga"]),
		
		isian_qty($counter, $data_penjualan["qty"]),
		
		isian_hidden($counter, $data_penjualan["subtotal"], $data_penjualan["id_model"], $data_penjualan["id_detail_penjualan"])				
		);
	$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	$s_grand_total += $data_penjualan["subtotal"];
}

if( $data_komisi["realisasi_android"] * 1.1 !=  $s_grand_total )
	@$script .= "$('#rekap-penjualan-note').attr('style', 'display:block'); $('#col_grand_total').attr('style', 'background-color:yellow')";

@$script .= "
function inaktifin_tombol(){
	var arr = new Array('tambah', 'reset', 'simpan');
	for( var x = 0; x < arr.length; x++ ){
		var b = document.getElementById('b_' + arr[x] );
		b.setAttribute('style', 'display:none');
	}
}
inaktifin_tombol();
";

?>