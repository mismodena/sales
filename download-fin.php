<?
include "includes/top_blank.php";

$cabang = @$_REQUEST["area"];

if( $cabang == "" ) goto Skip;

$data_tpk =  sqlsrv_fetch_array(
			komisi::load_data_periode(array("[id]" => array("=", "'" . main::formatting_query_string(@$_REQUEST["periodeid"]) . "'" )), array("periode" => "desc"))
			);
$formatted_periode = /*$data_tpk["periode"]->format("d") . " " .*/ $arr_month[ (int)$data_tpk["periode"]->format("m") ] . " " . $data_tpk["periode"]->format("Y");
?>
<script>
function download(){
	var cb1 = document.getElementById('cb1');
	//var cb2 = document.getElementById('cb2');
	var mode;

	if( cb1.checked ) mode = cb1.value;
	//if( cb2.checked ) mode = cb2.value;

	if( mode == 'detail' )	ubah_ke_tampilan_loading('Memulai proses reporting detail SPG/M.');
	jalankan_proses_di_iframe('download-fin.php?c='+mode+'&area=<?=$cabang?>&periodeid=<?=@$_REQUEST["periodeid"]?>');
}
</script>
<style>
label{padding-left:7px; font-weight:900}
li{list-style-type:none}
#menu_bar_nya{display:none !important}
</style>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; height:97%;">
	<p style="padding:27px 0px 37px 0px ">Anda akan men-download report komisi SPG/M dalam bentuk file excel untuk : 
	<br />Cabang <strong><?=strtoupper($cabang)?></strong><br />Periode komisi <strong><?=strtoupper($formatted_periode)?></strong>. <br /><br />
	Klik opsi report berikut ini untuk mulai men-download :
	<ul style="margin-top:-47px; margin-left:-27px">
		<li><input type="radio" name="cb" id="cb1" value="ringkas" checked><label for="cb1">Report Finance</label><br /><div style="padding-left:27px">Download reporting excel berisi baris data SPG/M dengan informasi target, realisasi, komisi fix, komisi, komisi campaign, komisi total dan lain-lain.</div></li>
		<!--<li><input type="radio" name="cb" id="cb2" value="detail"><label for="cb2">Report Akunting</label><br /><div  style="padding-left:27px">Download report excel yang berisi detail lengkap perhitungan komisi SPG/M termasuk rincian item penjualan, kuantitas dan harganya masing-masing. Data SPG/M dipisahkan dalam sheet yang berbeda di report excel (nama sheet dalam nama SPG/M).</div></li>
	-->
	</ul>
	</p>
	<div style="text-align:center; padding-top:37px">
	<input type="button" id="b_tutup" value="Tutup Jendela" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Download" onclick="download()" style="width:157px; background-color:green; color:#FFF" />
	</div>
</div>
<?
Skip:

include "includes/bottom_blank.php";
?>