
$(document).ready(function(){
	
	$(function() {
		$("#t_tanggal_awal").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_awal", "altFormat": "yy-mm-d"});		
		$("#t_tanggal_awal").datepicker($.datepicker.regional['id']);		
		
		$("#t_tanggal_akhir").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_akhir", "altFormat": "yy-mm-d"});		
		$("#t_tanggal_akhir").datepicker($.datepicker.regional['id']);		
	});	
})

function ubahtanggal(){
	location.href='sales-monitoring.php?tanggal_awal='+document.getElementById('tanggal_awal').value+'&tanggal_akhir='+document.getElementById('tanggal_akhir').value
}

function __upload(ob){
	var f = document.createElement('form');
	f.setAttribute('style', 'display:none')
	f.setAttribute('method', 'post')
	f.setAttribute('enctype', 'multipart/form-data')
	f.appendChild(ob);
	f.action='spg-verifikasi-penjualan-detail.php?c=upload&id=' +ob.id
	f.target='frmx'
	document.body.appendChild(f)
	f.submit()
}