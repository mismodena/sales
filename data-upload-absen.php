<?
include "includes/top.php";

$sql = "select * from flow_absensi where area='".@$default_area."' and periode=".@$arr_selected_tpk["id"];
$rsCek = sql::execute($sql);
$cek = sqlsrv_num_rows($rsCek);
?>
<table id="table-setting">
<tr>
	<td colspan="2" style="padding-bottom:17px">Berikut adalah data absensi periode <span style="background-color:yellow; font-weight:bold;"><?=@$periode?></span>
			<br />Gunakan form berikut untuk mengupload data absen mitra.
			<br />Template excel dapat diunduh pada tautan <a href="javascript:greylayer('download-absen-mitra.php?area=<?=@$default_area?>', 697, 517, true)" style="color:blue;">berikut ini</a>, setelah proses perhitungan komisi penjualan.
			<br />Untuk mengunggah dan memulai perhitungan poin spg mitra bisa dilakukan 
			<? if($cek > 0)
					echo " <span style=\"text-decoration:line-through\">disini.</span>";
			   else
					echo "<a href=\"javascript:greylayer('absensi-1.php?area=".@$default_area."', 697, 517, true)\" style=\"color:blue;\">disini.</a>"; 
			?>
			<br />Data yang telah diunggah akan muncul pada form dibawah berdasarkan area.
			
	<strong style="font-size:17px"></strong></td>	
	<td align="center"><a href="javascript:download_report();void(0)"  style="color:blue;"><img src="images/excel.png" style="border:none; width:137px; padding:0px 0px 0px 0px" /><br />Download report</a></td>

</tr>
<tr>
	<td>Cabang / Area</td>
	<td><select name="area" id="area" onchange="javascript:ubah_cabang()"><?=@$s_area?></select></td>
	<td></td>
</tr>
<tr >
	<td colspan=3 style="padding-top:35px;">
	<? if($cek > 0)
			echo "<strong style=\"color:red;\">Perhitumgan sudah selesai untuk cabang tersebut.</strong>";
	   else{
		   if(is_null($_SESSION["area"])){
			echo "Jika perhitungan sudah sesuai, silahkan klik tombol selesai untuk mengirimkan email ke pusat dan data tidak bisa diupload kembali. 
				<input type=\"button\" name=\"kirim\" id=\"kirim\" value=\"selesai\" onclick=\"javascript:greylayer('done_absensi-1.php?area=".@$default_area."&periode=".@$arr_selected_tpk["id"]."', 697, 267, true)\" style=\"width:150px; heigth:50px;background-color:green; color:#FFF\" />";
		   }
		   else{
			   echo "";
		   }
	   }
	?>
	</td>
</tr>
</table>
</div>
<!--<div style="float:right">
		<input type="button" id="b_reset" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" /><br />
		</div>-->
<div style="float:left; width:100%; margin:17px">
<table id="table-data" >
<tr>
	<td>No.</td>
	<td>Nama SPG/M</td>
	<td>Toko</td>
	<td>Jam Kerja</td>
	<td>Hari Kerja</td>
	<td>Training</td>
	<td>Poin Jam Kerja</td>
	<td>Poin Hari Kerja</td>
	<td>Poin Training</td>
	<td>Poin Omzet</td>
	<td>Poin Total</td>
	<td>Komisi Poin (Rp)</td>
	<td>Komisi Special Campaign (Rp)</td>
	<td>Potongan Selisih (Rp)</td>
</tr><?=@$s_data_komisi?>
</table>
		</div>
		<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom.php";
?>