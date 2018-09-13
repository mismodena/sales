<?
include "includes/top.php";
?>
<div style="float:left; width:47%; padding-left:19px; padding-top:13px">
	<table class="table-header">
		<tr>
			<td>Nama SPG/M</td>
			<td><?=strtoupper(@$data_komisi["nama_user"])?></td>
		</tr>		
		<tr>
			<td>Area - Toko | Kode ACCPAC</td>
			<td><?=strtoupper(@$data_komisi["area"])?> - <?=strtoupper($data_komisi["store"])?></td>
		</tr>	
		<tr>
			<td>Kelas Dealer</td>
			<td><?=@$data_komisi["kelas"]?></td>
		</tr>		
		<tr>
			<td>Diskon Toko (%)</td>
			<td><?=@$data_komisi["level_diskon"]?></td>
		</tr>				
	</table>
	<div style="padding-top:3px">
		<input type="button" id="b_kembali" value="<< Kembali" style="width:177px" class="tombol-harus-difilter"
			onclick="javascript:kembali()" />		
		<input type="button" id="b_tampilan" value="Tampilan <?=ucfirst($mode_tampilan["lain"])?>" style="width:177px"
			onclick="javascript:ubah_tampilan()" /><br />
		<strong style="font-size:17px">G</strong>unakan checkbox (di samping pilihan item) untuk menandai baris data yang sudah diverifikasi. Urutan data berdasarkan nama item.<br />
		<strong style="font-size:17px">U</strong>ntuk menghapus baris data, isikan nilai nol (0) di isian "Jumlah".<br />
		<strong style="font-size:17px">H</strong>arga item yang ditampilkan adalah harga net dari dealer bersangkutan.
	</div>
	<div id="rekap-penjualan-note" style="display:none">Perlu perhitungan komisi ulang</div>
</div>
<div style="float:right; width:47%; border-left:1px solid #666; padding-left:17px; padding-top:13px">
	<table class="table-header">
		<tr>
			<td>Tanggal Perhitungan Komisi</td>
			<td><?=strtoupper(@$tanggal_perhitungan_komisi)?></td>
		</tr>
		<tr>
			<td>Periode Komisi</td>
			<td><?=strtoupper(@$formatted_periode)?></td>
		</tr>
		<tr>
			<td>Target Penjualan (Rp)</td>
			<td><?=@number_format($data_komisi["target"])?></td>
		</tr>
		<tr>
			<td>Realisasi Penjualan (Rp)</td>
			<td><?=@number_format( (@$data_komisi["realisasi_android"] * 1.1 ) )?></td>
		</tr>
		<tr>
			<td>Realisasi Penjualan Setelah Pajak (Rp) </td>
			<td>
				<?=@number_format($data_komisi["realisasi_android"])?>
				<input type="hidden" id="hd_realisasi_android" value="<?= (@$data_komisi["realisasi_android"] * 1.1 )?>" />
			</td>
		</tr>	
		<tr>
			<td>Realisasi (%)</td>
			<td><?=$data_komisi["target"] > 0 ? round($data_komisi["realisasi_android"]/ $data_komisi["target"], 2) * 100 : 0 ?> %</td>
		</tr>	
		<tr>
			<td>Realisasi Campaign (Rp)</td>
			<td><?=@number_format($data_komisi["realisasi_campaign"]) ?> </td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Fix (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_fix"])?></td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Variabel (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_variabel"])?></td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Campaign (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_campaign"])?></td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Poin (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_poin"])?></td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Special Campaign (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_spesial"])?></td>
		</tr>	
		<tr class="komisi">
			<td>Komisi Total (Rp)</td>
			<td><?=@number_format($data_komisi["komisi_total"])?></td>
		</tr>
	</table>
</div>
<table id="table-data">
<tr>
	<td colspan="8" style="text-align:left">
		<input type="button" id="b_tambah" value="Tambah Data Penjualan" class="tombol-harus-difilter"
			onclick="tambah_penjualan()"
			style="width:233px; background-color:yellow; color:#333" />
		<div style="float:right">
		<input type="button" id="b_reset" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" />
		</div>
	</td>
</tr>
<? include "penjualan.". $mode_tampilan["sekarang"] .".php"; ?>
</table>
<input type="hidden" name="user_id" value="<?=$_REQUEST["user_id"]?>" />
<input type="hidden" name="periodeid" value="<?=$_REQUEST["periodeid"]?>" />
<input type="hidden" name="area" value="<?=$_REQUEST["area"]?>" />
<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>