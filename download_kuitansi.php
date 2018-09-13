<?

$par_tanggal_awal = explode("-", $_REQUEST["tanggal_awal"]);
$par_tanggal_akhir= explode("-", $_REQUEST["tanggal_akhir"]);
$tanggal_awal = $par_tanggal_awal[0] . "" . ( strlen($par_tanggal_awal[1]) < 2 ? "0" . $par_tanggal_awal[1] : $par_tanggal_awal[1] );
$tanggal_akhir = $par_tanggal_akhir[0] . "" . ( strlen($par_tanggal_akhir[1]) < 2 ? "0" . $par_tanggal_akhir[1] : $par_tanggal_akhir[1] );

$zip = new ZipArchive;
$zipfile_name = str_replace(" ", "", $_REQUEST["nama_spg"]) ."_". $tanggal_awal ."_". $tanggal_akhir .".zip";
$zipfile = "upload/" . $zipfile_name;
if( file_exists($zipfile) ) unlink( $zipfile );

$fzip = $zip->open($zipfile, ZipArchive::CREATE);
if( $fzip === TRUE ){
	for( $x = $tanggal_awal; $x <= $tanggal_akhir; $x++ ){
		$options = array('add_path' => $x . "/", 'remove_all_path' => TRUE);
		$zip->addGlob( "upload/$x/" .  $_REQUEST["user_id"] . '_*.*', GLOB_BRACE, $options);		 
	}
	$zip->close();
	
	header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=$zipfile_name");
	header("Content-length: " . filesize($zipfile));
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	readfile("$zipfile");
	
}else echo $fzip;


?>