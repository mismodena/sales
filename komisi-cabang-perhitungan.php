<?
include "lib/mainclass.php";

set_time_limit(100);

$arr_proses = array(
	"Konfigurasi ulang Komisi" => array("usp_entri_komisi  '". $_REQUEST["area"] ."' "),
	"Konfigurasi ulang Level Diskon Dealer" => array("usp_update_komisi_kolom_level_diskon '". $_REQUEST["area"] ."' "),
	"Konfigurasi ulang Harga Net Dealer" => array("usp_update_harga_net '". $_REQUEST["area"] ."' "),
	"Perhitungan ulang Realisasi Penjualan Android" => array(
									"usp_update_komisi_kolom_realisasi_android '". $_REQUEST["area"] ."' ", 
									"usp_update_komisi_kolom_realisasi_campaign '". $_REQUEST["area"] ."' "
									),
	"Perhitungan ulang Komisi Fix" => array("usp_hitung_komisi_fix '". $_REQUEST["area"] ."' "), 
	"Perhitungan ulang Komisi Variabel" => array("usp_hitung_komisi_variabel '". $_REQUEST["area"] ."' "),
	"Perhitungan ulang Komisi Campaign" => array("usp_hitung_komisi_campaign '". $_REQUEST["area"] ."' "),
	"Perhitungan ulang Poin" => array("usp_hitung_poin_mitra '". $_REQUEST["area"] ."' "),
	"Perhitungan ulang Komisi Poin" => array("usp_hitung_komisi_poin '". $_REQUEST["area"] ."' ")
	);

if( @$_REQUEST["c"] == "") 
	$index_proses = 0;
else	
	$index_proses = @$_REQUEST["c"];

$arr_index_proses = array_keys($arr_proses);

$proses = $arr_proses[ $arr_index_proses[ $index_proses ] ];

foreach($proses as $sql)	$a = sql::execute("exec ". $sql .";");

echo "<script src=\"js/main.js\"></script><script>";

$index_proses++;
if( $index_proses >= count( $arr_index_proses ) )	
	echo "		
		parent.sembunyikan_kotak_loading();
		var isi = '['+ waktu_sekarang() +'] Selesai perhitungan ulang komisi SPG/M.<br /><br />';
		isi += '<input type=\"button\" value=\"Tutup Jendela\" onclick=\"parent.TINY.box.hide();parent.document.location.href=\'index.php?area=". @$_REQUEST["area"] ."\'\" style=\"width:177px; background-color:green\" />';
		parent.document.getElementById('kontainer_status').innerHTML += isi;
		parent.document.getElementById('img_progress').setAttribute('src', 'images/thumbsup.gif');
		parent.document.getElementById('label_progress').innerHTML = 'Siippp.. dah kelar bro !';
	";
else
	echo "
		var isi = '<div style=\"margin:0px 0px 0px 17px; font-size:10px; line-height:17px\"><img src=\"images/checkbox-checked.png\" style=\"height:11px; margin-right:7px\" />Selesai memproses  ". strtolower($arr_index_proses[ $index_proses ]) .".</div>';
		parent.document.getElementById('kontainer_status').innerHTML += isi;
		". ($index_proses >= 6 ? "parent.document.getElementById('label_progress').innerHTML = 'Bentar lagi bro !';" : "" ) ."
		location.href = 'komisi-cabang-perhitungan.php?c=". $index_proses ."&area=". $_REQUEST["area"] ."';
	";
echo 	"</script>";
?>