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
	<h4>Keranjang Penjualan</h4>
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
					<input type="text" id="cari" class="form-control" name="cari" placeholder="Masukan : Kode / Nama Barang  [ENTER]">
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
								
								$hasil_penjualan = isset($_SESSION['penjualan']) ? $_SESSION['penjualan'] : [];
								?>
								<?php foreach($hasil_penjualan  as $isi){?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $isi['merk'];?></td>
									<td>
										<!-- aksi ke table penjualan -->
										<form method="POST" action="fungsi/edit/edit.php?jual=jual">
												<input type="number" name="jumlah" value="<?php echo $isi['jumlah'];?>" class="form-control">
												<input type="hidden" name="id" value="<?php echo $isi['id_penjualan'];?>" class="form-control">
												<input type="hidden" name="id_barang" value="<?php echo $isi['id_barang'];?>" class="form-control">
												<input type="hidden" name="tgl_input[]" value="<?php echo $isi['tanggal_input'];?>">
											</td>
											<td>Rp.<?php echo number_format($isi['total']);?>,-</td>
											<td><?php echo $_SESSION['admin']['nm_member'];?></td>
											<td>
												<button type="submit" class="btn btn-warning">Update</button>
										</form>
										<!-- aksi ke table penjualan -->
										<a href="fungsi/hapus/hapus.php?jual=jual&id=<?php echo $isi['id_penjualan'];?>&brg=<?php echo $isi['id_barang'];?>
											&jml=<?php echo $isi['jumlah']; ?>"  class="btn btn-danger"><i class="fa fa-times"></i>
										</a>
									</td>
								</tr>
								<?php $no++; $total_bayar += $isi['total'];}?>
							</tbody>
					</table>
					<br/>
					<?php $hasil = $lihat -> jumlah(); ?>
					<div id="kasirnya">
						<table class="table table-stripped">
							<?php
							// proses bayar dan ke nota
							if(!empty($_GET['nota'] == 'yes')) {
								$total = $_POST['total'];
								$bayar = $_POST['bayar'];
								if(!empty($bayar))
								{
									$hitung = $bayar - $total;
									if($bayar >= $total)
									{
										$id_barang = $_POST['id_barang'];
										$id_member = $_POST['id_member'];
										$jumlah = $_POST['jumlah'];
										$total = $_POST['total1'];
										$tgl_input = $_POST['tgl_input'];
										$periode = $_POST['periode'];
										$jumlah_dipilih = count($id_barang);
										
										for($x=0;$x<$jumlah_dipilih;$x++){

											$d = array($id_barang[$x],$id_member[$x],$jumlah[$x],$total[$x],$tgl_input[$x],$periode);
											$sql = "INSERT INTO nota (id_barang,id_member,jumlah,total,tanggal_input,periode) VALUES(?,?,?,?,?,?)";
											$row = $config->prepare($sql);
											$row->execute($d);

											// ubah stok barang
											$sql_barang = "SELECT * FROM barang WHERE id_barang = ?";
											$row_barang = $config->prepare($sql_barang);
											$row_barang->execute(array($id_barang[$x]));
											$hsl = $row_barang->fetch();
											
											$stok = $hsl['stok'];
											$idb  = $hsl['id_barang'];

											$total_stok = $stok - $jumlah[$x];
											// echo $total_stok;
											$sql_stok = "UPDATE barang SET stok = ? WHERE id_barang = ?";
											$row_stok = $config->prepare($sql_stok);
											$row_stok->execute(array($total_stok, $idb));
										}

										// $sql_hapus = "DELETE FROM penjualan"; // Hapus semua data penjualan
           								// $config->prepare($sql_hapus)->execute();

										// echo '<script>alert("Belanjaan Berhasil Di Bayar !");</script>';

										echo '<script>window.location.href = `print.php?nm_member=${nm_member}&bayar=${bayar}&kembali=${kembali}`;</script>';
										
									}else{
										echo '<script>alert("Uang Kurang ! Rp.'.$hitung.'");</script>';
									}
								}
							}
							?>
							<!-- aksi ke table nota -->
							<form method="POST" action="index.php?page=jual&nota=yes#kasirnya">
								<?php foreach($hasil_penjualan as $isi){?>
									<input type="hidden" name="id_barang[]" value="<?php echo $isi['id_barang'];?>">
									<input type="hidden" name="id_member[]" value="<?php echo $isi['id_member'];?>">
									<input type="hidden" name="jumlah[]" value="<?php echo $isi['jumlah'];?>">
									<input type="hidden" name="total1[]" value="<?php echo $isi['total'];?>">
									<input type="hidden" name="tgl_input[]" value="<?php echo $isi['tanggal_input'];?>">
									<input type="hidden" name="periode[]" value="<?php echo date('m-Y');?>">
								<?php $no++; }?>

								<tr>
									<td>Total Semua</td>
									<td><input type="text" class="form-control" name="total" id="total" value="<?php echo number_format($total_bayar, 0, ',', '.'); ?>" onkeyup="formatRupiah(this); calculateChange();" readonly></td>

								
									<td>Bayar</td>
									<td><input type="text" class="form-control" name="bayar" id="bayar" value="<?php echo number_format($bayar, 0, ',', '.'); ?>" onkeyup="formatRupiah(this); calculateChange();"></td>
									<td>
										<!-- <button type="button" class="btn btn-success" onclick="prosesBayar()">
											<i class="fa fa-shopping-cart"></i> Bayar
										</button> -->

										
											<button type="button" class="btn btn-success" onclick="prosesBayar()" data-target="#p">
												<i class="fa fa-shopping-cart"></i> Bayar
											</button>
										

										<?php if(!empty($_GET['nota'] == 'yes')) {?>
											<a class="btn btn-danger" href="fungsi/hapus/hapus.php?penjualan=jual">
											<b>RESET</b></a>
										<?php } ?>
									</td>
								</tr>
							</form>
							<!-- aksi ke table nota -->
							<tr>
								<td>Kembali</td>
								<td><input type="text" class="form-control" id="kembali" readonly></td>
								<td></td>
								<td>
									<a href="print.php?nm_member=<?php echo $_SESSION['admin']['nm_member'];?>
									&bayar=<?php echo $bayar;?>&kembali=<?php echo $hitung;?>" target="_blank">
									<button class="btn btn-secondary">
										<i class="fa fa-print"></i> Print Untuk Bukti Pembayaran
									</button></a>
								</td>
							</tr>

						</table>
						<br/>
						<br/>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style=" border-radius:0px;">
                    <div class="modal-header" style="background:#285c64;color:#fff;">
                        <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Barang</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="fungsi/tambah/tambah.php?barang=tambah" method="POST">
                        <div class="modal-body">
                            <table class="table table-striped bordered">
                                <?php
									$format = $lihat -> barang_id();
								?>
                                <tr>
                                    <td>ID Barang</td>
                                    <td><input type="text" readonly="readonly" required value="<?php echo $format;?>"
                                            class="form-control" name="id"></td>
                                </tr>
                                
                                <tr>
                                    <td>Nama Barang</td>
                                    <td><input type="text" placeholder="Nama Barang" required class="form-control"
                                            name="nama"></td>
                                </tr>
                                <tr>
                                    <td>Merk Barang</td>
                                    <td><input type="text" placeholder="Merk Barang" required class="form-control"
                                            name="merk"></td>
                                </tr>
                                <tr>
                                    <td>Harga Beli</td>
                                    <td><input type="number" placeholder="Harga beli" required class="form-control"
                                            name="beli"></td>
                                </tr>
                                <tr>
                                    <td>Harga Jual</td>
                                    <td><input type="number" placeholder="Harga Jual" required class="form-control"
                                            name="jual"></td>
                                </tr>
                                <tr>
                                    <td>Satuan Barang</td>
                                    <td>
                                        <select name="satuan" class="form-control" required>
                                            <option value="#">Pilih Satuan</option>
                                            <option value="Kg">Kg</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td><input type="number" required Placeholder="Stok" class="form-control"
                                            name="stok"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Input</td>
                                    <td><input type="text" required readonly="readonly" class="form-control"
                                            value="<?php echo  date("j F Y, G:i");?>" name="tgl"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Insert
                                Data</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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



//batas lagi cuy

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

// Fungsi untuk menghitung kembalian
function calculateChange() {
    // Ambil nilai total dan bayar, hilangkan format titik (.) terlebih dahulu
    var total = parseInt(document.getElementById('total').value.replace(/\./g, '')) || 0;
    var bayar = parseInt(document.getElementById('bayar').value.replace(/\./g, '')) || 0;

    // Hitung kembalian
    var kembali = bayar - total;

    // Tampilkan kembalian dengan format rupiah
    document.getElementById('kembali').value = formatCurrency(kembali);

    // Jika total lebih besar dari bayar, tambahkan tanda minus
    if (kembali < 0) {
        document.getElementById('kembali').value = '-' + formatCurrency(Math.abs(kembali));
    }
}

// Fungsi untuk memformat angka menjadi format rupiah tanpa IDR
function formatCurrency(amount) {
    var reverse = amount.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    
    return ribuan;
}

// Format otomatis saat halaman dimuat
window.onload = function() {
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    
    // Format input total dan bayar saat load
    formatRupiah(totalInput);
    formatRupiah(bayarInput);
};



function prosesBayar() {
    var total = parseInt(document.getElementById('total').value.replace(/\./g, '')) || 0;
    var bayar = parseInt(document.getElementById('bayar').value.replace(/\./g, '')) || 0;

    // Cek jika bayar cukup
    if (bayar >= total) {
        var id_barang = [];
        var id_member = [];
        var jumlah = [];
        var total1 = [];
        var tgl_input = [];
        var periode = [];

        // Mengambil data dari hidden input
        document.querySelectorAll('input[name="id_barang[]"]').forEach(function(input) {
            id_barang.push(input.value);
        });
        document.querySelectorAll('input[name="id_member[]"]').forEach(function(input) {
            id_member.push(input.value);
        });
        document.querySelectorAll('input[name="jumlah[]"]').forEach(function(input) {
            jumlah.push(input.value);
        });
        document.querySelectorAll('input[name="total1[]"]').forEach(function(input) {
            total1.push(input.value);
        });
        document.querySelectorAll('input[name="tgl_input[]"]').forEach(function(input) {
            tgl_input.push(input.value);
        });
        periode = new Date().toLocaleString('default', { month: 'numeric' }) + '-' + new Date().getFullYear();
		

        // Mengirimkan data ke server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?page=jual&nota=yes", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status == 200) {
                // Redirect ke halaman print
                var url = "print.php?nm_member=<?php echo $_SESSION['admin']['nm_member']; ?>&bayar=" + bayar + "&kembali=" + (bayar - total) + "&total=" + total ;
                window.open(url); // Membuka jendela baru untuk print
                window.location.href='index.php?page=jual&reset=yes';
            }
        };

        // Mengirim data
        var data = "id_barang[]=" + id_barang.join("&id_barang[]=") +
                   "&id_member[]=" + id_member.join("&id_member[]=") +
                   "&jumlah[]=" + jumlah.join("&jumlah[]=") +
                   "&total1[]=" + total1.join("&total1[]=") +
                   "&tgl_input[]=" + tgl_input.join("&tgl_input[]=") +
                   "&periode=" + periode +
                   "&total=" + total + "&bayar=" + bayar;
				   console.log("Data yang dikirim:", data); // Debugging data yang akan dikirim

        xhr.send(data);

		
    } else {
        alert("Uang Kurang! Total: Rp." + total + ", Bayar: Rp." + bayar);
    }
}

</script>