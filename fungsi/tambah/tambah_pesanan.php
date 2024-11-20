<?php
    session_start(); // Memulai session
    require '../../config.php'; // Mengambil file konfigurasi

    if(isset($_GET['aksi']) && $_GET['aksi'] == 'simpan_pesanan') {
        // Ambil data dari form
        $id_pesanan = $_POST['id'];
        $total_bayar = str_replace('.', '', $_POST['total']); // Menghapus format titik pada total
        $nama_pemesan = $_POST['nama_pemesan'];
        $id_member = $_SESSION['admin']['id_member']; // ID kasir dari session
        $tanggal_input = $_POST['tanggal_input'];

        // Pastikan id_pesanan tidak kosong
        if(empty($id_pesanan)) {
            echo "<script>alert('ID pesanan tidak valid.'); window.location = '../../index.php?page=pesan';</script>";
            exit;
        }

        try {
            // Mulai transaksi
            $config->beginTransaction();

            // Query untuk menyimpan data ke dalam tabel pesanan
            $query = "INSERT INTO pesanan (id_pesanan, total, nama_pemesan, id_member, tanggal_input) 
                    VALUES (:id_pesanan, :total, :nama_pemesan, :id_member, :tanggal_input)";
            $stmt = $config->prepare($query);
            $stmt->bindParam(':id_pesanan', $id_pesanan);
            $stmt->bindParam(':total', $total_bayar);
            $stmt->bindParam(':nama_pemesan', $nama_pemesan);
            $stmt->bindParam(':id_member', $id_member);
            $stmt->bindParam(':tanggal_input', $tanggal_input);
            $stmt->execute();

            // Simpan detail penjualan jika ada
            if(isset($_SESSION['pemesanan']) && count($_SESSION['pemesanan']) > 0) {
                foreach($_SESSION['pemesanan'] as $item) {
                    $id_barang = $item['id_barang'];
                    $jumlah = $item['jumlah'];
                    $total = $item['total'];


                    // Query untuk menyimpan detail pesanan
                    $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_barang, jumlah, total) 
                                    VALUES (:id_pesanan, :id_barang, :jumlah, :total)";
                    $stmt_detail = $config->prepare($query_detail);
                    $stmt_detail->bindParam(':id_pesanan', $id_pesanan);
                    $stmt_detail->bindParam(':id_barang', $id_barang);
                    $stmt_detail->bindParam(':jumlah', $jumlah);
                    $stmt_detail->bindParam(':total', $total);
                    $stmt_detail->execute();
                }
            }

            // Commit transaksi
            $config->commit();

            // Kosongkan session penjualan setelah pesanan berhasil disimpan
            unset($_SESSION['pemesanan']);

            // Redirect atau pesan sukses
            echo "<script>alert('Pesanan berhasil disimpan!'); window.location = '../../index.php?page=pesan';</script>";
        } catch (PDOException $e) {
            // Rollback transaksi jika terjadi kesalahan
            $config->rollBack();
            echo "<script>alert('Terjadi kesalahan saat menyimpan pesanan: " . $e->getMessage() . "'); window.location = '../../index.php?page=pesan';</script>";
        }
    }
?>
