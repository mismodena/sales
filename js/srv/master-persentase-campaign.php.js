var title = 'Konfigurasi Persentase Komisi Campaign';

function tambah(){
	var nomor = $('#table-data tr:nth-last-child(2) td:first-child').html();
	if( $.isNumeric( nomor ) ) 	nomor = parseInt(nomor) + 1;
	else						nomor = 1

	var baris = '<tr>';
	for(var x=1; x<=3; x++)	baris += '<td></td>';
	baris += '</tr>';
	
	$('#table-data tr:last').after(baris);
	$('#table-data tr:nth-last-child(2) td:first-child').html(nomor);
	$('#table-data tr:nth-last-child(2) td:nth-child(2)').html( '<?=isian_teks("item")?>'.replace(/#counter#/gi, nomor) );
	$('#table-data tr:nth-last-child(2) td:nth-child(3)').html( '<?=isian_teks("persentase")?>'.replace(/#counter#/gi, nomor) );
	
	$('html, body').scrollTop( $(document).height() );
}

function simpan(){
	if( confirm('Simpan perubahan data penjualan ?') )
			__submit('', 'c=simpan_data');
}

function _reset(){
	if( confirm('Batalkan semua perubahan yang belum disimpan ?') )
		location.href='master-persentase-campaign.php'
}