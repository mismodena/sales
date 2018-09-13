<?
include "includes/top_blank.php";
?>
<script src="js/srv/data-absen-mitra.php.js"></script>
<script>
function verifikasi(){
	ubah_ke_tampilan_loading('Mulai proses kirim email.');
	jalankan_proses_di_iframe('done_absensi-2.php?c=mulai_proses&area=<?=$_REQUEST['area']?>&periode=<?=$_REQUEST['periode']?>');
}
</script>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; ">
	<p>Anda akan mengirimkan email bahwa upload absensi mitra modena sudah selesai untuk cabang <?=$_REQUEST['area']?>

	</p>
	<p><strong style="color:red;">Setelah email dikirim anda tidak dapat upload data kembali untuk cabang <?=$_REQUEST['area']?>.</strong> <strong>Apakah Anda akan melanjutkan proses ini ?</strong></p>
	<div style="text-align:center">
	<input type="button" id="b_tutup" value="Tutup Jendela" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Kirim Email" onclick="verifikasi()" style="width:157px; background-color:green; color:#FFF" />
	</div>
</div>
<?
include "includes/bottom_blank.php";
?>