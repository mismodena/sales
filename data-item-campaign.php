<?
include "includes/top.php";
?>
<div style="padding-bottom:17px; float:left; width:437px;padding-top:7px">
	Berikut adalah data item campaign periode <span style="background-color:yellow; font-weight:bold; padding:7px;"><?=@$periode?></span><br /> 
	Cari item <input type="text" name="t_item" id="t_item" style="width:111px" value="<?=@$_REQUEST["t_item"]?>" />
	<input type="button" id="b_cari" value="Cari" onclick="document.forms[0].submit()" style="width:57px; background-color:green" /> | <?=@sqlsrv_num_rows($rs_campaign)?> data item campaign.
	<div style="border-top:1px solid #999; margin-top:27px; padding-top:27px; text-align:center;">
		<input type="button" id="b_mulai" 
			onclick="greylayer('komisi-1.php', 697, 517); void(0)"
			style="background-color:#4d4dff; width:277px; font-weight:900; margin-bottom:17px" value="Mulai Perhitungan Komisi" /><br />
		<a href="javascript:greylayer('download-item-campaign.php', 697, 517, true)" style="color:blue;">Download template data item campaign</a>
	</div>	
</div>
<div id="item-campaign-container">
<?=@$s_item_campaign?>
</div>
<?
include "includes/bottom.php";
?>