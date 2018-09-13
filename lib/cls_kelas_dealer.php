<?

class kelas_dealer{

	static function data_kelas_dealer($arr_parameter = array()){
		$sql = "select a.*, b.namecust,
			dateadd(MONTH, -1, periode) b1, dateadd(MONTH, -2, periode) b2, dateadd(MONTH, -3, periode) b3 
			from kelas_dealer a, sgtdat..arcus b where a.dealer = b.idcust ";
		
		if ( count($arr_parameter) > 0 )
			$sql .= " and " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by b.namecust asc";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}				
	}

}

?>