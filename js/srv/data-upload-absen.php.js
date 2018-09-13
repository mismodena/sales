var title = 'Absensi Mitra Bulanan'
var var_area_selectedindex;

try{
	$(document).ready(function(){
		area_selectedindex();
		//disabled_tombol_transaksi();
	})
}catch(e){area_selectedindex()}

function area_selectedindex(){
	var_area_selectedindex = document.getElementById('area').selectedIndex;
}

function download_report(){
	var area = document.getElementById('area');
	var periode = document.getElementById('periode');
	var par = '?area='+area.options[area.selectedIndex].value+'&periodeid='+periode.value;	
	
	greylayer('download-abs.php' + par, 697, 517);
}

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='data-upload-absen.php?area=<?=@$_REQUEST["area"]?>'
}

function simpan(){
	if( confirm('Simpan perubahan data absensi ?') )
			__submit('', 'c=simpan_data');
}

function ubah_cabang(){
	var a = document.getElementById('area').value;
	if( document.getElementById('perubahan_data').value == '1' ){
		if( confirm('Apakah perubahan akan disimpan dulu sebelum mengganti area cabang?') )
			__submit('', 'c=simpan_data&ubah_cabang=');
		else
			document.getElementById('area').selectedIndex = var_area_selectedindex;
	}else
		location.href='data-upload-absen.php?area='+a
}

function cek(ob){
	if( ob.value != '' ) document.getElementById('perubahan_data').value=1;
}

function ubah_poin_jk(ob){
	var i = ob.id.split(/_/gi);
	var max = document.getElementById('max_jk').value;
	var set_poin = 15;
	var poin = ob.value;
	var poin_jk_view = document.getElementById('poin_jk_view_' + i[1]);
	var poin_jk = document.getElementById('poin_jk_' +  i[1]);
	
	var int_poin = Math.floor(poin / max * set_poin);
	if(int_poin > set_poin) int_poin = set_poin;
	poin_jk_view.innerHTML = formatNumber(int_poin, 0,',','','','','-','');
	poin_jk.value = int_poin;
	
	ubah_poin_total(i)
}

function ubah_poin_hk(ob){
	var i = ob.id.split(/_/gi);
	var max = document.getElementById('max_hk').value;
	var set_poin = 15;
	var poin = ob.value;
	var poin_hk_view = document.getElementById('poin_hk_view_' + i[1]);
	var poin_hk = document.getElementById('poin_hk_' +  i[1]);
	
	var int_poin = Math.floor(poin / max * set_poin);
	if(int_poin > set_poin) int_poin = set_poin;
	poin_hk_view.innerHTML = formatNumber(int_poin, 0,',','','','','-','');
	poin_hk.value = int_poin;
	
	ubah_poin_total(i)

}

function ubah_poin_tr(ob){
	var i = ob.id.split(/_/gi);
	var max = 1;
	var set_poin = 10;
	var poin = ob.value;
	var tr = document.getElementById('tr_' + i[1]);
	var poin_tr_view = document.getElementById('poin_tr_view_' + i[1]);
	var poin_tr = document.getElementById('poin_tr_' +  i[1]);
	
	if(poin > max) tr.value = max;
	var int_poin = Math.floor(poin / max * set_poin);
	if(int_poin > set_poin) int_poin = set_poin;
	poin_tr_view.innerHTML = formatNumber(int_poin, 0,',','','','','-','');
	poin_tr.value = int_poin;
	
	ubah_poin_total(i)

}

function ubah_poin_total(i){
	
	var poin_total_view = document.getElementById('poin_total_view_' + i[1]);
	var poin_total = document.getElementById('poin_total_' +  i[1]);
	var komisi_view = document.getElementById('komisi_view_' +  i[1]);
	var komisi = document.getElementById('komisi_' +  i[1]);
	
	var tarif = document.getElementById('tarif_' +  i[1]);
	var poin_jk = document.getElementById('poin_jk_' +  i[1]);
	var poin_hk = document.getElementById('poin_hk_' +  i[1]);
	var poin_tr = document.getElementById('poin_tr_' +  i[1]);
	var poin_omzet = document.getElementById('poin_omzet_' +  i[1]);
	

	var int_poin = parseInt(poin_jk.value) + parseInt(poin_hk.value) + parseInt(poin_tr.value) + parseInt(poin_omzet.value);
	poin_total_view.innerHTML = formatNumber(int_poin, 0,',','','','','-','');
	poin_total.value = int_poin;
	
	var int_komisi = parseFloat(int_poin) * parseFloat(tarif.value);
	komisi_view.innerHTML = formatNumber(int_komisi, 0,',','','','','-','');
	komisi.value = int_komisi;

}