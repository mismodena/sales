<?
include "includes/top.php";
?>
<div style="background-image:url('images/market-store-icon.jpg'); background-repeat:no-repeat; background-position:left top; width:100%; float:left;">
<table id="table-setting">
<tr>
	<td colspan="2" style="padding-bottom:17px">Berikut adalah max jam & hari kerja periode <span style="background-color:yellow; font-weight:bold;"><?=@$periode?></span>
	<br />Gunakan form berikut untuk mengubah max jam & hari kerja.<br /><br /><br />
	<strong style="font-size:17px"></strong></td>	
</tr>
<!--<tr>
	<td>Pilih periode lain</td>
	<td>                        
	<select name="sel_periode" id="sel_periode" onchange="javascript:ubah_cabang()">
	<?=@$s_opsi_set?>
	</select>
	</td>
</tr>-->
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
	<td>Max Jam Kerja (Saat Ini)</td>
	<td>Max Hari Kerja (Saat Ini)</td>
	<td>Max Jam Kerja</td>
	<td>Max Hari Kerja</td>
</tr><?=@$s_data_penjualan?>
</table>
		</div>
		<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>