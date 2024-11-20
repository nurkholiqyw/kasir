<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .nota-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .nota-header {
            text-align: center;
        }
        .nota-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .nota-table th, .nota-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .nota-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h2>Nota Pembelian</h2>
            <p><strong>Nama Member:</strong> <?= htmlspecialchars($_GET['nm_member'] ?? 'N/A'); ?></p>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Merk</th>
                    <th>ID Pesanan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Parsing data dari URL
                $merk = explode(',', $_GET['merk'] ?? '');
                $id_pesanan = explode(',', $_GET['id'] ?? '');
                $total_harga = $_GET['total'] ?? 0;
                $bayar = $_GET['bayar'] ?? 0;
                $kembali = $_GET['kembali'] ?? 0;

                foreach ($id_pesanan as $index => $id) {
                    echo '<tr>';
                    echo '<td>' . ($index + 1) . '</td>';
                    echo '<td>' . htmlspecialchars($merk[$index] ?? '-') . '</td>';
                    echo '<td>' . htmlspecialchars($id) . '</td>';
                    echo '<td>1</td>'; // Asumsi jumlah 1, sesuaikan dengan data yang tersedia
                    echo '<td>Rp ' . number_format($total_harga / count($id_pesanan), 0, ',', '.') . '</td>'; // Contoh hitung total per item
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="nota-footer">
            <p><strong>Total:</strong> Rp <?= number_format($total_harga, 0, ',', '.'); ?></p>
            <p><strong>Bayar:</strong> Rp <?= number_format($bayar, 0, ',', '.'); ?></p>
            <p><strong>Kembali:</strong> Rp <?= number_format($kembali, 0, ',', '.'); ?></p>
        </div>
    </div>
</body>
</html>
