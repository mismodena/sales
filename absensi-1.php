<?
include "includes/top_blank.php";
?>
<script src="js/srv/data-absen-mitra.php.js"></script>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; ">
	<p>Anda akan memulai proses awal perhitungan komisi poin mitra. Urutan prosesnya adalah sebagai berikut:
	<ul>
		<li>Upload data absensi.<br />Data absensi berisi daftar nama spg mitra kemudian isikan jumlah jam kerja, template dapat di-download ulang <a href="javascript:download()" style="color:blue; font-weight:900">disini</a>.</li>
		<li>Proses perhitungan poin.<br />Perhitungan poin dilakukan berdasarkan data jam kerja, hari kerja, dan training serta poin omzet yang berdasrkan realisasi dan target.</li>
		<li>Proses perhitungan komisi poin.<br />Perhitungan komisi poin dilakukan berdasarkan total poin yang diperoleh dikalikan oleh tarif pada store.</li>
	</ul>
	</p>
	<p>Ketiga proses tersebut di atas, hanya akan dilakukan cukup dengan 1 (satu) klik pada tombol khusus di halaman berikutnya. <strong>Apakah Anda akan melanjutkan proses ini ?</strong></p>
	<div style="text-align:center">
	<input type="button" id="b_tutup" value="Batalkan Proses" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Lanjutkan Proses" onclick="location.href='absensi-2.php?area=<?=$_REQUEST['area']?>'" style="width:157px; background-color:green; color:#FFF" />
	<input type="hidden" id="area" value="<?=$_REQUEST['area']?>" />
	</div>
</div>
<?
include "includes/bottom_blank.php";
?>