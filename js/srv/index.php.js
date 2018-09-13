
var title = 'Daftar Komisi SPG/M';

function ubah_filter_komisi(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('sel_periode');
	location.href='?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.options[periode.selectedIndex].value;
}

function hitung_ulang(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('sel_periode');
	var par = '?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.options[periode.selectedIndex].value;
	greylayer('komisi-cabang.php' + par, 697, 517);
}

function download_report(){
	var area = document.getElementById('sel_area');
	var periode = document.getElementById('sel_periode');
	var par = '?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.options[periode.selectedIndex].value;	
	greylayer('download-report.php' + par, 697, 517);
}