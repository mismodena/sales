<?

function isian_tanggal($counter = "#counter#"){
	return str_replace("\r\n", "", "<input 
			type=\"text\" name=\"tgl_". $counter ."\" id=\"tgl_". $counter ."\" 
			style=\"width:123px\" maxlength=\"50\" 
			readonly /><input type=\"hidden\" name=\"tglf_". $counter ."\" id=\"tglf_". $counter ."\" />");
}

function isian_teks($nama, $counter = "#counter#", $nilai = ""){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:130px\"
			name=\"". $nama ."_". $counter ."\" 
			id=\"". $nama ."_". $counter ."\" 
			value = \"". $nilai ."\"
			 />");
}
function isian_upload($nama, $counter = "#counter#", $nilai = ""){
	return str_replace("\r\n", "", "<input type=\"file\" 
			style=\"width:130px\"
			name=\"". $nama ."_". $counter ."\" 
			id=\"". $nama ."_". $counter ."\" 
			value = \"". $nilai ."\"
			 />");
}

function bikin_opsi_selectbox($arr_opsi, $selected = ""){
	$s_opsi = "";
	foreach($arr_opsi as $nilai => $label)
		$s_opsi .= "<option value=\"". $nilai ."\"  ". ($nilai == $selected ? "selected" : "") .">". $label ."</option>";
	return $s_opsi;
}

function check_box($counter = "#counter#"){
	return str_replace("\r\n", "", "<input type=\"checkbox\" 
			name=\"cb_". $counter ."\" 
			id=\"cb_". $counter ."\" 
			value=\"" . $counter  . "\"
			class=\"checkbox\"
			onclick=\"klik_checbox(this)\" />");
}

function pilihan_item($counter = "#counter#", $selected_model = ""){
	return str_replace("\r\n", "", "<select 
			style=\"width:150px\"
			name=\"item_". $counter ."\" 
			id=\"item_". $counter ."\" 
			class=\"select-search\"
			onchange=\"ubah_qty_harga(this)\">". $selected_model ."
			</select>");
}

function isian_item($counter = "#counter#", $nama_model = ""){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:247px\"
			name=\"item_". $counter ."\" 
			id=\"item_". $counter ."\" 
			class=\"item-json\"
			value=\"" . strtoupper($nama_model)  . "\"
			onfocus=\"fokusinput(this);ubah_qty_harga(this)\"
			onblur=\"javascript:ubah_qty_harga(this)\"/>");
			
}

function isian_harga($counter = "#counter#", $harga = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:107px\"
			name=\"harga_". $counter ."\" 
			id=\"harga_". $counter ."\" 
			value=\"" . number_format($harga) . "\"
			onfocus=\"fokusinput(this)\"
			onblur=\"unfokusinput(this);ubah_qty_harga(this)\" readonly=\"true\" />");
}

function isian_harga_sellin($counter = "#counter#", $harga = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:107px\"
			name=\"sellin_". $counter ."\" 
			id=\"sellin_". $counter ."\" 
			value=\"" . number_format($harga) . "\"
			onfocus=\"fokusinput(this)\"
			onblur=\"unfokusinput(this);ubah_qty_harga_sellin(this)\" readonly=\"true\" 
			onload=\"ubah_qty_harga_sellin(this)\"/>");
}

function margin($counter = "#counter#", $harga = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:70px\"
			name=\"margin_". $counter ."\" 
			id=\"margin_". $counter ."\" 
			value=\"" . round($harga, 2) . "\"
			onfocus=\"fokusinput(this)\"
			onblur=\"unfokusinput(this);ubah_qty_harga_sellin(this)\" readonly=\"true\" />");
}

function isian_harga_tidakreadonly($counter = "#counter#", $harga = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:107px\"
			name=\"harga_". $counter ."\" 
			id=\"harga_". $counter ."\" 
			value=\"" . number_format($harga) . "\"
			onfocus=\"fokusinput(this)\"
			onblur=\"unfokusinput(this);ubah_qty_harga(this)\" />");
}

function isian_qty($counter = "#counter#", $qty = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:47px\"
			name=\"qty_". $counter ."\" 
			id=\"qty_". $counter ."\" 
			value=\"" . number_format($qty) . "\"
			onfocus=\"fokusinput(this);ubah_qty_harga(this)\"
			onblur=\"unfokusinput(this);ubah_qty_harga(this)\"  onKeyPress=\"return numbersonly(this, event)\" />");
}

function isian_hidden($counter = "#counter#", $subtotal = 0, $id_model = "", $id_transaksi = ""){
	return str_replace("\r\n", "", "<span id=\"rowtotal_". $counter ."\" ". ( $subtotal <= 0 && $id_model != "" ? "class=\"bg-nilai-nol\"" : "" ) .">" . number_format($subtotal) . "</span>
		<input type=\"hidden\" name=\"idmodel_". $counter ."\" id=\"idmodel_". $counter ."\" value=\"" . $id_model . "\" />
		<input type=\"hidden\" id=\"subtotal_". $counter ."\" value=\"" . $subtotal . "\" />
		<input type=\"hidden\" name=\"transaksi_". $counter ."\" id=\"transaksi_". $counter ."\" value=\"" . $id_transaksi . "\" />");
}
function isian_hidden_sellin($counter = "#counter#", $subtotal = 0, $id_model = "", $id_transaksi = ""){
	return str_replace("\r\n", "", "<span id=\"rowtotal_sellin_". $counter ."\" ". ( $subtotal <= 0 && $id_model != "" ? "class=\"bg-nilai-nol\"" : "" ) .">" . number_format($subtotal) . "</span>
		<input type=\"hidden\" name=\"idmodel_". $counter ."\" id=\"idmodel_". $counter ."\" value=\"" . $id_model . "\" />
		<input type=\"hidden\" id=\"subtotal_sellin_". $counter ."\" value=\"" . $subtotal . "\" />
		<input type=\"hidden\" name=\"transaksi_". $counter ."\" id=\"transaksi_". $counter ."\" value=\"" . $id_transaksi . "\" />");
}

function isian_pph($counter = "#counter#", $qty = 0){
	return str_replace("\r\n", "", "<input type=\"text\" 
			style=\"width:100px\"
			name=\"pph_". $counter ."\" 
			id=\"pph_". $counter ."\" 
			value=\"" . number_format($qty) . "\"
			onfocus=\"fokusinput(this);ubah_komisi(this)\"
			onblur=\"unfokusinput(this);ubah_komisi(this)\"  onKeyPress=\"return numbersonly(this, event)\" />");
}

function isian_total_komisi($counter = "#counter#", $nilai = 0, $id_model = "", $id_transaksi = ""){
	return str_replace("\r\n", "", "<span id=\"komisi_total_view_". $counter ."\" >" . number_format($nilai) . "</span>
		<input type=\"hidden\" id=\"komisi_total_". $counter ."\" name=\"poin_total_". $counter ."\" value=\"" . $nilai . "\" />");
}

function isian_total_final($counter = "#counter#", $nilai = 0, $id_model = "", $id_transaksi = ""){
	return str_replace("\r\n", "", "<span id=\"komisi_final_view_". $counter ."\" >" . number_format($nilai) . "</span>
		<input type=\"hidden\" id=\"komisi_final_". $counter ."\" name=\"komisi_final_". $counter ."\" name=\"poin_total_". $counter ."\" value=\"" . $nilai . "\" />");
}

?>