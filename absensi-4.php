<?
include "lib/mainclass.php";

// perhitungan komisi awal

set_time_limit(600);

$arr_proses = array(
	"Perhitungan Poin" => array("usp_hitung_poin_mitra '' ", "usp_hitung_poin_mitra '' "),
	"Perhitungan Komisi Poin" => array("usp_hitung_komisi_poin '' ", "usp_hitung_komisi_poin '' "),
);

if( @$_REQUEST["c"] == "") 
	$index_proses = 0;
else	
	$index_proses = @$_REQUEST["c"];

$arr_index_proses = array_keys($arr_proses);

$proses = $arr_proses[ $arr_index_proses[ $index_proses ] ];

foreach($proses as $sql)	$a = sql::execute("exec ". $sql .";");

echo "<script src=\"js/main.js\"></script><script>";
	
if( $index_proses >= count( $arr_index_proses ) )	
	echo "
		parent.sembunyikan_kotak_loading();
		var isi = '['+ waktu_sekarang() +'] Selesai memproses perhitungan komisi poin mitra.<br />';
		isi += '['+ waktu_sekarang() +'] Memulai proses pengiriman email notifikasi ke cabang.';
		isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
		parent.document.getElementById('kontainer_status').innerHTML += isi;		
		location.href = 'absensi-5.php?area=".$_REQUEST['area']."';
	</script>";
else {
	echo "
		var isi = '<div style=\"margin:0px 0px 0px 17px; font-size:10px; line-height:17px\"><img src=\"images/checkbox-checked.png\" style=\"height:11px; margin-right:7px\" />Selesai memproses  ". strtolower($arr_index_proses[ $index_proses++ ]) .".</div>';
		parent.document.getElementById('kontainer_status').innerHTML += isi;
		". ($index_proses >= 6 ? "parent.document.getElementById('label_progress').innerHTML = 'Bentar lagi bro !';" : "" ) ."
		location.href = 'absensi-4.php?c=". $index_proses ."&area=".$_REQUEST['area']."';
	";
}
echo 	"</script>";

?>
