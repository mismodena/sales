<?

class komisi extends sql{

	static function load_data_item_campaign( $kode = "" ){
		if( $kode != "" ) 
			$par = " and (b.fmtitemno like '". $kode ."%' or 
				ltrim(rtrim(isnull(a.model, 
					left(b.fmtitemno, 2) + ' '+ substring( b.fmtitemno, 3,charindex('/', b.fmtitemno)-3 )
				))) like '". $kode ."%') ";
		$sql = self::sql_data_item_untuk_download_template( " inner join item_campaign ic on   ltrim(rtrim(b.fmtitemno)) =  ltrim(rtrim(ic.kode_item))", @$par );

		try{		return sql::execute( $sql  );	}
		catch(Exception $e){$e->getMessage();}		
	}

	/*
	fungsi untuk browsing data komisi
	parameter : 
	[optional] array ("kolom" => array("operator" => "nilai") )
	[optional] array ("kolom" => "ASC | DESC")
	return : recordset
	*/
	static function load_data_komisi($arr_parameter = array(), $arr_sort = array()){
		
		$sort = sql::sql_sort( $arr_sort );
		$sort = $sort == "" ? " order by a.area asc" : $sort;
		
		$sql = "select a.*, komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) komisi_total ,case when  b.kelas not in ('A', 'B', 'C') then 'NON' else b.kelas end kelas,
			komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) - isnull(a.pph,0) - isnull(a.potongan,0) komisi_final,
			ROW_NUMBER() OVER (". $sort .") nomor
			from komisi a 
			left outer join kelas_dealer b on dbo.ambil_kode(a.store)=b.dealer
			left outer join (select dealer, max(periode) periode from kelas_dealer group by dealer) c on b.dealer=c.dealer and b.periode=c.periode 
			where ";
		if ( count($arr_parameter) <= 0 )
			$sql .= " a.periode = (select top 1 id from periode order by periode desc) ";
		else
			$sql .= sql::sql_parameter( $arr_parameter );
		//echo $sql;
		try{		return sql::execute( $sql  . $sort );	}
		catch(Exception $e){$e->getMessage();}
		
	}
	
	// komisi poin
	static function load_data_komisi_poin($arr_parameter = array(), $arr_sort = array()){
		
		$sort = sql::sql_sort( $arr_sort );
		$sort = $sort == "" ? " order by a.nama_user asc" : $sort;
		
		$sql = "select ab.*, a.*, a.store toko, td.tarif, a.komisi_fix + a.komisi_variabel + a.komisi_campaign + isnull(a.komisi_poin,0) + isnull(komisi_spesial,0) - isnull(a.pph,0) - isnull(a.potongan,0) komisi_final,
			a.komisi_fix + a.komisi_variabel + a.komisi_campaign + isnull(a.komisi_poin,0) + isnull(komisi_spesial,0) komisi_total,
			a.komisi_fix + a.komisi_variabel + a.komisi_campaign komisi_penjualan,
			u.bank, u.rekening, u.npwp, dbo.ambil_nilai(u.nama_user) nama_new,  
			ROW_NUMBER() OVER (". $sort .") nomor
			from komisi a
			inner join absensi ab on a.id_user = ab.id_user and a.periode = ab.periode
			inner join openquery(MYSQLDMZ, 'select * from ".$GLOBALS['db_mysql'].".`user` ') u on a.id_user = u.id_user
			left outer join tarif_dealer td on td.store = a.store and td.periode = a.periode
			left outer join kelas_dealer b on dbo.ambil_kode(a.store)=b.dealer
			left outer join (select dealer, max(periode) periode from kelas_dealer group by dealer) c on b.dealer=c.dealer and b.periode=c.periode 
			where ";
		if ( count($arr_parameter) <= 0 )
			$sql .= " a.periode = (select top 1 id from periode order by periode desc) ";
		else
			$sql .= sql::sql_parameter( $arr_parameter );
		//echo $sql;
		try{		return sql::execute( $sql  . $sort );	}
		catch(Exception $e){$e->getMessage();}
		
	}
	
	static function load_data_komisi_final($arr_parameter = array(), $arr_sort = array()){
		
		$sort = sql::sql_sort( $arr_sort );
		$sort = $sort == "" ? " order by a.area asc" : $sort;
		
		$sql = "select a.*, ab.*, komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) komisi_total,
				komisi_fix + komisi_variabel + komisi_campaign + isnull(komisi_poin,0) + isnull(komisi_spesial,0) - isnull(a.pph,0) - isnull(a.potongan,0) komisi_final,
				b.bank, b.rekening, b.npwp, dbo.ambil_nilai(u.nama_user) nama_new,   
			ROW_NUMBER() OVER (". $sort .") nomor
			from komisi a
			inner join absensi ab on a.id_user = ab.id_user and a.periode = ab.periode
			inner join openquery(MYSQLDMZ, 'select * from ".$GLOBALS['db_mysql'].".`user` ') b on a.id_user = b.id_user
			where ";
		if ( count($arr_parameter) <= 0 )
			$sql .= " a.periode = (select top 1 id from periode order by periode desc) ";
		else
			$sql .= sql::sql_parameter( $arr_parameter );
		//echo $sql;
		try{		return sql::execute( $sql  . $sort );	}
		catch(Exception $e){$e->getMessage();}
		
	}

	/*
	fungsi untuk browsing data periode
	parameter : 
	[optional] array ("kolom" => array("operator" => "nilai") )
	[optional] array ("kolom" => "ASC | DESC")
	return : recordset
	*/	
	static function load_data_periode($arr_parameter = array(), $arr_sort = array()){
		$sql = "select * from periode ";
		if ( count($arr_parameter) > 0 )
			$sql .= "where " . sql::sql_parameter( $arr_parameter );

		try{		return sql::execute( $sql . sql::sql_sort( $arr_sort ) );	}
		catch(Exception $e){$e->getMessage();}

	}
	
	/*
	fungsi untuk browsing data area/cabang
	parameter : 
	[optional] array ("kolom" => array("operator" => "nilai") )
	return : recordset
	*/	
	static function load_data_area($arr_parameter = array()){
		$sql = "select distinct area from komisi";
		if ( count($arr_parameter) > 0 )
			$sql .= "where " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by area";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	static function load_data_cabang(){
		$sql = "select * from pengguna where combo = 1 order by pengguna_nama";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	static function load_data_store($area_user, $periodeid){
		// $sql = "select distinct dbo.ambil_kode(a.store) kode, dbo.ambil_nilai(a.store) store, tarif from komisi a ";
		// $sql .= "cross apply (select top 1 * from tarif_dealer where dealer = ltrim(rtrim(dbo.ambil_kode(a.store))) and periode = ".$periodeid.") b ";
		// $sql .= "where area = '" . main::formatting_query_string($area_user) . "'" ;
		// $sql .= " order by store";
		
		$sql = "select distinct a.id, dbo.ambil_kode(a.store) kode, dbo.ambil_nilai(a.store) store, a.tarif, b.tarif tarif_b from tarif_dealer a
				left join komisi k on a.store = k.store and k.periode = ".$periodeid." 
				left join tarif_dealer_app b on a.id = b.tarif_id and b.[status] = 0
				where a.periode = ".$periodeid." and k.area = '" . main::formatting_query_string($area_user) . "'
				order by store";
		//echo $sql;
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	
	static function load_data_penjualan($arr_parameter = array()){
		$sql = "select *, harga * qty subtotal, isnull(dbo.ambil_kode(c.nama_model) , c.nama_model) itemno,
			case isnull(dbo.ambil_kode(nama_model) , '') when '' then 1 else 0 end error_kode_accpac
			from penjualan a, penjualan_detail b, openquery(MYSQLDMZ, 'select * from nolppco_modena.model') c 
			where a.id_penjualan = b.id_penjualan and b.id_model=c.id_model ";
			
		if ( count($arr_parameter) > 0 )
			$sql .= " and " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by a.tanggal asc";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}		
	}
	
	private static function sql_data_item_untuk_download_template( $tambahan_join = "", $tambahan_parameter = "" ){
		return "select ROW_NUMBER() OVER (ORDER BY b.fmtitemno) nomor, 
			ltrim(rtrim(isnull(a.model, 
				left(b.fmtitemno, 2) + ' '+ substring( b.fmtitemno, 3,charindex('/', b.fmtitemno)-3 )
				))) model, b.itemno, b.fmtitemno,
			b.[desc], convert(int, e.unitprice) unitprice 
			from 			
			sgtdat..ICITEM b 				
			left outer join mesdb..tbl_icitem a on b.ITEMNO = a.ITEMNO and b.ITEMBRKID = 'FG' and b.[DESC] not like '%SAMPLE%' 			
			left outer join sgtdat..ICPRIC d on b.ITEMNO = d.ITEMNO 
				and d.pricelist='STD' 
			left outer join sgtdat..ICPRICP e on d.ITEMNO = e.ITEMNO and d.PRICELIST = e.PRICELIST and d.CURRENCY = e.CURRENCY 
				and e.DPRICETYPE = 1 and e.CURRENCY = 'IDR' 
			". $tambahan_join ."
		where e.unitprice is not null and e.unitprice > 0 and charindex('/', b.fmtitemno) > 0 and b.INACTIVE = 0 and b.[DESC] not like '%SAMPLE%'
			". $tambahan_parameter ."
		order by isnull(a.model, 
				left(b.fmtitemno, 2) + ' '+ substring( b.fmtitemno, 3,charindex('/', b.fmtitemno)-3 )
				)";
	}
	
	static function load_data_item($arr_parameter = array(), $untuk_download = false){
		$sql = "select ROW_NUMBER() OVER (ORDER BY isnull(ltrim(rtrim(b.fmtitemno)), f.nama_model)) nomor, 
			isnull(a.model, 
				left(b.fmtitemno, 2) + ' '+ substring( b.fmtitemno, 3,charindex('/', b.fmtitemno)-3 )
				) model, f.id_model, b.itemno, b.fmtitemno,
			b.[desc], f.nama_model, convert(int, e.unitprice) unitprice 
			from 			
			openquery(MYSQLDMZ, 'select * from nolppco_modena.model') f 
			left outer join sgtdat..ICITEM b on ltrim(rtrim(b.fmtitemno)) = dbo.ambil_kode(f.nama_model)
				and b.ITEMBRKID = 'FG' and b.[DESC] not like '%SAMPLE%' 			
			left outer join mesdb..tbl_icitem a on b.ITEMNO = a.ITEMNO 
			left outer join sgtdat..ICPRIC d on b.ITEMNO = d.ITEMNO 
				and d.pricelist='STD' 
			left outer join sgtdat..ICPRICP e on d.ITEMNO = e.ITEMNO and d.PRICELIST = e.PRICELIST and d.CURRENCY = e.CURRENCY 
				and e.DPRICETYPE = 1 and e.CURRENCY = 'IDR' 
			";
		if ( count($arr_parameter) > 0 )
			$sql .= "where " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by isnull(ltrim(rtrim(b.fmtitemno)), f.nama_model)";
		
		if( $untuk_download ) $sql = self::sql_data_item_untuk_download_template();
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	static function load_data_penjualan_rekap($arr_parameter = array()){
		$sql = "select *, harga * qty subtotal, isnull(dbo.ambil_kode(b.nama_model), b.nama_model) itemno, dbo.ambil_nilai(b.nama_model) nama_model_singkat,
			isnull(c.komisi, 0) komisi_campaign, d.persentase_komisi,
			case isnull(dbo.ambil_kode(b.nama_model) , '') when '' then 1 else 0 end error_kode_accpac
			from penjualan_detail_ringkas a inner join openquery(MYSQLDMZ, 'select * from nolppco_modena.model') b 
				on a.id_model = b.id_model
			left outer join dbo.ufn_hitung_komisi_campaign_item() c on a.id_user = c.id_user and dbo.ambil_kode(b.nama_model) = c.kode_item
			left outer join persentase_komisi_item_campaign d on dbo.ambil_nilai(b.nama_model) like /*d.item + '%'*/case when len(d.item) <= 2 then d.item + '%' else d.item end
			";
		if ( count($arr_parameter) > 0 )
			$sql .= " where " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by isnull(dbo.ambil_kode(b.nama_model), b.nama_model)";
		echo "<!-- $sql -->" ;
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
		static function load_data_penjualan_rekap_view($arr_parameter = array()){
		$sql = "select *, harga * qty subtotal, isnull(dbo.ambil_kode(b.nama_model), b.nama_model) itemno, dbo.ambil_nilai(b.nama_model) nama_model_singkat,
			isnull(c.komisi, 0) komisi_campaign, d.persentase_komisi,
			case isnull(dbo.ambil_kode(b.nama_model) , '') when '' then 1 else 0 end error_kode_accpac
			from penjualan_detail_ringkas a inner join openquery(MYSQLDMZ, 'select * from nolppco_modena.model') b 
				on a.id_model = b.id_model
			left outer join dbo.ufn_hitung_komisi_campaign_item() c on a.id_user = c.id_user and dbo.ambil_kode(b.nama_model) = c.kode_item
			left outer join persentase_komisi_item_campaign d on dbo.ambil_nilai(b.nama_model) like d.item /*+ '%'*/
			";
		if ( count($arr_parameter) > 0 )
			$sql .= " where " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " order by isnull(dbo.ambil_kode(b.nama_model), b.nama_model)";
		echo "<!-- $sql -->" ;
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	
	static function insert_flow($area,$periode){
		$sql = "insert into flow_absensi values (".$periode.",'".main::formatting_query_string($area)."',1,0)";
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
	static function update_flow($area,$periode){
		$sql = "update flow_absensi set fpph = 1 where periode=".$periode." and area='".main::formatting_query_string($area)."'";
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}
	}
	
}

?>