<?
include "includes/top_blank.php";
?>
			
<div style="float:left; width:100%; padding-left:19px; padding-top:13px; margin-bottom:11px;">
	<div>Nama SPG/M : <?=strtoupper(@$data_penjualan["nama_spg"])?></div>
	<div>Area - Toko | Kode ACCPAC : <?=strtoupper(@$data_penjualan["area"])?> - <?=strtoupper($data_penjualan["store"])?></div>
	<div id="div-detail-header" onclick="tampilkan_detail(this, true)"><a href="javascript:void(0)" id="link-detail-header">Tampilkan detail</a></div>
	<div id="detail-header" style="display:none">
		<div>Kelas Dealer : <?=@$data_penjualan["kelas"]?></div>
		<div>Level Diskon (%) : <?=@$data_penjualan["level_diskon"]?></div>
		<div>
			Periode Penjualan : <br />
			<input type="text" name="t_tanggal_awal" id="t_tanggal_awal" 
								style="width:163px" maxlength="50" onchange="ubahtanggal()"
								value="<?=$s_tanggal_awal_formatted?>" readonly /> s/d 
				<input type="text" name="t_tanggal_akhir" id="t_tanggal_akhir" 
									style="width:163px" maxlength="50" onchange="ubahtanggal()"
									value="<?=$s_tanggal_akhir_formatted?>" readonly />
				<input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?=$s_tanggal_awal_formatted?>" />
				<input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?=$s_tanggal_akhir_formatted?>" />
		</div>
		<div>Target Penjualan (Rp) : <?=@number_format($data_penjualan["target"])?></div>
		<div>Total Penjualan (Rp) pada rentang periode di atas : <?=@number_format($s_grand_total_sellin)?></div>
		<div>Total Penjualan Setelah Pajak (Rp) pada rentang periode di atas : <?=@number_format( ($s_grand_total_sellin / 1.1))  ?> ( persentase : <?=$data_penjualan["target"] > 0 ? round( ($s_grand_total_sellin/1.1) / $data_penjualan["target"], 2) * 100 : 0 ?>% )</div>
		<input type="hidden" id="hd_total_penjualan" value="<?= (@$s_grand_total_sellin / 1.1)?>" />
	</div>
</div>
<input type="button" id="b_kembali" value="Lihat Data Penjualan" style="width:100%; margin:0px"
			onclick="javascript:location.href=''" />
<div style="padding:3px" id="kontainer-isian">
	<h3>Input Data Penjualan - Detail Konsumen</h3>
	<div>
		Tanggal Faktur<br />
		<?=isian_tanggal(1)?>
	</div>
	<div>
		Nomor Faktur<br />
		<?=isian_teks("faktur", 1)?>
	</div>
	<div>
		Nama Konsumen<br />
		<?=isian_teks("nama", 1)?>
	</div>
	<div>
		Alamat Konsumen<br />
		<?=isian_teks("alamat", 1)?>
	</div>
	<div>
		Nomor Telepon<br />
		<?=isian_teks("telepon", 1)?>
	</div>
	<div>
		Telepon Selular<br />
		<?=isian_teks("telepon_selular", 1)?>
	</div>
	<div>
		Email<br />
		<?=isian_teks("email", 1)?>
	</div>
	<div>
		Upload Faktur<br />
		<input type="file" name="fl" id="fl" style="width:100%" />
	</div>
	
	<h3>Input Data Penjualan - Detail Item Penjualan</h3>
	<div id="div_item" style="border-top:1px solid #CCC; border-bottom:1px solid #CCC; float:left; width:100%">
		<table id="table-data" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td style="background-color:#EEE; padding:13px">
					<div>Produk<br /><?=pilihan_item(1, bikin_opsi_selectbox( $arr_opsi_selectbox_item ) )?></div>
					<div>Harga Sell-out<br /><?=isian_harga_tidakreadonly(1)?></div>
					<div>Harga Sell-in<br /><?=isian_harga_sellin(1)?></div>
					<div>Margin<br /><?=margin(1)?></div>
					<div>Jumlah<br /><?=isian_qty(1)?></div>
					<div>Sub Total Sell-out (Rp) : <?= isian_hidden(1) ?></div>
					<div>Sub Total Sell-in (Rp) : <?= isian_hidden_sellin(1) ?></div>
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="jumlah_item" id="jumlah_item" value="1" />
	<input type="button" name="b_tambah_item" id="b_tambah_item" value="Tambah Item Penjualan" onclick="tambah_penjualan()" style="width:100%; margin-top:13px" />
	<div>
		<h3>Total Item (unit) : <span id="col_grand_total_item"></span></h3>
		<h3>Total Sell-out (Rp) : <span id="col_grand_total"></span></h3>
		<h3>Total Sell-in (Rp) : <span id="col_grand_total_sellin"></span></h3>
	</div>
</div>
<input type="button" name="b_tambah_item" id="b_tambah_item" value="Kirim Data Penjualan" onclick="kirim_data_penjualan()" style="width:100%; margin-top:13px" />

<input type="hidden" name="area" value="<?=$_REQUEST["area"]?>" />
<input type="hidden" name="user_id" value="<?=$_REQUEST["user_id"]?>" />
<input type="hidden" name="tanggal_awal" value="<?=$_REQUEST["tanggal_awal"]?>" />
<input type="hidden" name="tanggal_akhir" value="<?=$_REQUEST["tanggal_akhir"]?>" />
<input type="hidden" id="perubahan_data"  />
<?
include "includes/bottom_blank.php";
?>