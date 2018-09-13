<tr>
	<td>No.</td>
	<td>Tanggal</td>
	<td>Faktur</td>
	<td>Nama-Telp/HP-Email Konsumen</td>
	<td>Item</td>
	<td>Harga Sell Out(Rp)</td>
	<td>Harga Sell In(Rp)</td>
	<td>Margin (%)</td>
	<td>Jumlah</td>
	<td>Sub Total Sell Out(Rp)</td>
	<td>Sub Total Sell In(Rp)</td>
	<td>Nomor Seri</td>
	<td>Upload Kuitansi</td>
</tr><?=$s_data_penjualan?>
<tr>
	<td colspan="8">
	<input type="button" id="b_tambah_bawah" value="Tambah Data Penjualan" class="tombol-harus-difilter"
			onclick="tambah_penjualan()"
			style="width:233px; background-color:yellow; color:#333; display:none" />
		<div style="float:right; line-height:37px;">REALISASI PENJUALAN (Rp)</div>
	</td><td id="col_grand_total_item"><?=number_format($s_grand_total_item)?></td><td id="col_grand_total"><?=number_format($s_grand_total)?></td><td id="col_grand_total_sellin"><?=number_format($s_grand_total_sellin)?></td></td>
</tr>