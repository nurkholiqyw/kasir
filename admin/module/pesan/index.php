 <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
<?php 
session_start(); // Pastikan session dimulai

// Cek jika ada permintaan untuk reset keranjang
if (isset($_GET['reset']) && $_GET['reset'] == 'yes') {
    unset($_SESSION['penjualan']); // Hapus data session penjualan
    header('Location: index.php?page=pesan&remove=yes'); // Redirect dengan pesan sukses
    exit();
}

// Ambil data periode
if (isset($_POST['periode'])) {
    $periode = $_POST['periode'];
    error_log("Periode yang diterima: " . $periode); // Log untuk debugging
} else {
    error_log("Periode tidak diterima.");
}


	$id = $_SESSION['admin']['id_member'];
	$hasil = $lihat -> member_edit($id);
?>
	<h4>Pemesanan</h4>
	<br>
	<?php if(isset($_GET['success'])){?>
	<div class="alert alert-success">
		<p>Edit Data Berhasil !</p>
	</div>
	<?php }?>
	<?php if(isset($_GET['remove'])){?>
	<div class="alert alert-danger">
		<p>Hapus Data Berhasil !</p>
	</div>
	<?php }?>
	<div class="row">
		<div class="col-sm-4">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-search"></i> Cari Barang</h5>
				</div>
				<div class="card-body">
					<input type="text" id="cari_p" class="form-control" name="cari_p" placeholder="Masukan : Kode / Nama Barang  [ENTER]">
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-list"></i> Hasil Pencarian</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div id="hasil_cari"></div>
						<div id="tunggu"></div>
					</div>
				</div>
			</div>
		</div>
		

		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-shopping-cart"></i> KASIR
					<a class="btn btn-danger float-right" 
						onclick="javascript:return confirm('Apakah anda ingin reset keranjang ?');" 
						href="index.php?page=jual&reset=yes">
						<b>RESET KERANJANG</b></a>
					</h5>
				</div>
				<div class="card-body">
					<div id="keranjang" class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td><b>Tanggal</b></td>
								<td><input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i");?>" name="tgl"></td>
							</tr>
						</table>
						<table class="table table-bordered w-100" id="example1">
							<thead>
								<tr>
									<td> No</td>
									<td> Merk</td>
									<td style="width:10%;"> Jumlah</td>
									<td style="width:20%;"> Total</td>
									<td> Kasir</td>
									<td> Aksi</td>
								</tr>
							</thead>
							<tbody>
								<?php 
								session_start(); // Memulai session
								$total_bayar=0;
								$no=1; 
								
								$hasil_penjualan = isset($_SESSION['pemesanan']) ? $_SESSION['pemesanan'] : [];
								?>
								<?php foreach($hasil_penjualan  as $isi){?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $isi['merk'];?></td>
									<td>
										<!-- aksi ke table penjualan -->
										<form method="POST" action="fungsi/edit/edit.php?pesan=pesan">
												<input type="number" name="jumlah" value="<?php echo $isi['jumlah'];?>" class="form-control">
												<input type="hidden" name="tanggal_input" value="<?php echo $isi['tanggal_input'];?>" class="form-control">
												<input type="hidden" name="" value="<?php echo $isi['id_penjualan'];?>" class="form-control">
												<input type="hidden" name="id_barang" value="<?php echo $isi['id_barang'];?>" class="form-control">
											</td>
											<td>Rp.<?php echo number_format($isi['total']);?>,-</td>
											<td><?php echo $_SESSION['admin']['nm_member'];?></td>
											<td>
												<button type="submit" class="btn btn-warning">Update</button>
										</form>
										<!-- aksi ke table penjualan -->
										<a href="fungsi/hapus/hapus.php?pesan=pesan&id=<?php echo $isi['id_penjualan'];?>&brg=<?php echo $isi['id_barang'];?>
											&jml=<?php echo $isi['jumlah']; ?>"  class="btn btn-danger"><i class="fa fa-times"></i>
										</a>
									</td>
								</tr>
								<?php $no++; $total_bayar += $isi['total'];}?>
							</tbody>
					</table>
					<br/>
					<div id="kasirnya">
						<table class="table table-stripped">
							<!-- aksi ke table nota -->
							<form method="POST" action="fungsi/tambah/tambah_pesanan.php?aksi=simpan_pesanan&reset=yes">
								<?php foreach($hasil_penjualan as $isi){?>
									<input type="hidden" name="id_barang[]" value="<?php echo $isi['id_barang'];?>">
									<input type="hidden" name="id_member[]" value="<?php echo $isi['id_member'];?>">
									<input type="hidden" name="jumlah[]" value="<?php echo $isi['jumlah'];?>">
									<input type="hidden" name="total1[]" value="<?php echo $isi['total'];?>">
									<input type="hidden" name="tanggal_input" value="<?php echo $isi['tanggal_input'];?>">
									<input type="hidden" name="periode[]" value="<?php echo date('m-Y');?>">
								<?php $no++; }?>
                                <tr>
                                    <td>ID Pesanan</td>
                                    <td><input type="text" readonly="readonly" required value="<?php echo $lihat -> pesan_id();?>" class="form-control" name="id"></td>
                                </tr>
									<td>Total Semua</td>
									<td><input type="text" class="form-control" name="total" id="total" value="<?php echo number_format($total_bayar, 0, ',', '.'); ?>" readonly></td>
									<td>Nama Pemesan</td>
									<td><input type="text" class="form-control" name="nama_pemesan"></td>
									<td>
											<button type="submit" class="btn btn-success" data-target="#p">
												<i class="fa fa-shopping-cart"></i> Simpan
											</button>
									</td>
								</tr>
							</form>
							<!-- aksi ke table nota -->
							
						</table>
						<br/>
						<br/>
					</div>
				</div>
			</div>
		</div>
	</div>


	

<script>
// AJAX call for autocomplete 
$(document).ready(function(){
	$("#cari_p").change(function(){
		$.ajax({
			type: "POST",
			url: "fungsi/edit/edit.php?cari_p=yes",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#hasil_haicari").hide();
				$("#tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
			},
			success: function(html){
				$("#tunggu").html('');
				$("#hasil_cari").show();
				$("#hasil_cari").html(html);
			}
		});
	});
});
function formatRupiah(angka) {
    let numberString = angka.value.replace(/[^,\d]/g, '').toString();
    let split = numberString.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    angka.value = rupiah;
}
</script>