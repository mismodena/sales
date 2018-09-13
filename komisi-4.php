<?
include "lib/mainclass.php";

// perhitungan komisi awal

set_time_limit(600);

$arr_proses = array(
	"Konfigurasi Periode" => array("usp_entri_periode"),	
	"Impor Data Penjualan dari android" => array("usp_tabel_penjualan '' ", "usp_tabel_penjualan_detail"),
	"Konfigurasi Komisi" => array("usp_entri_komisi '' ", "usp_penjualan_detail_ringkas '' "),
	"Konfigurasi Level Diskon Dealer" => array("usp_update_komisi_kolom_level_diskon '' "),
	"Konfigurasi Harga Net Dealer" => array("usp_update_harga_net '' "),
	"Perhitungan Realisasi Penjualan Android" => array("usp_update_komisi_kolom_realisasi_android '' ", "usp_update_komisi_kolom_realisasi_campaign '' "),
	"Perhitungan Komisi Fix" => array("usp_hitung_komisi_fix '' "), 
	"Perhitungan Komisi Variabel" => array("usp_hitung_komisi_variabel '' "),
	"Perhitungan Komisi Campaign" => array("usp_hitung_komisi_campaign '' "),
	"Konfigurasi Tarif Dealer" => array("usp_insert_tarif ") //insert tarif Dealer
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
		var isi = '['+ waktu_sekarang() +'] Selesai memproses perhitungan komisi SPG/M awal.<br />';
		isi += '['+ waktu_sekarang() +'] Memulai proses pengiriman email notifikasi ke cabang.';
		isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
		parent.document.getElementById('kontainer_status').innerHTML += isi;		
		location.href = 'komisi-5.php';
	";
else
	echo "
		var isi = '<div style=\"margin:0px 0px 0px 17px; font-size:10px; line-height:17px\"><img src=\"images/checkbox-checked.png\" style=\"height:11px; margin-right:7px\" />Selesai memproses  ". strtolower($arr_index_proses[ $index_proses ]) .".</div>';
		parent.document.getElementById('kontainer_status').innerHTML += isi;
		". ($index_proses >= 6 ? "parent.document.getElementById('label_progress').innerHTML = 'Bentar lagi bro !';" : "" ) ."
		location.href = 'komisi-4.php?c=". $index_proses ."';
	";
echo 	"</script>";

?>