<?
include "lib/mainclass.php";
require_once dirname(__FILE__) . "/lib/excel/PHPExcel.php";

set_time_limit(100);

$data_periode =  sqlsrv_fetch_array( komisi::load_data_periode( array() , array("periode" => "desc")) );
$id_periode = $data_periode['id'];

$sql = "select newid()";
$data = sqlsrv_fetch_array(sql::execute( $sql ));
$id_baru = $data[0];

$folder = "file_absen/";

foreach($_FILES as $file => $arr_properti){
	if( $arr_properti["error"] == UPLOAD_ERR_OK ){
		$asal = $_FILES[ $file ]["tmp_name"];
		$tujuan = $id_periode."_".$_SESSION["user_login"]."_".$_FILES[ $file ]["name"];
		move_uploaded_file($asal, $folder . $tujuan);
	}
}
$file_excel = $folder . $tujuan;

$excelReader = PHPExcel_IOFactory::createReaderForFile($file_excel);
$excelReader->setReadDataOnly();
$excelReader->setLoadAllSheets();

$excelObj = $excelReader->load($file_excel);
$sheet = $excelObj->getActiveSheet()->toArray(null, true,true,true);

$numrow=1;
foreach($sheet as $row){
	
	if ($numrow > 2) {
		$no = $row['A']; 
		$nik = $row['B']; 
		$jam_kerja = $row['F']==''?0:$row['F']; 
		$hari_kerja = $row['G']==''?0:$row['G']; 
		$training = $row['H']==''?0:$row['H']; 
		$spesial = $row['I']==''?0:str_replace(",", "", $row['I'] ); 
		$potongan = $row['J']==''?0:str_replace(",", "", $row['J'] ); 
		
		if($jam_kerja==0 && $hari_kerja==0 &&  $training==0 && $spesial==0 && $potongan==0 ) continue;
		
		$sql = "select *, dbo.ambil_nilai(nama_user) namaUser, dbo.ambil_kode(alamat_user) tp from openquery(MYSQLDMZ, 'select a.*, b.area, b.store from nolppco_modena.`user` a
				inner join nolppco_modena.area_store b on a.idarea = b.idarea where a.status = 1') where nik = '".$nik."'";
		$data = sqlsrv_fetch_array(sql::execute( $sql ));
		$id_user = $data["id_user"];
		
		$sql = "select * from komisi where id_user =".$id_user." and periode =".$id_periode;
		$komisi = sqlsrv_fetch_array(sql::execute( $sql ));
		if(empty($komisi)){
			$sqlC = "INSERT INTO komisi(id_user,periode,nama_user,username,alamat_user,store,area,[target],tipe_promoter,level_diskon,
					realisasi_android,realisasi_adjustment,realisasi_campaign,komisi_fix,komisi_variabel,komisi_campaign,oleh,tanggal,komisi_poin,komisi_spesial,pph,potongan)
					VALUES(".$data["id_user"].",".$id_periode.",'".$data["namaUser"]."','".$data["username"]."','".$data["alamat_user"]."','".$data["store"]."',
					'".$data["area"]."',0,'".$data["tp"]."',0,0,0,0,0,0,0,NULL,'".date("Y-m-d h:m:s")."',NULL,NULL,NULL,NULL);";
			
		}else{
			$sqlC = "";
		}
		
		$sql = "select * from absensi where id_user =".$id_user." and periode =".$id_periode;
		$data = sqlsrv_fetch_array(sql::execute( $sql ));
		
		if(empty($data)){
			$sqlC .= "insert into absensi ([id_user],[periode],[jam_kerja],[hari_kerja],[training]) 
						values (".$id_user.",".$id_periode.",".$jam_kerja.",".$hari_kerja.",".$training.");";
		}else{
			$sqlC .= "update absensi set [jam_kerja]=".$jam_kerja.", [hari_kerja]=".$hari_kerja.", [training]=".$training."
						where [id_user]=".$id_user." and [periode]=".$id_periode.";";
		}
		
		$sqlC .= "update komisi set komisi_spesial = ".$spesial.", 
						potongan = ".$potongan." 
				where id_user =".$id_user." and periode =".$id_periode;
		
		//$sqlAll .= "insert into absensi values (".$id_user.",".$id_periode.",".$jam_kerja.",".$training.");";
		
		sql::execute( $sqlC );
		
		// echo "<script>
		// parent.sembunyikan_kotak_loading();
		// var isi = '['+ waktu_sekarang() +'] $no - $sqlC<br />';
		// parent.document.getElementById('kontainer_status').innerHTML += isi;
		// </script>";
	}
	 $numrow++; 
}

//sql::execute( $sqlAll );

//unlink($file_excel);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses upload data absensi mitra. <br />';
isi += '['+ waktu_sekarang() +'] Memulai proses perhitungan komisi absensi mitra.';
isi += '<img src=\"images/loading_box.gif\" style=\"border:none; height:7px\" class=\"kotak-loading\" /><br />';
parent.document.getElementById('kontainer_status').innerHTML += isi;
parent.document.getElementById('label_progress').innerHTML = 'Sabar yah bro !';
location.href = 'absensi-4.php?area=".$_REQUEST['area']."';
</script>";

?>