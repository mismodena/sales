<?
include "includes/top_blank.php";
include "panduan-template-item-campaign.php";
?>
<script>
function verifikasi(){
	var f = document.getElementById('item-campaign');
	if( f.value == ''){alert('Mohon pilih file data item campaign yang telah diformat!\nFile harus dalam format excel.'); return false;}
	
	ubah_ke_tampilan_loading('Mulai proses upload data item campaign.');
	jalankan_proses_di_iframe('komisi-3.php?c=mulai_proses');
}
</script>
<p style="border-top:#CCC solid 1px; padding-top:13px; font-weight:900">
	Upload file data item campaign yang telah diformat :
	<input type="file" name="item-campaign" id="item-campaign" style="border:none; margin:7px 0px 17px 0px; width:100%" />
	<input type="button" id="b_tutup" value="Batalkan Proses" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />
	<input type="button" id="b_lanjut" value="Upload Data & Mulai Proses Perhitungan Komisi" onclick="verifikasi()" style="width:357px; background-color:green; color:#FFF" />
</p>
<?
include "includes/bottom_blank.php";
?>