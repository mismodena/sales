var title = 'Max Jam & Hari Kerja'
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
		location.href='setting-m.php?periodeid=<?=@$_REQUEST["periodeid"]?>'
}

function simpan(){
	if( confirm('Simpan perubahan seting max hari & jam kerja mitra ?') )
			__submit('', 'c=simpan_data');
}

function ubah_cabang(){
	var a = document.getElementById('sel_periode').value;
	if( document.getElementById('perubahan_data').value == '1' ){
		if( confirm('Apakah perubahan akan disimpan dulu sebelum mengganti periode?') )
			__submit('', 'c=simpan_data&ubah_periode=');
		else
			document.getElementById('sel_periode').selectedIndex = var_area_selectedindex;
	}else
		location.href='setting-m.php?periodeid='+a

}

function cek(ob){
	if( ob.value != '' ) document.getElementById('perubahan_data').value=1;
}