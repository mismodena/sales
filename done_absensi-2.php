<?
include "lib/mainclass.php";

// pengiriman email notifikasi ke cabang
set_time_limit(100);

$pesan = file_get_contents("template/notifikasi-cabang-tm.html");
$subject = "Input PPh21 Mitra Modena Cabang ".$_REQUEST['area'];

komisi::insert_flow($_REQUEST['area'],$_REQUEST['periode']);

//foreach($arr_email_app as $email)	
main::send_email($email_pph, $subject, $pesan);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses proses pengiriman email notifikasi ke pusat.<br /><br />';
isi += '<input type=\"button\" value=\"Tutup Jendela\" onclick=\"parent.TINY.box.hide();parent.document.location.href=\'data-upload-absen.php\'\" style=\"width:177px; background-color:green\" />';
parent.document.getElementById('kontainer_status').innerHTML += isi;
parent.document.getElementById('img_progress').setAttribute('src', '');
parent.document.getElementById('label_progress').innerHTML = '';
</script>";

?>