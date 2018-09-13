<?
include "includes/top_blank.php";
?>
<script src="js/srv/data-item-campaign.php.js"></script>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; ">
	<p>Anda akan memulai proses awal perhitungan komisi SPG/M. Urutan prosesnya adalah sebagai berikut:
	<ul>
		<li>Upload data item campaign.<br />Data item campaign didapatkan dari departemen Product Marketing (hubungi ekstensi 92009, 92001 atau 95103). Data item campaign ini harus diformat dalam bentuk template file excel yang telah dikirimkan melalui email notifikasi perhitungan komisi ataupun dapat di-download ulang <a href="javascript:download()" style="color:blue; font-weight:900">disini</a>.</li>
		<li>Proses perhitungan komisi baru berdasarkan data yang didapatkan dari data penjualan Android.<br />Data perhitungan komisi periode sebelumnya akan ditutup sehingga tidak dapat dilakukan perhitungan ulang dan hanya dapat dilihat tanpa bisa diubah lagi. Proses perhitungan komisi awal ini akan diverifikasi oleh tim Admin Sales cabang.</li>
		<li>Pengiriman notifikasi email ke sales admin cabang.<br />Email notifikasi dikirimkan untuk menginformasikan ke sales admin cabang bahwa proses verifikasi data penjualan SPG/M sudah dapat dilakukan.</li>
	</ul>
	</p>
	<p>Ketiga proses tersebut di atas, hanya akan dilakukan cukup dengan 1 (satu) klik pada tombol khusus di halaman berikutnya. <strong>Apakah Anda akan melanjutkan proses ini ?</strong></p>
	<div style="text-align:center">
	<input type="button" id="b_tutup" value="Batalkan Proses" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Lanjutkan Proses" onclick="location.href='komisi-2.php'" style="width:157px; background-color:green; color:#FFF" />
	</div>
</div>
<?
include "includes/bottom_blank.php";
?>