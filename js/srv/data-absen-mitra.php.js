var title = 'Upload & Hitung Absensi Mitra';

$(document).ready(function(){
	try{
		document.getElementById('t_item').focus();
		document.getElementById('t_item').select();
	}catch(e){}
})

function download(){
	var frm = __create_iframe_otfly();
	frm.src = 'buat-file-absen.php?area='+document.getElementById('area').value;
}