<?php
// Inisialisasi variabel
$stok_awal = 0;
$demand_tahunan = 0;
$biaya_pemesanan = 0;
$biaya_penyimpanan = 0;
$eoq = 0;
$stok = 0;
$pesan = "";

// Fungsi untuk menghitung EOQ
function hitung_eoq($demand, $ordering_cost, $holding_cost) {
    return sqrt((2 * $demand * $ordering_cost) / $holding_cost);
}

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stok_awal = (float)$_POST['stok_awal'];
    $demand_tahunan = (float)$_POST['demand_tahunan'];
    $biaya_pemesanan = (float)$_POST['biaya_pemesanan'];
    $biaya_penyimpanan = (float)$_POST['biaya_penyimpanan'];
    $stok = $stok_awal;

    // Hitung EOQ
    $eoq = hitung_eoq($demand_tahunan, $biaya_pemesanan, $biaya_penyimpanan);

    // Menangani penjualan beras
    if (isset($_POST['jual_beras']) && $_POST['jumlah_jual'] != "") {
        $jumlah_jual = (float)$_POST['jumlah_jual'];
        if ($jumlah_jual <= $stok) {
            $stok -= $jumlah_jual;
            $pesan = "Berhasil menjual $jumlah_jual kg beras.";
        } else {
            $pesan = "Stok beras tidak mencukupi!";
        }
    }

    // Menangani pembelian stok beras berdasarkan EOQ
    if (isset($_POST['beli_stok'])) {
        $stok += $eoq;
        $pesan = "Menambah stok sebanyak $eoq kg berdasarkan EOQ.";
    }
}
?>

<div class="card card-body">
	<div class="table-responsive">
		<table class="table table-striped">
			<form action="" method="POST">
				<tr>
					<td>Stok Awal (kg):</td>
					<td><input type="number" class="form-control" name="stok_awal" value="<?= $stok_awal ?>" step="0.01" required></td>
				</tr>

				<tr>
					<td>Total Permintaan Tahunan (kg):</td>
					<td><input type="number" class="form-control" name="demand_tahunan" value="<?= $demand_tahunan ?>" step="0.01" required></td>
				</tr>
				<tr>
					<td>Biaya Pemesanan (rupiah):</td>
					<td><input type="number" class="form-control" name="biaya_pemesanan" value="<?= $biaya_pemesanan ?>" step="0.01" required></td>
				</tr>
				<tr>
					<td>Biaya Penyimpanan per kg per tahun (rupiah):</td>
					<td><input type="number" class="form-control" name="biaya_penyimpanan" value="<?= $biaya_penyimpanan ?>" step="0.01" required></td>
				</tr>
				
					<td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="beli_stok" value="Beli Stok EOQ"></td>
				</tr>
			</form>
		</table>

        <div class="hasil">
            <h3>Hasil:</h3>
            <p>Stok Beras Saat Ini: <?= $stok ?> kg</p>
            <p>EOQ (Economic Order Quantity): <?= number_format($eoq, 2) ?> kg</p>
            <p><?= $pesan ?></p>
        </div>
	</div>
</div>