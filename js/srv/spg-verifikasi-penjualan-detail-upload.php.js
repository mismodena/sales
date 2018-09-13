
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
	
	//var int_subtotal = ((parseFloat(harga_item) - parseFloat(harga_sellin))/parseFloat(harga_sellin))*100;
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
	var nomor = $('#jumlah_item').val();
	if( $.isNumeric( nomor ) ) 	nomor = parseInt(nomor) + 1;
	else						nomor = 1
	
	$('#jumlah_item').val(nomor);
	
	var baris = '<tr>';
	baris += '<td style="background-color:#'+ ( nomor % 2 == 0 ? 'EEE' : 'FFF' ) +';padding:13px"></td>';
	baris += '</tr>';
	
	$('#table-data tr:last').after(baris);

	var konten = '';
	var arr_konten = new Array();
	var arr_label = new Array();
	arr_label[0] = 'Produk';arr_label[1]='Harga Sell-out';arr_label[2]='Harga Sell-in';arr_label[3]='Margin';arr_label[4]='Jumlah';arr_label[5]='Sub Total Sell-out (Rp) : ';arr_label[6]='Sub Total Sell-in (Rp) : '
	arr_konten[0]='<?=pilihan_item("#counter#", bikin_opsi_selectbox( $arr_opsi_selectbox_item ) )?>'.replace(/#counter#/gi, nomor);
	arr_konten[1]='<?=isian_harga_tidakreadonly()?>'.replace(/#counter#/gi, nomor);
	arr_konten[2]='<?=isian_harga_sellin()?>'.replace(/#counter#/gi, nomor)
	arr_konten[3]='<?=margin()?>'.replace(/#counter#/gi, nomor)
	arr_konten[4]='<?=isian_qty()?>'.replace(/#counter#/gi, nomor)
	arr_konten[5]='<?=isian_hidden()?>'.replace(/#counter#/gi, nomor)
	arr_konten[6]='<?=isian_hidden_sellin()?>'.replace(/#counter#/gi, nomor)
	for( var x=0; x<arr_label.length; x++ ){
		var br = x<5 ? '<br />' : ''
		konten += '<div>'+ arr_label[x] + br + arr_konten[x] +'</div>'
	}
	
	$('#table-data tr:nth-last-child(1) td:first-child').html(konten);
	$(".select-search").select2();
	$('html, body').scrollTop( $(document).height() );
}

function logout(){

		location.href='login.php?c=logout';
}
function kembali(){
	if( document.getElementById('perubahan_data').value == "1" ){
		if( confirm('Terdapat perubahan data penjualan!\nApakah akan disimpan terlebih dahulu dan kembali ke halaman sebelumnya ?') )
			__submit('', 'c=simpan_data&kembali=');
	}else
		location.href='sales-monitoring.php';
}
function simpan(){
	if( confirm('Simpan perubahan data penjualan ?') )
			__submit('', 'c=simpan_data');
}

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='spg-verifikasi-penjualan-detail.php'
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

function ubahtanggal(){
	location.href='spg-verifikasi-penjualan-detail.php?tanggal_awal='+document.getElementById('tanggal_awal').value+'&tanggal_akhir='+document.getElementById('tanggal_akhir').value
}

function tampilkan_detail(ob, op){
	ob.setAttribute('onclick', 'javascript:tampilkan_detail(this,'+ ( op ? 'false' : 'true' ) +')')
	document.getElementById('link-detail-header').innerHTML = ( op ? 'Sembunyikan' : 'Tampilkan' ) + ' Detail'
	document.getElementById('detail-header').setAttribute('style', 'display:' + ( op ? 'block' : 'none') )
}

$(document).ready(function(){
	
	$("#t_tanggal_awal").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_awal", "altFormat": "yy-mm-d"});		
	$("#t_tanggal_awal").datepicker($.datepicker.regional['id']);		
	
	$("#t_tanggal_akhir").datepicker({"dateFormat":"d MM yy",  "altField":"#tanggal_akhir", "altFormat": "yy-mm-d"});		
	$("#t_tanggal_akhir").datepicker($.datepicker.regional['id']);		
	
	$("#tgl_1" ).datepicker({"dateFormat":"d MM yy",  "altField": ("#tglf_1" ) , "altFormat": "yy-mm-d"});		
	$("#tgl_1" ).datepicker($.datepicker.regional['id']);		
	try{
		$(".select-search").select2();
	}catch(e){}
	<?=@$script?>
})





