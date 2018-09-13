<?
include "includes/top.php";
?>
<div style="background-image:url('images/market-store-icon.jpg'); background-repeat:no-repeat; background-position:left center; width:100%; float:left;">
<table id="table-setting">
<tr>
	<td colspan="2" style="padding-bottom:17px">Berikut adalah data kelas dealer yang digunakan untuk perhitungan komisi SPG/M. Sistem secara otomatis akan menghitung ulang data kelas dealer periodik per kuartal (pada bulan ke-1, 4, 7 dan 10) dengan acuan rata-rata omset dealer selama 3 bulan ke belakang dari basis bulan perhitungan.</td>
</tr>
<tr>
	<td><strong>Periode Kelas Dealer Berlaku</strong></td>
	<td><strong id="periode_kelas_dealer"></strong></td>
</tr>
<tr>
	<td><strong>Rata-Rata Omset Periode</strong></td>
	<td><strong id="rata_rata_omset_periode"></strong></td>
</tr>
<tr>
	<td>Cari Dealer</td>
	<td><input type="text" name="cari" id="cari" value="<?=@$_REQUEST["cari"]?>" style="width:177px" />
	<input type="button" name="b_cari" id="b_cari" value="Cari" onclick="kelas_dealer(true);" style="width:77px; margin-left:13px" /></td>
</tr>
<tr><td colspan="2" style="padding-top:13px"></td></tr>
<tr>
	<td colspan="2" style="padding-top:13px; border-top:solid 1px #666;">
	</td>
</tr>
</table>
</div>
<div style="float:right; width:100%; text-align:right; margin:0px 37px 13px 37px; ">
<table align="right" style="float:right">
	<tr>
		<td><strong>Total : <?=sqlsrv_num_rows( $rs )?> data</strong> | </td>
		<td>Tampilan Per Halaman : </td>
		<td><select name="s_perhalaman" id="s_perhalaman" style="width:57px;" onchange="kelas_dealer(true)">
				<?= main::__set_option( $arr_data_perpage, @$_REQUEST["s_perhalaman"]) ?>
			</select></td><td> data | 
			Pergi ke halaman : </td><td>
			<select name="s_halaman" id="s_halaman" style="width:57px" onchange="kelas_dealer()">
				<?= main::__set_option( range(1, $page_total), @$_REQUEST["s_halaman"]) ?>
			</select></td>
	</tr>
</table>
</div>
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Kode ACCPAC</td>
	<td>Nama Dealer</td>
	<td>Omset (Rp)</td>
	<td>Kelas</td>
</tr><?=@$s_data_kelas?>
</table>
<?
include "includes/bottom.php";
?>