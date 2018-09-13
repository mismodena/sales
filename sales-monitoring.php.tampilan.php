<input type="button" name="b_verifikasi" id="b_verifikasi" value="Input Data Sales" onclick="javascript:location.href='spg-verifikasi-penjualan-detail.php';" style="width:100%; background-color:green; border:solid 1px #CCC;" />
<!--<input type="button" name="b_verifikasi" id="b_verifikasi" value="Data Responden/Calon Responden" onclick="javascript:location.href='http://modena.typeform.com/to/h6zeYU';" style="width:100%; background-color:green; border:solid 1px #CCC;" />
-->
<input type="button" name="survei" id="survei" value="Input Data Responden / Calon Responden" onclick="javascript:location.href='https://modena.typeform.com/to/h6zeYU';" style="width:100%; background-color:green; border:solid 1px #CCC;" />
<input type="button" name="data" id="data" value="Link Survei" onclick="javascript:location.href='https://modena.typeform.com/to/zgO19X';" style="width:100%; background-color:green; border:solid 1px #CCC;" />

<iframe name="frmx" id="frmx" style="display:none; width:300px; height:300px"></iframe>

<div>
	<div class="h2"><h2>Informasi SPG/M</h2></div>
	<table class="table-header">
		<tr>
			<td>Nama SPG/M</td>
			<td><?=strtoupper(@$data_penjualan["nama_spg"])?></td>
		</tr>		
		<tr>
			<td>Area</td>
			<td><?=strtoupper(@$data_penjualan["area"])?></td>
		</tr>	
		<tr>
			<td>Toko</td>
			<td><?=strtoupper($data_penjualan["nama_toko"])?></td>
		</tr>	
		<tr>
			<td>Kode ACCPAC Toko</td>
			<td><?=strtoupper($data_penjualan["kodeaccpac_toko"])?></td>
		</tr>			
		<!--<tr>
			<td>Kelas Dealer</td>
			<td><?=@$data_penjualan["kelas"]?></td>
		</tr>		
		<tr>
			<td>Level Diskon</td>
			<td><?=@$data_penjualan["level_diskon"]?></td>
		</tr>		-->		
	</table>
</div>
<div>
	<div class="h2"><h2>Ringkasan Data Penjualan</h2></div>
	<table class="table-header">
		<tr>
			<td colspan="2">Periode Penjualan<br />
			<input type="text" name="t_tanggal_awal" id="t_tanggal_awal" 
								style="width:163px" maxlength="50" onchange="ubahtanggal()"
								value="<?=$s_tanggal_awal?>" readonly /> s/d 
			<input type="text" name="t_tanggal_akhir" id="t_tanggal_akhir" 
								style="width:163px" maxlength="50" onchange="ubahtanggal()"
								value="<?=$s_tanggal_akhir?>" readonly />
			<input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?=$s_tanggal_awal_formatted?>" />
			<input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?=$s_tanggal_akhir_formatted?>" />
			</td>
		</tr>
		<tr>
			<td>Target Penjualan (Rp)</td>
			<td><?=@number_format($data_penjualan["target"])?></td>
		</tr>
		<tr>
			<td>Total Penjualan (Rp) *<br />Pada rentang periode di atas</td>
			<td valign="top">
				<?=@number_format(/*$data_penjualan["total_penjualan"]*/ $s_grand_total)?>
			</td>
		</tr>	
		<tr>
			<td>Total Penjualan (%) *<br />Pada rentang periode di atas</td>
			<td valign="top">
				<?=$data_penjualan["target"] > 0 ? round(/*$data_penjualan["total_penjualan"]*/$s_grand_total / $data_penjualan["target"], 2) * 100 : 0 ?>
			</td>
		</tr>			
	</table>
	*). Penjualan (Rp) dan (%) dihitung dari harga net dealer (bukan dari harga sell-out).
</div>
<div>
	<div class="h2"><h2>Data Penjualan Detail</h2></div>
	<table id="table-data">
<!--		<tr>
			<td>No.</td>
			<td>Tanggal</td>
			<td>Faktur - Nama Konsumen</td>
			<td>Item</td>
			<td>Sub Total (Rp)</td>
		</tr>		-->
		<?=@$s_data_penjualan?>
		<tr>
			<!--<td colspan="4">
				<div style="float:right; line-height:37px;">REALISASI PENJUALAN (Rp)</div>
			</td><td id="col_grand_total"><?=number_format($s_grand_total)?></td></td>-->
			<td id="col_grand_total"><h3>TOTAL PENJUALAN <br />Rp<?=number_format($s_grand_total)?><BR />*).Total Penjualan dihitung dari harga Sell in.</h3></td></td>
		</tr>
	</table>
</div>