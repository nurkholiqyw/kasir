<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    if (!empty($_GET['kategori'])) {
        $nama= htmlentities(htmlentities($_POST['kategori']));
        $tgl= date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori,tgl_input) VALUES(?,?)';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
    }

    if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        // $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $merk = htmlentities($_POST['merk']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $id;
        // $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang,id_kategori,nama_barang,merk,harga_beli,harga_jual,satuan_barang,stok,tgl_input) 
			    VALUES (?,1,?,?,?,?,?,?,?) ';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
    }

    if (!empty($_GET['user'])) {
    try {
        // Ambil data dari form
        $username = htmlentities($_POST['username']);
        $password = htmlentities($_POST['password']);
        $nm_member = htmlentities($_POST['nm_member']);
        $alamat_member = htmlentities($_POST['alamat']);
        $NIK = htmlentities($_POST['NIK']);
        $email = htmlentities($_POST['email']);
        $telepon = htmlentities($_POST['telepon']);
        $role = htmlentities($_POST['role']);
        $gambar = ""; // Pastikan ini sesuai, karena gambar belum didefinisikan

        // Mulai transaksi
        $config->beginTransaction();

        // Query untuk tabel member
        $sql1 = 'INSERT INTO member (nm_member, alamat_member, telepon, email, gambar, NIK) 
                VALUES (:nm_member, :alamat_member, :telepon, :email, :gambar, :NIK)';
        $row1 = $config->prepare($sql1);
        $row1->bindParam(':nm_member', $nm_member);
        $row1->bindParam(':alamat_member', $alamat_member);
        $row1->bindParam(':telepon', $telepon);
        $row1->bindParam(':email', $email);
        $row1->bindParam(':gambar', $gambar); // Jika gambar tidak ada, bisa diisi default
        $row1->bindParam(':NIK', $NIK);
        $row1->execute();

        // Ambil ID dari member yang baru dimasukkan
        $id_member = $config->lastInsertId();

        // Query untuk tabel login
        $sql2 = 'INSERT INTO login (user, pass, id_member, role) 
                VALUES (:user, MD5(:pass), :id_member, :role)';
        $row2 = $config->prepare($sql2);
        $row2->bindParam(':user', $username);
        $row2->bindParam(':pass', $password);
        $row2->bindParam(':id_member', $id_member);
        $row2->bindParam(':role', $role);
        $row2->execute();

        // Commit transaksi jika semuanya berhasil
        $config->commit();

        // Redirect setelah sukses
        echo '<script>window.location="../../index.php?page=user&success=tambah-user"</script>';
    } catch (Exception $e) {
        // Jika ada error, rollback semua perubahan
        $config->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

    
    // if (!empty($_GET['jual'])) {
    //     $id = $_GET['id'];

    //     // get tabel barang id_barang
    //     $sql = 'SELECT * FROM barang WHERE id_barang = ?';
    //     $row = $config->prepare($sql);
    //     $row->execute(array($id));
    //     $hsl = $row->fetch();

    //     if ($hsl['stok'] > 0) {
    //         $kasir =  $_GET['id_kasir'];
    //         $jumlah = 1;
    //         $total = $hsl['harga_jual'];
    //         $tgl = date("j F Y, G:i");

    //         $data1[] = $id;
    //         $data1[] = $kasir;
    //         $data1[] = $jumlah;
    //         $data1[] = $total;
    //         $data1[] = $tgl;

    //         $sql1 = 'INSERT INTO penjualan (id_barang,id_member,jumlah,total,tanggal_input) VALUES (?,?,?,?,?)';
    //         $row1 = $config -> prepare($sql1);
    //         $row1 -> execute($data1);

    //         echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
    //     } else {
    //         echo '<script>alert("Stok Barang Anda Telah Habis !");
	// 				window.location="../../index.php?page=jual#keranjang"</script>';
    //     }
    // }


if (!empty($_GET['jual'])) {
    $id = $_GET['id'];

    // get tabel barang id_barang
    $sql = 'SELECT * FROM barang WHERE id_barang = ?';
    $row = $config->prepare($sql);
    $row->execute(array($id));
    $hsl = $row->fetch();

    if ($hsl['stok'] > 0) {
        $kasir = $_GET['id_kasir'];
        $merk = $_GET['merk'];
        $jumlah = 1;
        $total = $hsl['harga_jual'];
        $tgl = date("j F Y, G:i");

        // Menyimpan data ke dalam session
        $_SESSION['penjualan'][] = array(
            'id_barang' => $id,
            'merk' => $merk,
            'id_member' => $kasir,
            'jumlah' => $jumlah,
            'total' => $total,
            'tanggal_input' => $tgl
        );

        // Mengarahkan pengguna setelah penyimpanan data ke session
        echo '<script>window.location="../../index.php?page=jual&success=added-to-session"</script>';
    } else {
        echo '<script>alert("Stok Barang Anda Telah Habis !");
                window.location="../../index.php?page=jual#keranjang"</script>';
    }
}

if (!empty($_GET['pesan'])) {
    $id = $_GET['id'];

    // get tabel barang id_barang
    $sql = 'SELECT * FROM barang WHERE id_barang = ?';
    $row = $config->prepare($sql);
    $row->execute(array($id));
    $hsl = $row->fetch();

    if ($hsl['stok'] > 0) {
        $kasir = $_GET['id_kasir'];
        $merk = $_GET['merk'];
        $jumlah = 1;
        $total = $hsl['harga_jual'];
        $tgl = date("j F Y, G:i");

        // Menyimpan data ke dalam session
        $_SESSION['pemesanan'][] = array(
            'id_barang' => $id,
            'merk' => $merk,
            'id_member' => $kasir,
            'jumlah' => $jumlah,
            'total' => $total,
            'tanggal_input' => $tgl
        );

        // Mengarahkan pengguna setelah penyimpanan data ke session
        echo '<script>window.location="../../index.php?page=pesan&success=added-to-session"</script>';
    } else {
        echo '<script>alert("Stok Barang Anda Telah Habis !");
                window.location="../../index.php?page=pesan#keranjang"</script>';
    }
}


}
