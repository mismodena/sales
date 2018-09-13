<?
include "lib/mainclass.php";
?>
<html>
<head>
<title>Aplikasi Perhitungan Komisi SPG</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/easy-autocomplete.min.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="css/select2.min.css" type="text/css" rel="stylesheet" />
<script src="js/main.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.easy-autocomplete.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/ui.datepicker-id.js"></script>
<script src="js/tinybox.js"></script>
<script src="js/select2.full.js"></script>
<script>
try{
	$(document).ready(function(){
		$( document ).tooltip({
		items: "div[title]",
		content: 
			function(){
				var element = $( this );
				if (element.is( "[title]" )) {
					return element.attr( "title" );
				}
			}
		});
		try{
			$('#page-title').html(title);
		}catch(e){}	
		$('.slideout-menu-toggle<?=!isset($_SESSION["user_nama"]) ? "x":""?>').on('click', function(event){
			event.preventDefault();
			var slideoutMenu = $('.slideout-menu');
			var slideoutMenuWidth = $('.slideout-menu').width();
			
			slideoutMenu.toggleClass("open");
			
			if (slideoutMenu.hasClass("open")) {
				slideoutMenu.animate({
					left: "0px"
				});	
			} else {
				slideoutMenu.animate({
					left: -slideoutMenuWidth
				}, 250);	
			}
		    });	
		    
		    $(document).find(':checkbox, :radio').each( function(){
				if($(this).is(":visible")){
					switch_control($(this));		
					$(this).attr("style", "display:none");
				}
			});
			
		    <?=@$script?>
	})
}catch(e){
	<?=@$script?>
}
<? file_exists("js/srv/" . $page .".js") ? include "js/srv/" . $page .".js" : "" ?>
</script>
<? file_exists("css/srv/" . $page .".css") ? include "css/srv/" . $page .".css" : "" ?>
</head>
<body>
<form name="form1" id="form1" method="post">
<div style="width:100%; height:33px; background-color:#666; border-bottom:#333 solid 1px; color:#FFF">
	<div style="float:left;">
		<a href="#" class="slideout-menu-toggle"><img src="images/menu-bar-32x32.png" style="max-height:33px; border:none" /> </a>
	</div>
	<div style="float:right; padding:3px 17px 0px; width:400px">		
		<div id="page-title" style="font-weight:900; float:right"></div>
		<img src="images/article.png" style="border:none; max-height:25px; float:right; padding-right:7px;" />
	</div>
</div>
<div class="slideout-menu">
	<h3><a href="#" class="slideout-menu-toggle">&times;</a>
	<img src="images/smileys_001_01.png" style="height:47px; padding-bottom:7px" /><br />Hallooww, <?=strtoupper(@$_SESSION["user_nama"])?> !!!</h3>
	<ul>
		<li><a href="kelas-dealer.php"><img src="images/wrench-512.png" /> Data Kelas Dealer</a></li>
		<li><a href="master-persentase-campaign.php"><img src="images/wrench-512.png" />Persentase Komisi Campaign</a></li>
		<li><a href="target-spgm.php?area=<?=@$arr_session_area[0]?>"><img src="images/wrench-512.png" />Target SPG/M</a></li>
		<li><a href="tarif-m.php?area=<?=@$arr_session_area[0]?>"><img src="images/wrench-512.png" />Tarif Poin Mitra</a></li>
		<li><a href="setting-m.php?area=<?=@$arr_session_area[0]?>"><img src="images/wrench-512.png" />Jam & Hari Kerja Mitra</a></li>
		<li><a href="data-item-campaign.php">Item Campaign Bulanan</a></li>
		<li><a href="data-upload-absen.php">Absensi Mitra Bulanan</a></li>
		<li><a href="index.php?area=<?=@$arr_session_area[0]?>">Daftar Komisi SPG/M</a></li>
		<li><a href="verifikasi-penjualan.php?area=<?=@$arr_session_area[0]?>">Verifikasi Penjualan SPG/M</a></li>
		<!--<li><a href="data-upload-pph.php">PPh21 Komisi SPG/M</a></li>-->
		<li><a href="login.php?c=logout">Logout</a></li>
	</ul>
</div>
<div style="margin:7px">