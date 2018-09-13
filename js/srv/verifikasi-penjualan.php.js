
var title = 'Verifikasi Penjualan SPG/M Mingguan';

$(document).ready(function(){
	
	$(function() {
		$("#t_tanggal_awal").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_awal", "altFormat": "yy-mm-d"});		
		$("#t_tanggal_awal").datepicker($.datepicker.regional['id']);		
		
		$("#t_tanggal_akhir").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_akhir", "altFormat": "yy-mm-d"});		
		$("#t_tanggal_akhir").datepicker($.datepicker.regional['id']);		
	});	
})	

function lihat(){
	var a = document.getElementById('area').value;
	var tw = document.getElementById('tanggal_awal').value;
	var tk = document.getElementById('tanggal_akhir').value;	
	location.href='verifikasi-penjualan.php?area='+a+'&tanggal_awal='+tw+'&tanggal_akhir='+tk
}