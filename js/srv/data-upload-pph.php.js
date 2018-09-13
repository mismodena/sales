var title = 'PPh21 Komisi SPG/M'
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

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='data-upload-pph.php?area=<?=@$_REQUEST["area"]?>'
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
		location.href='data-upload-pph.php?area='+a
}

function cek(ob){
	if( ob.value != '' ) document.getElementById('perubahan_data').value=1;
}

function ubah_komisi(ob){
	var i = ob.id.split(/_/gi);
	var pph = ob.value;
	
	var total_komisi = document.getElementById('komisi_total_' +  i[1]);
	var komisi_total = total_komisi.value;
	var komisi_final_view = document.getElementById('komisi_final_view_' + i[1]);
	var komisi_final = document.getElementById('komisi_final_' +  i[1]);
	
	var tk = komisi_total.replace(/,/gi,"");
	var tk_pph = pph.replace(/,/gi,"");
	var int_poin = parseFloat(tk) - parseFloat(tk_pph);

	komisi_final_view.innerHTML = formatNumber(int_poin, 0,',','','','','-','');
	komisi_final.value = int_poin;
}
