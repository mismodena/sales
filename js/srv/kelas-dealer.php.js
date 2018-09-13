var title = 'Data Kelas Dealer'

try{
	$(document).ready(function(){
		load_awal();
	})
}catch(e){load_awal();}

function load_awal(){
	document.getElementById('periode_kelas_dealer').innerHTML = '<?=@$periode_kelas_dealer?>';
	document.getElementById('rata_rata_omset_periode').innerHTML = '<?=@$rata_rata_omset_periode?>';
}

function kelas_dealer(m){
	var c = document.getElementById('cari').value;
	var pp =document.getElementById('s_perhalaman');
	var p =document.getElementById('s_halaman');
	if ( typeof m != undefined && m )	p.selectedIndex = 0;
	location.href='kelas-dealer.php?cari='+c+'&s_perhalaman='+pp.options[pp.selectedIndex].value+'&s_halaman='+p.options[p.selectedIndex].value;
}