<?
include "lib/mainclass.php";

set_time_limit(200);

$arr_set = array (
		"jam_kerja"=>array("max"=>208, "poin"=>15),
		"hari_kerja"=>array("max"=>26, "poin"=>15),
		"training"=>array("max"=>1, "poin"=>10),
		"omzet"=>array("max"=>1, "poin"=>60),
);
$tarif = 47000;


$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
$id_periode = $data_periode['id'];

$sql = "select [id_user],[periode],[jam_kerja],[hari_kerja],[training] from absensi where periode =".$id_periode;
$rs = sql::execute( $sql );
while($data = sqlsrv_fetch_array($rs)){
	$poin_jk = floor($data["jam_kerja"] / $arr_set["jam_kerja"]["max"] * $arr_set["jam_kerja"]["poin"]);
	$poin_hk = floor($data["hari_kerja"] / $arr_set["hari_kerja"]["max"] * $arr_set["hari_kerja"]["poin"]);
	$poin_tr = floor($data["training"] / $arr_set["training"]["max"] * $arr_set["training"]["poin"]);
	
	$sql = "select [target], realisasi_android from komisi where periode =".$id_periode." and id_user=".$data["id_user"];
	$komisi = sqlsrv_fetch_array( sql::execute( $sql ));
	
	$poin_omzet = floor($komisi["realisasi_android"] / $komisi["target"] * $arr_set["omzet"]["poin"]);
	
	// set max
	$poin_jk = $poin_jk > $arr_set["jam_kerja"]["poin"]?$arr_set["jam_kerja"]["poin"]:$poin_jk;
	$poin_hk = $poin_hk > $arr_set["hari_kerja"]["poin"]?$arr_set["hari_kerja"]["poin"]:$poin_hk;
	$poin_tr = $poin_tr > $arr_set["training"]["poin"]?$arr_set["training"]["poin"]:$poin_tr;
	$poin_omzet = $poin_omzet > $arr_set["omzet"]["poin"]?$arr_set["omzet"]["poin"]:$poin_omzet;
	$poin_total = $poin_jk + $poin_hk + $poin_tr + $poin_omzet;
	$komisi_poin = $poin_total * $tarif;
	
	
	$sql = "update absensi set poin_jk=".$poin_jk.", poin_hk=".$poin_hk.
			", poin_tr=".$poin_tr.", poin_omzet=".$poin_omzet.", poin_total=".$poin_total.
			" where periode =".$id_periode." and id_user=".$data["id_user"];
	sql::execute( $sql );
	
	$sql = "update komisi set komisi_poin=".$komisi_poin.
			" where periode =".$id_periode." and id_user=".$data["id_user"];
	sql::execute( $sql );
}


echo "<script src=\"js/main.js\"></script><script>	
		parent.sembunyikan_kotak_loading();
		var isi = '['+ waktu_sekarang() +'] Selesai memproses perhitungan komisi poin mitra.<br />';
		isi += '['+ waktu_sekarang() +'] Memulai proses pengiriman email notifikasi ke cabang.';
		isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
		parent.document.getElementById('kontainer_status').innerHTML += isi;		
		location.href = 'absensi-5.php';
	</script>";

?>