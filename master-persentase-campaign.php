<?
include "includes/top.php";
?>
<div>
	<div style="margin-bottom:13px; border-bottom:1px #CCC solid; width:100%; background:url('images/percentage-512.png'); background-repeat:no-repeat; background-position:center left; text-align:center">
		<div style="float:left; text-align:left; padding-left:233px;">
			<p><h3 style="color:red">Note :</h3>
			<ul>
				<li>Isikan sebagian nama item pada isian "Item" dan besaran persentase komisi pada isian "Persentase Komisi".<br />
				Gunakan karakter "<strong style="font-size:27px">.</strong>" (titik sebagai pemisah desimal pada isian "Persentase Komisi").</li>
				<li>Klik tombol "Tambah Item" untuk menambahkan baris data persentase komisi.</li>
				<li>Jangan Lupa untuk menyimpan hasil perubahan dengan mengklik tombol "Simpan Data".</li>
				<li>Untuk menghapus data, kosongkan semua isian di baris yang akan dihapus.</li>
			</p>
		</div>
	</div>
	<div style="float:left">
		<input type="button" name="b_tambah" id="b_tambah" 
			value="Tambah Item" onclick="javascript:tambah()" 
			style="width:233px; background-color:yellow; color:#333"  />
	</div>
	<div style="float:right">
		<input type="button" id="b_reset" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" /><br />
		</div>
	<div style="float:left; width:100%; margin:17px">
		<table id="table-data">
			<tr>
				<td>No</td>
				<td>Item</td>
				<td>Persentase Komisi (%)</td>
			</tr>
			<?=@$s_konfigurasi ?>
		</table>
	</div>
	<div style="float:left">
		<input type="button" name="b_tambah_bawah" id="b_tambah_bawah" 
			value="Tambah Item" onclick="javascript:tambah()" 
			style="width:233px; background-color:yellow; color:#333"  />
	</div>
	<div style="float:right">
		<input type="button" id="b_reset_bawah" value="Reset Data" style="width:177px; background-color:red" 
			onclick="javascript:_reset()" />
		<input type="button" id="b_simpan_bawah" value="Simpan Data" style="width:177px; background-color:green" class="tombol-harus-difilter"
			onclick="javascript:simpan()" /><br />
		</div>
</div>
<?
include "includes/bottom.php";
?>