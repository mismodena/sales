<?
include "includes/top_blank_logout.php";
?>
<!--<div style="background-image:url('images/icon-large-calculator-money.png'); background-repeat:no-repeat; background-position:left center; width:100%; float:left;">-->
<table id="table-setting">
<tr>
	<td><strong>Periode Perhitungan Komisi</strong></td>
	<td><strong><?=@$periode?></strong></td>
	<td rowspan="6" align="center"><div id="btnDown"><a href="javascript:download_report();void(0)"  style="color:blue;"><img src="images/excel.png" style="border:none; width:137px; padding:0px 77px 0px 77px" /><br />Download report komisi</a></div></td>
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
	<td>NPWP</td>
	<td>Bank</td>
	<td>Nomor rekening</td>
	<td>Komisi (Rp)</td>
	<td>PPh21 (Rp)</td>
	<td>Komisi yang dibayarkan (Rp)</td>
</tr><?=@$s_data_komisi?>
</table>
<?
include "includes/bottom.php";
?>