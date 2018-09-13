
var title = 'Daftar Komisi SPG/M';

function ubah_filter_komisi(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('periode');
	location.href='?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.value;
}

function hitung_ulang(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('periode');
	if( confirm('Simpan Verifikasi ?') )
		location.href='?app=1&area='+area.options[area.selectedIndex].value+'&periodeid='+periode.value;
}

function download_report(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('periode');
	var par = '?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.value;	
	
	greylayer('download-app.php' + par, 697, 517);
}