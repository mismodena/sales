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
function mulai(){
	ubah_ke_tampilan_loading('Mulai proses konfigurasi komisi.');
	jalankan_proses_di_iframe('komisi-cabang-perhitungan.php?area=<?=$cabang?>');
}
</script>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; height:97%;">
	<p style="padding:107px 0px 37px 0px ">Anda akan memulai proses perhitungan ulang komisi SPG/M dengan informasi sebagai berikut : 
	<br />Cabang <strong><?=$cabang?></strong><br />Periode komisi <strong><?=$formatted_periode?></strong>. <br /><br />
	<strong>Note</strong> : Apabila ada data SPG/M yang belum lengkap, Anda dapat mengulangi proses perhitungan ulang ini kapan saja, 
	selama belum ganti bulan perhitungan komisi yang baru..  so easy & fleksibel bangget.<br /><br />
	<strong>Apakah Anda akan melanjutkan proses ini ?</strong></p>
	<div style="text-align:center">
	<input type="button" id="b_tutup" value="Batalkan Proses" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Lanjutkan Proses" onclick="mulai()" style="width:157px; background-color:green; color:#FFF" />
	</div>
</div>
<?
Skip:

include "includes/bottom_blank.php";
?>