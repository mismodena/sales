<?
include "includes/top.php";
?>
<div style="background-image:url('images/target2.png'); background-repeat:no-repeat; background-position:left top; width:100%; float:left;">
<table id="table-setting">
<tr>
	<td colspan="2" style="padding-bottom:17px">Gunakan form berikut untuk mengubah target penjualan SPG/M.<br />Isikan target penjualan SPG/M yang baru di isian "Target Penjualan Baru" pada masing-masing baris data SPG/M, apabila ada perubahan target penjualan ataupun isian "Target Penjualan Baru" bisa dikosongkan apabila tidak ada perubahan target penjualan.<br />Dan yang terakhir jangan lupa klik tombol "Simpan".<br />
	<strong style="font-size:17px">N</strong>ote : target penjualan yang diisikan harus sudah mendapatkan persetujuan dari manajemen!</td>	
</tr>
<tr>
	<td>Cabang / Area</td>
	<td><select name="area" id="area" onchange="javascript:ubah_cabang()"><?=@$s_area?></select></td>
</tr>
</table>
</div>
<div style="float:right">
		<input type="button" id="b_reset" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" /><br />
		</div>
		<div style="float:left; width:100%; margin:17px">
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Target Penjualan Saat ini (Rp)</td>
	<td>Target Penjualan Baru (Rp)</td>
</tr><?=@$s_data_penjualan?>
</table>
		</div>
		<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>