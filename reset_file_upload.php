<?

// hapus folder upload yg sudah M-2
$bulan_expired = 2;
$folder_upload = "upload/";
$folder_bulan_sekarang = (int)( date("Y") . date("m") ) - $bulan_expired;

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}

foreach(scandir( $folder_upload ) as $folder){
	if( !is_dir( $folder_upload . $folder ) || in_array( $folder, array(".", "..") ) ) continue;
	if( (int)$folder <= $folder_bulan_sekarang ) rmdir_recursive( $folder_upload . $folder );
	
}

?>