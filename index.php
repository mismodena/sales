<?
include "includes/top.php";
?>
<div style="background-image:url('images/icon-large-calculator-money.png'); background-repeat:no-repeat; background-position:left center; width:100%; float:left;">
<table id="table-setting">
<tr>
	<td><strong>Periode Perhitungan Komisi</strong></td>
	<td><strong><?=@$periode?></strong></td>
	<td rowspan="6" align="center"><a href="javascript:download_report();void(0)"  style="color:blue;"><img src="images/excel.png" style="border:none; width:137px; padding:0px 77px 0px 77px" /><br />Download report komisi</a></td>
</tr>
<tr>
	<td><strong>Tanggal Perhitungan Komisi</strong></td>
	<td><strong><?=@$tanggal_perhitungan_komisi?></strong></td>
</tr>
<tr>
	<td>Cabang / Area</td>
	<td><select name="sel_area" id="sel_area" onchange="javascript:ubah_filter_komisi()"><?=@$s_area?></select></td>
</tr>
<tr>
	<td>Pilih periode lain</td>
	<td>                        
	<select name="sel_periode" id="sel_periode" onchange="javascript:ubah_filter_komisi()">
	<?=@$s_opsi_tpk?>
	</select>
	</td>
</tr>
<tr><td colspan="2" style="padding-top:13px"></td></tr>
<tr>
	<td colspan="2" style="padding-top:13px; border-top:solid 1px #666;"><span id="label_hitung_ulang">Klik tombol berikut untuk perhitungan ulang komisi SPG/M </span>
	<input type="button" name="b_itung" id="b_itung" value="Hitung Ulang Komisi" onclick="hitung_ulang();void(0)" style="width:200px; margin-left:13px" class="tombol-harus-difilter" /></td>
</tr>
</table>
</div>
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Alamat</td>
	<td>Toko</td>
	<!--<td>Kelas</td>-->
	<td>Target (Rp)</td>
	<td>Realisasi (Rp)</td>
	<td>Realisasi (%)</td>
	<td>Komisi Tetap (Rp)</td>
	<td>Komisi Variabel (Rp)</td>
	<td>Komisi Campaign (Rp)</td>
	<td>Komisi Poin (Rp)</td>
	<td>Komisi Special Campaign (Rp)</td>
	<td>Komisi Total (Rp)</td>
	<td></td>
</tr><?=@$s_data_komisi?>
</table>
<?
include "includes/bottom.php";
?>