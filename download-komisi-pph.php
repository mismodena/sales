<?
include "includes/top_blank.php";
include "panduan-template-pph.php";
?>
<p style="border-top:#CCC solid 1px; padding-top:13px; text-align:center">		
	<input type="button" id="b_tutup" value="Tutup Jendela" onclick="parent.TINY.box.hide()" style="width:157px; background-color:red; color:#FFF" />	
	<input type="button" id="b_lanjut" value="Download Template Data Item Campaign" onclick="download()" style="background-color:green; color:#FFF" />
	<input type="hidden" id="area" value="<?=$_REQUEST['area']?>" />
</p>
<?
include "includes/bottom_blank.php";
?>