var title = 'Tarif Dealer'
var var_area_selectedindex;

try{
	$(document).ready(function(){
		area_selectedindex();
	})
}catch(e){area_selectedindex()}

function area_selectedindex(){
	var_area_selectedindex = document.getElementById('area').selectedIndex;
}

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='tarif-m.php?area=<?=$_REQUEST["area"]?>'
}

function simpan(){
	if( confirm('Simpan perubahan data target penjualan baru ?') )
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
		location.href='tarif-m.php?area='+a
}

function cek(ob){
	if( ob.value != '' ) document.getElementById('perubahan_data').value=1;
}