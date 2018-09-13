<?
include "includes/top_blank.php";
?>
<script src="js/srv/data-pph.php.js"></script>
<div style="background-image:url('images/18-512.png'); background-repeat:no-repeat; background-position:center; ">
	<p>Anda akan memulai proses perhitungan komisi final setelah dipotong PPh21:
	<ul>
		<li>Upload data PPh21.<br />Data PPh21 berisi daftar nama spg/m kemudian isikan jumlah PPh21, template dapat di-download ulang <a href="javascript:download()" style="color:blue; font-weight:900">disini</a>.</li>
		<li>Proses perhitungan Komisi FInal.<br />Perhitungan Komisi Final akan menghitung total komisi dikurangi dengan PPh21.</li>
	</ul>
	</p>
	<p>Kedua proses tersebut di atas, hanya akan dilakukan cukup dengan 1 (satu) klik pada tombol khusus di halaman berikutnya. <strong>Apakah Anda akan melanjutkan proses ini ?</strong></p>
	<div style="text-align:center">
	<input type="button" id="b_tutup" value="Batalkan Proses" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<img src="images/b0216.gif" style="height:47px; margin:0px 7px 0px 7px" />
	<input type="button" id="b_lanjut" value="Lanjutkan Proses" onclick="location.href='pajak-2.php?area=<?=$_REQUEST['area']?>'" style="width:157px; background-color:green; color:#FFF" />
	<input type="hidden" id="area" value="<?=$_REQUEST['area']?>" />
	</div>
</div>
<?
include "includes/bottom_blank.php";
?>