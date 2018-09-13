<?
include "includes/top_blank_logout.php";
?>
<!--<div style="background-image:url('images/icon-large-calculator-money.png'); background-repeat:no-repeat; background-position:left center; width:100%; float:left;">-->
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
	<td></td>
	<td><input type="hidden" name="periode" id="periode" value="<?=@$periodeid_terbaru?>" /></td>
</tr>
</table>
</div>
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Toko</td>
	<td>Komisi Tetap (Rp)</td>
	<td>Komisi Variabel (Rp)</td>
	<td>Komisi Campaign (Rp)</td>
	<td>Komisi Poin (Rp)</td>
	<td>Komisi Special Campaign (Rp)</td>
	<td>Komisi Total (Rp)</td>
	<td>PPh21 (Rp)</td>
	<td>Komisi Final (Rp)</td>
</tr><?=@$s_data_komisi?>
<tr>
	<td colspan="15"><input type="button" name="b_itung" id="b_itung" value="Verified" onclick="hitung_ulang();void(0)" style="width:300px; float:Right; background-color:green" class="tombol-harus-difilter" /></td>
</tr>
</table>
<?
include "includes/bottom.php";
?>