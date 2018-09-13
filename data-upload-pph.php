<?
include "includes/top_blank_logout.php";

$sql = "select * from flow_absensi where area='".@$default_area."' and periode=".@$arr_selected_tpk["id"];
$rsCek = sql::execute($sql);
$cek = sqlsrv_fetch_array($rsCek);
?>
<table id="table-setting">
<tr>
	<td colspan="2" style="padding-bottom:17px">Berikut adalah data PPh21 Komisi periode <span style="background-color:yellow; font-weight:bold;"><?=@$periode?></span>
			<br />Gunakan form berikut untuk mengupload data PPh21.
			<br />Template excel dapat diunduh pada tautan <a href="javascript:greylayer('download-komisi-pph.php?area=<?=@$default_area?>', 697, 517, true)" style="color:blue;">berikut ini</a>, setelah semua proses perhitungan komisi selesai.
			<br />Untuk mengunggah data PPh21 bisa dilakukan 
			<? if(@$cek['fPph']>0)
					echo " <span style=\"text-decoration:line-through\">disini.</span>";
			   else
					echo "<a href=\"javascript:greylayer('pajak-1.php?area=".@$default_area."', 697, 517, true)\" style=\"color:blue;\">disini.</a>"; 
			?>
	<strong style="font-size:17px"></strong></td>	
</tr>
<tr>
	<td>Cabang / Area</td>
	<td><select name="area" id="area" onchange="javascript:ubah_cabang()"><?=@$s_area?></select></td>
</tr>
<td colspan=3 style="padding-top:35px;">
	<? if(@$cek['fPph']>0)
			echo "<strong style=\"color:red;\">Perhitumgan sudah selesai untuk cabang tersebut.</strong>";
	   else
			echo "Jika perhitungan sudah sesuai, silahkan klik tombol selesai untuk mengirimkan email ke pusat dan data tidak bisa diupload kembali. 
				<input type=\"button\" name=\"kirim\" id=\"kirim\" value=\"selesai\" onclick=\"javascript:greylayer('done_pajak-1.php?area=".@$default_area."&periode=".@$arr_selected_tpk["id"]."', 697, 267, true)\" style=\"width:150px; heigth:50px;background-color:green; color:#FFF\" />";
	?>
	</td>
</table>
</div>
<!--
<div style="float:right">
		<input type="button" id="b_reset" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" /><br />
		</div>
		<div style="float:left; width:100%; margin:17px">
		-->
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Toko</td>
	<td>Npwp</td>
	<td>Total Komisi (Rp)</td>
	<td>PPh21 (Rp)</td>
	<td>Komisi Final (Rp)</td>
</tr><?=@$s_data_komisi?>
</table>
		</div>
		<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>