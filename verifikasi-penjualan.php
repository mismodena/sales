<?
include "includes/top.php";
?>
<div style="background-image:url('images/CEM_website_icon-SALES.png'); 
	background-repeat:no-repeat; background-position:left center; width:100%; float:left; margin-bottom:33px">
<table id="table-setting">
<tr>
	<td>Cabang / Area</td>
	<td><select name="area" id="area"><?=@$s_area?></select></td>
</tr>
<tr>
	<td>Periode Penjualan</td>
	<td>	<input type="text" name="t_tanggal_awal" id="t_tanggal_awal" 
								style="width:193px" maxlength="50" 
								value="<?=$s_tanggal_awal?>" readonly /> - 
			<input type="text" name="t_tanggal_akhir" id="t_tanggal_akhir" 
								style="width:193px" maxlength="50" 
								value="<?=$s_tanggal_akhir?>" readonly />
			<input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?=$s_tanggal_awal_formatted?>" />
			<input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?=$s_tanggal_akhir_formatted?>" />
	</td>
</tr>
<tr>
	<td></td>
	<td style="padding-top:13px"><input type="button" name="b_lihat" id="b_lihat" value="Lihat Data Penjualan" onclick="lihat()" style="width:177px;" /></td>
</tr>
</table>
</div>
<div style="padding-left:17px">*). Penjualan pada periode di atas.</div>
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Toko</td>
	<td>Kelas</td>
	<td>Level Diskon</td>
	<td>Target (Rp)</td>
	<td>Penjualan (Rp) *</td>
	<td>Realisasi (%) *</td>
	<td></td>
</tr>
<?=@$s_data_penjualan?>
</table>
<?
include "includes/bottom.php";
?>