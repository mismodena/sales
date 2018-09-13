<?

class penjualan extends sql{

	/*
	parameter $area = array(), opsinya
	array("b.id_user", "[nilai]")
	array("c.area", "[nilai]")
	*/	
	static function data_penjualan($arr_area_user, $tanggal_awal, $tanggal_akhir){
		$sql = "
			select *, dbo.ambil_nilai(nama_user) nama_spg, isnull(dbo.ambil_kode(nama_user), 0) [target],
				SGTDAT.dbo.ufnDiskonDealer(dbo.ambil_kode(store)) level_diskon,
				dbo.ambil_nilai(store) nama_toko, dbo.ambil_kode(store) kodeaccpac_toko
			from openquery(
				mysqldmz, 
				'select b.id_user, b.nama_user, c.*, ifnull(d.total_penjualan, 0) total_penjualan from 
				". $GLOBALS["db_mysql"] .".`user` b inner join ". $GLOBALS["db_mysql"] .".area_store c on b.idarea = c.idarea left outer join 
				(select sum(harga * qty) total_penjualan, id_sales from 
					". $GLOBALS["db_mysql"] .".penjualan a, ". $GLOBALS["db_mysql"] .".`penjualan_detail` b 
					where a.id_penjualan = b.id_penjualan 
					and a.tanggal >= ''". main::formatting_query_string($tanggal_awal) ."'' 
					and a.tanggal <= ''". main::formatting_query_string($tanggal_akhir) ."'' group by id_sales
				) d 
				on b.id_user = d.id_sales 
				where ". $arr_area_user[0] ." = ''". main::formatting_query_string($arr_area_user[1]) ."'' ') a 
			left outer join kelas_dealer b on dbo.ambil_kode(a.store) = b.dealer order by a.nama_user
		";
		return sql::execute($sql);
	}
	
	static function detail_penjualan($arr_parameter = array()){
		$sql = "
			select *, harga * qty subtotal, convert(float, e.unitprice) * qty subtotal_netprice, isnull(dbo.ambil_kode(nama_model) , nama_model) itemno, 
				case isnull(dbo.ambil_kode(nama_model) , '') when '' then 1 else 0 end error_kode_accpac from openquery(
				mysqldmz, 
				'select a.faktur, a.id_sales, a.nama_customer, a.notelp_customer, alamat_customer, a.tanggal, b.*, c.nama_model
				from ". $GLOBALS["db_mysql"] .".penjualan a, ". $GLOBALS["db_mysql"] .".`penjualan_detail` b, ". $GLOBALS["db_mysql"] .".model c 
				where 
					a.id_penjualan = b.id_penjualan and b.id_model=c.id_model ";
					
		if ( count($arr_parameter) > 0 )
			$sql .= " and " . sql::sql_parameter( $arr_parameter );
		
		$sql .= " ') a 
				inner join sgtdat..ICITEM b 
					on isnull(dbo.ambil_kode(a.nama_model) , a.nama_model) = b.fmtitemno
				inner join mesdb..tbl_icitem c 
					on b.ITEMNO = c.ITEMNO
				inner join sgtdat..ICPRIC d on b.ITEMNO = d.ITEMNO 
				left join sgtdat..ICPRICP e on d.ITEMNO = e.ITEMNO and d.PRICELIST = e.PRICELIST and d.CURRENCY = e.CURRENCY 
				where
				c.MODEL is not null and b.ITEMBRKID in ('FG', 'MDS') and 
					b.INACTIVE = 0 and b.[DESC] not like '%SAMPLE%' and
					DPRICETYPE = 1 and e.CURRENCY = 'IDR' and d.pricelist='STD' /*ITEMNO*/
				order by a.tanggal asc
		";
		
		try{		return sql::execute( $sql );	}
		catch(Exception $e){$e->getMessage();}		
	}
}

?>