<?
// LOAD DATA PENJUALAN DETAIL
$rs_penjualan = komisi::load_data_penjualan_rekap(
					array(
						"a.id_user" => array("=", "'". $_REQUEST["user_id"] . "'"),
						"a.periode" =>array("=", "'". $_REQUEST["periodeid"] . "'")
						)
				);
$counter = 1;
$s_data_penjualan = "";
$s_total_unit = $s_grand_total = 0;

while( $data_penjualan = sqlsrv_fetch_array($rs_penjualan) ){
	$arr_data_penjualan = array(
		$counter,
		
		check_box($counter) . 
		pilihan_item($counter, bikin_opsi_selectbox( $arr_opsi_selectbox_item, $data_penjualan["nama_model"] ) ) . 
		( $data_penjualan["error_kode_accpac"] == 1 ? 
			"<div style=\"padding:5px; background-color:yellow; font-weight:900\">Isikan kode ACCPAC di master item!</div>" 
			: "" ),
		
		$data_penjualan["komisi_campaign"] > 0 ? "Campaign " . $data_penjualan["persentase_komisi"] . "%" : "",
		
		isian_harga($counter, $data_penjualan["harga"]),
		
		isian_qty($counter, $data_penjualan["qty"]),
		
		isian_hidden($counter, $data_penjualan["subtotal"], $data_penjualan["id_model"], $data_penjualan["id_transaksi"])
		);
	$s_data_penjualan .= "<tr><td style=\"padding:0px 7px 0px 7px\">" . implode("</td><td style=\"padding:0px 7px 0px 7px\">", $arr_data_penjualan) . "</td></tr>";
	$counter++;
	$s_total_unit += $data_penjualan["qty"];
	$s_grand_total += $data_penjualan["subtotal"];
}

if( round($data_komisi["realisasi_android"] * 1.1) !==  round($s_grand_total) )
	@$script .= "$('#rekap-penjualan-note').attr('style', 'display:block'); $('#col_grand_total').attr('style', 'background-color:yellow')";

?>