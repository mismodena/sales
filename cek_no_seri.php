<?php
	include "lib/mainclass.php";
	$cek = file_get_contents("http://air.modena.co.id/csapps/?c=load_barcode&sn=".$_GET["sn"]);
	$cek = json_decode($cek, true);
	if($cek['item_id']==""){
		echo "0";
	}else{
		$mysqlcon = mysqli_connect($server, $username, $password, $db_mysql) or die("error koneksi db mysql");
		$cJ = mysqli_num_rows( mysqli_query( $mysqlcon, "select * from penjualan_detail 
					where sn='". main::formatting_query_string( $_GET["sn"] ) ."' and
					id_penjualan <> '". main::formatting_query_string( $_GET["id_p"] ) ."' and 
					id_detail_penjualan <> '". main::formatting_query_string( $_GET["id_d"] ) ."'" ));
		if($cJ>0){
			echo "1";
		}else{
			echo "2";
		}
	}
?>