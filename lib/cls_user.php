<?


class akses_pengguna extends sql{
	
	static function pengguna($arr_parameter = array()){
		$sql = "select * from pengguna ";
		if( isset($_SESSION["user_login"]) )
			$sql .= " where pengguna_id = '". main::formatting_query_string( $_SESSION["user_login"] ) ."' ";
		else
			if ( count($arr_parameter) > 0 )
				$sql .= " where " . sql::sql_parameter( $arr_parameter );

		try{		
			return sql::execute( $sql  );
		}catch(Exception $e){$e->getMessage();}
	}

	static function akses_halaman($halaman, $kolom = ""){
		if( $kolom == "" ) $kolom = "menu_id";
		$sql = "select ". $kolom ." from menu where menu = '". main::formatting_query_string($halaman) ."';";
		try{		
			$data = sqlsrv_fetch_array(sql::execute( $sql  ));
			return $data[ $kolom ];
		}catch(Exception $e){$e->getMessage();}
	}
	
	static function otorisasi_akses_pengguna($halaman, $pengguna){
		if( self::akses_halaman( $halaman ) != ""){
			$sql = "select isnull(c.parameter, '') parameter_diijinkan, isnull(b.parameter, '') parameter, isnull(a.bisa_edit, 0) bisa_edit
			from menu_pengguna a, menu b, pengguna c where 
			a.pengguna_id = c.pengguna_id and a.menu_id = b.menu_id and
			b.menu = '". main::formatting_query_string( $halaman ) ."' and c.pengguna_id = '". main::formatting_query_string( $pengguna ) ."';";
			$rs = sql::execute( $sql  );
			if( sqlsrv_num_rows($rs) <= 0 ) {$_SESSION["halaman_ditolak"] = array($GLOBALS["page"], $_REQUEST); return array(false, 0);}
			$data = sqlsrv_fetch_array($rs);
			
			$bisa_edit = $data["bisa_edit"] == 0 ? "disabled_tombol_transaksi();" : "";
			
			// untuk halaman yang free akses tanpa batasan data .. dan pengguna yang free akses tanpa batasan data
			if( $data["parameter"] == "" ||  $data["parameter_diijinkan"] =="" ) return array(true, $bisa_edit);
			
			// untuk halaman terbatas akses data dibandingkan dengan pengguna yang terbatas untuk data tertentu
			$arr_parameter_diijinkan = explode("|", strtoupper($data["parameter_diijinkan"]));
			if( in_array( strtoupper( @$_REQUEST[ $data["parameter"] ] ), $arr_parameter_diijinkan ) ) 
				return array(true, $bisa_edit);
			else
				{$_SESSION["halaman_ditolak"] = array($GLOBALS["page"], $_REQUEST);  return array(false, 0);}
		}
		return array(true, 1);
	}
	
	static function spg_login( $arr_parameter = array() ){
		$sql = "select * from `user` ";
		
		if ( count($arr_parameter) > 0 )
				$sql .= " where " . sql::sql_parameter( $arr_parameter );
		
		return mysqli_query( $GLOBALS["mysqlcon"], $sql );
	}
	
}

?>