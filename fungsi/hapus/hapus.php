<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    if (!empty(htmlentities($_GET['kategori']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM kategori WHERE id_kategori=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['barang']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM barang WHERE id_barang=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['pesanan']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;

        $sql1 = 'DELETE FROM pesanan WHERE id_pesanan=?';
        $row = $config -> prepare($sql1);
        $row -> execute($data);

        $sql2 = 'DELETE FROM detail_pesanan WHERE id_pesanan=?';
        $row = $config -> prepare($sql2);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=konfirmasi&&remove=hapus-data"</script>';
    }

    // if (!empty(htmlentities($_GET['user']))) {
    //     $id= htmlentities($_GET['id']);
    //     $data[] = $id;

    //     $sql1 = 'DELETE FROM member WHERE id_member=?';
    //     $row = $config -> prepare($sql1);
    //     $row -> execute($data);

    //     $sql2 = 'DELETE FROM login WHERE id_member=?d';
    //     $row = $config -> prepare($sql2);
    //     $row -> execute($data);
    //     echo '<script>window.location="../../index.php?page=user&&remove=hapus-data"</script>';
    // }

    if (!empty(htmlentities($_GET['user']))) {
    $id = htmlentities($_GET['id']);
    $data = [$id]; // Simpan id ke dalam array $data

    // Hapus data dari tabel member
    $sql1 = 'DELETE FROM member WHERE id_member = ?';
    $row = $config->prepare($sql1);
    $row->execute($data);

    // Hapus data dari tabel login
    $sql2 = 'DELETE FROM login WHERE id_member = ?';
    $row = $config->prepare($sql2);
    $row->execute($data);

    // Redirect setelah penghapusan selesai
    echo '<script>window.location="../../index.php?page=user&&remove=hapus-data"</script>';
}


    // if (!empty(htmlentities($_GET['jual']))) {
    //     $dataI[] = htmlentities($_GET['brg']);
    //     $sqlI = 'select*from barang where id_barang=?';
    //     $rowI = $config -> prepare($sqlI);
    //     $rowI -> execute($dataI);
    //     $hasil = $rowI -> fetch();

    //     /*$jml = htmlentities($_GET['jml']) + $hasil['stok'];

    //     $dataU[] = $jml;
    //     $dataU[] = htmlentities($_GET['brg']);
    //     $sqlU = 'UPDATE barang SET stok =? where id_barang=?';
    //     $rowU = $config -> prepare($sqlU);
    //     $rowU -> execute($dataU);*/

    //     $id = htmlentities($_GET['id']);
    //     $data[] = $id;
    //     $sql = 'DELETE FROM penjualan WHERE id_penjualan=?';
    //     $row = $config -> prepare($sql);
    //     $row -> execute($data);
    //     echo '<script>window.location="../../index.php?page=jual"</script>';
    // }

    
session_start(); // Memulai sesi

if (!empty(htmlentities($_GET['jual']))) {
    $id_barang = htmlentities($_GET['brg']); // Mengambil id_barang dari parameter GET

    // Memeriksa apakah ada session 'penjualan'
    if (isset($_SESSION['penjualan']) && !empty($_SESSION['penjualan'])) {
        foreach ($_SESSION['penjualan'] as $key => $item) {
            // Jika id_barang dari session cocok dengan yang di GET
            if ($item['id_barang'] == $id_barang) {
                // Menghapus item dari session penjualan
                unset($_SESSION['penjualan'][$key]);
                break; // Hentikan loop setelah menemukan item yang sesuai
            }
        }

        // Mengatur ulang indeks array setelah penghapusan
        $_SESSION['penjualan'] = array_values($_SESSION['penjualan']);

        echo '<script>alert("Barang berhasil dihapus dari keranjang penjualan.");</script>';
    } else {
        echo '<script>alert("Tidak ada data penjualan yang ditemukan.");</script>';
    }

    // Mengarahkan pengguna kembali ke halaman jual
    echo '<script>window.location="../../index.php?page=jual"</script>';
}

if (!empty(htmlentities($_GET['pesan']))) {
    $id_barang = htmlentities($_GET['brg']); // Mengambil id_barang dari parameter GET

    // Memeriksa apakah ada session 'penjualan'
    if (isset($_SESSION['pemesanan']) && !empty($_SESSION['pemesanan'])) {
        foreach ($_SESSION['pemesanan'] as $key => $item) {
            // Jika id_barang dari session cocok dengan yang di GET
            if ($item['id_barang'] == $id_barang) {
                // Menghapus item dari session pemesanan
                unset($_SESSION['pemesanan'][$key]);
                break; // Hentikan loop setelah menemukan item yang sesuai
            }
        }

        // Mengatur ulang indeks array setelah penghapusan
        $_SESSION['pemesanan'] = array_values($_SESSION['pemesanan']);

        echo '<script>alert("Barang berhasil dihapus dari keranjang pesanan.");</script>';
    } else {
        echo '<script>alert("Tidak ada data pesanan yang ditemukan.");</script>';
    }

    // Mengarahkan pengguna kembali ke halaman jual
    echo '<script>window.location="../../index.php?page=pesan"</script>';
}





    if (!empty(htmlentities($_GET['penjualan']))) {
        $sql = 'DELETE FROM penjualan';
        $row = $config -> prepare($sql);
        $row -> execute();
        echo '<script>window.location="../../index.php?page=jual"</script>';
    }
    
    if (!empty(htmlentities($_GET['laporan']))) {
        $sql = 'DELETE FROM nota';
        $row = $config -> prepare($sql);
        $row -> execute();
        echo '<script>window.location="../../index.php?page=laporan&remove=hapus"</script>';
    }
}
