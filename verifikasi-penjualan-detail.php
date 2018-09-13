<?
include "includes/top.php";
?>
<iframe name="frmx" id="frmx" style="display:none; width:300px; height:300px"></iframe>
<div style="float:left; width:47%; padding-left:19px; padding-top:13px">
	<table class="table-header">
		<tr>
			<td>Nama SPG/M</td>
			<td><?=strtoupper(@$data_penjualan["nama_spg"])?></td>
		</tr>		
		<tr>
			<td>Area - Toko | Kode ACCPAC</td>
			<td><?=strtoupper(@$data_penjualan["area"])?> - <?=strtoupper($data_penjualan["store"])?></td>
		</tr>	
		<tr>
			<td>Kelas Dealer</td>
			<td><?=@$data_penjualan["kelas"]?></td>
		</tr>		
		<tr>
			<td>Level Diskon</td>
			<td><?=@$data_penjualan["level_diskon"]?></td>
		</tr>				
	</table>
	<div style="padding-top:3px">
		<input type="button" id="b_kembali" value="<< Kembali" style="width:177px" class="tombol-harus-difilter"
			onclick="javascript:kembali()" />	<br />
		<strong style="font-size:17px">G</strong>unakan checkbox (di samping pilihan item) untuk menandai baris data yang sudah diverifikasi. Urutan data berdasarkan nama item.<br />
		<strong style="font-size:17px">U</strong>ntuk menghapus baris data, isikan nilai nol (0) di isian "Jumlah".<br />
		<strong style="font-size:17px">H</strong>arga item yang ditampilkan adalah harga net dari dealer bersangkutan.
	</div>
</div>
<div style="float:right; width:47%; border-left:1px solid #666; padding-left:17px; padding-top:13px">
	<table class="table-header">
		<tr>
			<td>Periode Penjualan</td>
			<td><?=strtoupper(@$s_tanggal_awal)?> - <?=strtoupper(@$s_tanggal_akhir)?></td>
		</tr>
		<tr>
			<td>Target Penjualan (Rp)</td>
			<td><?=@number_format($data_penjualan["target"])?></td>
		</tr>
		<tr>
			<td>Total Penjualan (Rp)<br />Pada rentang periode di atas</td>
			<td><?=@number_format(/*$data_penjualan["total_penjualan"]*/$s_grand_total_sellin)?></td>
		</tr>
		<tr>
			<td>Total Penjualan Setelah Pajak (Rp)<br />Pada rentang periode di atas</td>
			<td valign="top">
				<?=@number_format( (/*$data_penjualan["total_penjualan"]*/$s_grand_total_sellin / 1.1))  ?>
				<input type="hidden" id="hd_total_penjualan" value="<?= (/*@$data_penjualan["total_penjualan"]*/$s_grand_total_sellin / 1.1)?>" />
			</td>
		</tr>	
		<tr>
			<td>Total Penjualan Setelah Pajak (%)<br />Pada rentang periode di atas</td>
			<td valign="top">
				<?=$data_penjualan["target"] > 0 ? round( (/*$data_penjualan["total_penjualan"]*/$s_grand_total_sellin/1.1) / $data_penjualan["target"], 2) * 100 : 0 ?>
			</td>
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
			onclick="javascript:simpan()" /><br />
			<div style="padding-top:13px">*). Untuk menghapus data, isikan nol (0) pada isian "Jumlah".</div>
		</div>
	</td>
</tr>
<? include "penjualan.detail.php" ?>
</table>
<input type="hidden" name="area" value="<?=$_REQUEST["area"]?>" />
<input type="hidden" name="user_id" value="<?=$_REQUEST["user_id"]?>" />
<input type="hidden" name="tanggal_awal" value="<?=$_REQUEST["tanggal_awal"]?>" />
<input type="hidden" name="tanggal_akhir" value="<?=$_REQUEST["tanggal_akhir"]?>" />
<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>