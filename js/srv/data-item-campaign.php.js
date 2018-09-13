var title = 'Konfigurasi Item Campaign Bulanan';

$(document).ready(function(){
	try{
		document.getElementById('t_item').focus();
		document.getElementById('t_item').select();
	}catch(e){}
})

function download(){
	var frm = __create_iframe_otfly();
	frm.src = 'buat-file-template.php';
}