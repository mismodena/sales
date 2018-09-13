<?
// BIKIN DI SCHEDULED TASK

// hanya di tanggal 1
if( date("j") != 1) exit;

// prosedur :
// 1. buat file template
// 2. kirim email notifikasi, dengan file template jadi attachment-nya


if( !isset( $_REQUEST["c"] ) )
	goto Tahap_1;
else
	goto Tahap_2;



Tahap_1:

	$_REQUEST["c"] = date("Ymd");
	include "buat-file-template.php";
	header("location:". $page ."?c=" . $_REQUEST["c"]);
	
	exit;
	
Tahap_2:

	include "lib/var.php";
	include "lib/cls_main.php";
	
	$akunting_to = AKUNTING_TO;
	$pesan = file_get_contents("template/notifikasi-akunting.html");
	$subject = "[URGENT] upload data item campaign - komisi SPG/M";
	$lampiran = array("temp/data-item-campaign-". $_REQUEST["c"] .".xls");
	
	main::send_email($akunting_to, $subject, $pesan, $lampiran);
	
	unlink($lampiran[0]);
	
	exit;

?>