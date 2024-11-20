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
    header('Location: index.php?page=jual&remove=yes'); // Redirect dengan pesan sukses
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
	<h4>Pilih Pesanan Yang Mau Dikonfirmasi</h4>
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
		
		

		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-shopping-cart"></i> Konfirmasi Pesanan
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
									<td> ID_Pesanan</td>
									<td style="width:10%;"> Total</td>
									<td style="width:20%;"> Nama Pemesan</td>
									<td> ID Member</td>
                                    <td>Nama Kasir</td>
									<td> Aksi</td>
								</tr>
							</thead>
							<tbody>
								<?php 
								session_start(); // Memulai session
								$total_bayar=0;
								$no=1; 
								
								$hasil_penjualan =  $lihat -> tampilkan_pesanan();
								?>
								<?php foreach($hasil_penjualan  as $isi){?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $isi['id_pesanan'];?></td>
									<td>Rp. <?php echo number_format($isi['total']) ;?>,-</td>
									<td><?php echo $isi['nama_pemesan'];?></td>
									<td><?php echo $isi['id_member'];?></td>
									<td><?php echo $isi['nm_member'];?></td>
									<td>
										<a class="btn btn-primary" href="index.php?page=konfirmasi/detail&id=<?php echo $isi['id_pesanan'];?>">Detail</a>
                                        
										<a href="fungsi/hapus/hapus.php?pesanan=hapus&id=<?php echo $isi['id_pesanan'];?>"
										onclick="javascript:return confirm('Hapus Data barang ?');"><button
											class="btn btn-danger btn-xs">Hapus</button>
										</a>
									</td>
								</tr>
								<?php $no++; $total_bayar += $isi['total'];}?>
							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


<script>
// AJAX call for autocomplete 
$(document).ready(function(){
	$("#cari").change(function(){
		$.ajax({
			type: "POST",
			url: "fungsi/edit/edit.php?cari_barang=yes",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#hasil_cari").hide();
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





</script>