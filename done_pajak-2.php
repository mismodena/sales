<?
include "lib/mainclass.php";

// pengiriman email notifikasi ke cabang
set_time_limit(100);

$pesan = file_get_contents("template/notifikasi-pph-tm.html");
$subject = "Download Report Mitra Modena Cabang ".$_REQUEST['area'];

komisi::update_flow($_REQUEST['area'],$_REQUEST['periode']);

//foreach($arr_email_app as $email)	
main::send_email($email_tm, $subject, $pesan);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses proses pengiriman email notifikasi ke tm.<br /><br />';
isi += '<input type=\"button\" value=\"Tutup Jendela\" onclick=\"parent.TINY.box.hide();parent.document.location.href=\'data-upload-pph.php\'\" style=\"width:177px; background-color:green\" />';
parent.document.getElementById('kontainer_status').innerHTML += isi;
parent.document.getElementById('img_progress').setAttribute('src', '');
parent.document.getElementById('label_progress').innerHTML = '';
</script>";

?>