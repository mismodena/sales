<?

class konfigurasi_komisi{

	static function persentase_komisi_campaign($arr_parameter = array()){
		$sql = "select ROW_NUMBER() OVER (order by item) nomor, * from persentase_komisi_item_campaign ";
		
		if ( count($arr_parameter) > 0 )
			$sql .= " and " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by item asc";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}		
	}

}

?>