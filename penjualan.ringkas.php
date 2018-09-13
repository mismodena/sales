<tr>
	<td>No.</td>
	<td>Item</td>
	<td>Campaign</td>
	<td>Harga (Rp)</td>
	<td>Jumlah</td>
	<td>Sub Total (Rp)</td>
</tr><?=$s_data_penjualan?>
<tr>
	<td colspan="4" align="left">
		<input type="button" id="b_tambah_bawah" value="Tambah Data Penjualan" class="tombol-harus-difilter"
			onclick="tambah_penjualan()"
			style="width:233px; background-color:yellow; color:#333" />
		<div style="float:right; line-height:37px;">REALISASI PENJUALAN:</div>
	</td>
	<td id="col_total_unit"><?=$s_total_unit?> Unit</td>
	<td id="col_grand_total">Rp<?=number_format($s_grand_total)?></td>
</tr>