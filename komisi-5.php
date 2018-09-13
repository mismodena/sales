<?
include "lib/mainclass.php";

// pengiriman email notifikasi ke cabang
set_time_limit(100);

$pesan = file_get_contents("template/notifikasi-cabang.html");
$subject = "[URGENT] koreksi data komisi SPG/M";

foreach($arr_email_cabang as $email)	main::send_email($email, $subject, $pesan);

echo "
<script src=\"js/main.js\"></script>
<script>
parent.sembunyikan_kotak_loading();
var isi = '['+ waktu_sekarang() +'] Selesai memproses proses pengiriman email notifikasi ke cabang.<br /><br />';
isi += '<input type=\"button\" value=\"Tutup Jendela\" onclick=\"parent.TINY.box.hide();parent.document.location.href=\'data-item-campaign.php\'\" style=\"width:177px; background-color:green\" />';
parent.document.getElementById('kontainer_status').innerHTML += isi;
parent.document.getElementById('img_progress').setAttribute('src', 'images/thumbsup.gif');
parent.document.getElementById('label_progress').innerHTML = 'Siippp.. dah kelar bro !';
</script>";

?>