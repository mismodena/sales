
var title = 'Detail Penjualan SPG/M';
var json_daftar_item = <?=$json_daftar_item?>;
var arr_daftar_item = String('<?=implode(",", $arr_daftar_item)?>').split(/,/gi);
var arr_harga_item = String('<?=implode(",", $arr_harga_item)?>').split(/,/gi);
var arr_harga_sellin = String('<?=implode(",", $arr_harga_sellin)?>').split(/,/gi);
var arr_idmodel_item = String('<?=implode(",", $arr_idmodel_item)?>').split(/,/gi);
var json_item_info = JSON.parse('<?=$json_item_info?>');

function ubah_qty_harga(ob){
	var i = ob.id.split(/_/gi);
	var item = document.getElementById('item_' + i[1]);
	var harga = document.getElementById('harga_' + i[1]);
	var sellin = document.getElementById('sellin_' + i[1]);
	var qty = document.getElementById('qty_' + i[1]);
	var rowtotal = document.getElementById('rowtotal_' + i[1]);
	var rowtotal_sellin = document.getElementById('rowtotal_sellin_' + i[1]);
	var hd_subtotal = document.getElementById('subtotal_' +  i[1]);
	var hd_subtotal_sellin = document.getElementById('subtotal_sellin_' +  i[1]);
	var hd_idmodel = document.getElementById('idmodel_' + i[1]);
	var margin= document.getElementById('margin_' + i[1]);
	
	var index_item = $.inArray(item.value, arr_idmodel_item);
	var harga_item = arr_harga_item[index_item];
	var harga_sellin = arr_harga_sellin[index_item];
	var idmodel_item = arr_idmodel_item[index_item];
	
	if( isNaN(harga_sellin) ) harga_sellin = 0;
	
	if( ob.id != 'sellin_' + i[1]  )	
		sellin.value = formatNumber(harga_sellin, 0,',','','','','-','');
	else						
		harga_sellin = sellin.value.replace(/,/gi, '')
	
	if( isNaN(harga_item) ) harga_item = 0;
	
	if( ob.id != 'harga_' + i[1] && ob.id != 'qty_' + i[1] )
		harga.value = harga.value//formatNumber(harga_item, 0,',','','','','-','');
	harga_item = harga.value.replace(/,/gi, '')
	
	hd_idmodel.value = idmodel_item;
	
	var int_subtotal = parseFloat(harga_item) * parseFloat(qty.value);
	rowtotal.innerHTML = formatNumber(int_subtotal, 0,',','','','','-','');
	hd_subtotal.value = int_subtotal;
	
	var int_subtotal_sellin = parseFloat(harga_sellin) * parseFloat(qty.value);
	rowtotal_sellin.innerHTML = formatNumber(int_subtotal_sellin, 0,',','','','','-','');
	hd_subtotal_sellin.value = int_subtotal_sellin;
	
	var int_margin=((parseFloat(harga_item) - parseFloat(harga_sellin))/parseFloat(harga_sellin))*100;
	margin.value= formatNumber(int_margin, 2,',',',','','','-','');

	itung_grand_total();
}

function ubah_qty_harga_sellin(ob){
	var i = ob.id.split(/_/gi);
	var item = document.getElementById('item_' + i[1]);
	var harga = document.getElementById('harga_' + i[1]);
	var sellin = document.getElementById('sellin_' + i[1]);
	var qty = document.getElementById('qty_' + i[1]);
	var rowtotal = document.getElementById('rowtotal_' + i[1]);
	var hd_subtotal = document.getElementById('subtotal_' +  i[1]);
	var hd_idmodel = document.getElementById('idmodel_' + i[1]);
	
	var index_item = $.inArray(item.value, arr_idmodel_item);
	var harga_item = arr_harga_item[index_item];
	var harga_sellin = arr_harga_sellin[index_item];
	var idmodel_item = arr_idmodel_item[index_item];
	
	if( isNaN(harga_sellin) ) harga_sellin = 0;
	
	if( ob.id != 'sellin_' + i[1]  )	
		sellin.value = formatNumber(harga_sellin, 0,',','','','','-','');
	else						
		harga_sellin = sellin.value.replace(/,/gi, '')
	

}

function itung_grand_total(){
	var grand_total = 0,grand_total_sellin=0,grand_total_item=0, counter = 1;
	while(true == true){
		try{
			var hd_sub_total = document.getElementById('subtotal_'+ counter);
			grand_total += parseFloat(String(hd_sub_total.value).trim());
			var hd_sub_total_sellin = document.getElementById('subtotal_sellin_'+ counter);
			grand_total_sellin += parseFloat(String(hd_sub_total_sellin.value).trim());
			
			var hd_sub_total_item = document.getElementById('qty_'+ counter);
			grand_total_item += parseFloat(String(hd_sub_total_item.value).trim());
		}catch(e){
			var cgt = document.getElementById('col_grand_total');
			cgt.innerHTML = formatNumber(grand_total, 0,',','','','','-','');	
						
			if( grand_total != parseFloat(String(document.getElementById('hd_total_penjualan').value).trim()) ){
				cgt.setAttribute('style', 'background-color:yellow');
				document.getElementById('perubahan_data').value = 1;
			}else{
				cgt.setAttribute('style', 'background-color:transparent');
				document.getElementById('perubahan_data').value = 0;
			}
			
			var cgt_sellin= document.getElementById('col_grand_total_sellin');
			cgt_sellin.innerHTML = formatNumber(grand_total_sellin, 0,',','','','','-','');
			
			if( grand_total_sellin != parseFloat(String(document.getElementById('hd_total_penjualan').value).trim()) ){
				cgt.setAttribute('style', 'background-color:yellow');
				document.getElementById('perubahan_data').value = 1;
			}else{
				cgt.setAttribute('style', 'background-color:transparent');
				document.getElementById('perubahan_data').value = 0;
			}
			
			var cgt_item= document.getElementById('col_grand_total_item');
			cgt_item.innerHTML = grand_total_item;
			
			
			break;
		}
		counter++;
	}
}

function tambah_penjualan(){
	var nomor = $('#table-data tr:nth-last-child(2) td:first-child').html();
	if( $.isNumeric( nomor ) ) 	nomor = parseInt(nomor) + 1;
	else						nomor = 1

	var baris = '<tr>';
	for(var x=1; x<=13; x++)	baris += '<td></td>';
	baris += '</tr>';
	
	$('#table-data tr:last').before(baris);
	$('#table-data tr:nth-last-child(2) td:first-child').html(nomor);
	$('#table-data tr:nth-last-child(2) td:nth-child(2)').html(  '<?=isian_tanggal()?>'.replace(/#counter#/gi, nomor) );	
	$('#table-data tr:nth-last-child(2) td:nth-child(3)').html( '<?=isian_teks("faktur")?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(4)').html( 'Nama:<?=isian_teks("namakonsumen") . "<br /><hr />Tel:" . isian_teks("telepon") . "<br /><hr />Email:" . isian_teks("email") ?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(5)').html( '<?=pilihan_item("#counter#", bikin_opsi_selectbox( $arr_opsi_selectbox_item ) )?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(6)').html( '<?=isian_harga_tidakreadonly()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(7)').html( '<?=isian_harga_sellin()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(8)').html( '<?=margin()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(9)').html( '<?=isian_qty()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(10)').html( '<?=isian_hidden()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(11)').html( '<?=isian_hidden_sellin()?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(12)').html( 'SN' );
	$('#table-data tr:nth-last-child(2) td:nth-child(13)').html( /*'<?=isian_upload("keterangan")?>'.replace(/#counter#/gi, nomor)*/ );
	$("#tgl_" + nomor).datepicker({"dateFormat":"d MM yy",  "altField": ("#tglf_" + nomor) , "altFormat": "yy-mm-d"});		
	$("#tgl_" + nomor).datepicker($.datepicker.regional['id']);		
	$(".select-search").select2();
	$('html, body').scrollTop( $(document).height() );
}

function kembali(){
	if( document.getElementById('perubahan_data').value == "1" ){
		if( confirm('Terdapat perubahan data penjualan!\nApakah akan disimpan terlebih dahulu dan kembali ke halaman sebelumnya ?') )
			__submit('', 'c=simpan_data&kembali=');
	}else
		location.href='verifikasi-penjualan.php?area=<?=$_REQUEST["area"]?>&tanggal_awal=<?=$_REQUEST["tanggal_awal"]?>&tanggal_akhir=<?=$_REQUEST["tanggal_akhir"]?>'
}
function simpan(){
	if( confirm('Simpan perubahan data penjualan ?') )
			__submit('', 'c=simpan_data');
}

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='verifikasi-penjualan-detail.php?area=<?=$_REQUEST["area"]?>&user_id=<?=$_REQUEST["user_id"]?>&tanggal_awal=<?=$_REQUEST["tanggal_awal"]?>&tanggal_akhir=<?=$_REQUEST["tanggal_akhir"]?>'
}

function klik_checbox(ob){
	var baris = ob.parentNode.parentNode;
	var index = baris.rowIndex;
	var bg = '#FFF';
	if( !document.getElementById( string_cbox_id(ob) ).checked )	bg = '#80ff80' ;
	var tabel = document.getElementById("table-data");
	for(var x= 0; x < tabel.rows[index].cells.length; x++)
		tabel.rows[index].cells[x].setAttribute('style', 'padding:0px; background-color:' + bg + ' !important');
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

$(document).ready(function(){
	
	$("#t_tanggal_awal").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_awal", "altFormat": "yy-mm-d"});		
	$("#t_tanggal_awal").datepicker($.datepicker.regional['id']);		
	
	$("#t_tanggal_akhir").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_akhir", "altFormat": "yy-mm-d"});		
	$("#t_tanggal_akhir").datepicker($.datepicker.regional['id']);		
	try{
		$(".select-search").select2();
	}catch(e){}
	<?=@$script?>
})





