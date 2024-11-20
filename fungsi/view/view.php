<?php
/*
* PROSES TAMPIL
*/
class view
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function member()
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function member_edit($id){
        $sql = "select member.*, login.*
                from member 
                inner join login 
                on member.id_member = login.id_member
                where member.id_member= ?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function tampilkan_detail_pesanan($id){
        $sql ="SELECT detail_pesanan.id_pesanan, 
                barang.id_barang, 
                barang.nama_barang,
                barang.merk,
                detail_pesanan.jumlah,
                detail_pesanan.total,
                pesanan.id_member,
                pesanan.tanggal_input
            FROM detail_pesanan
            JOIN barang 
                ON detail_pesanan.id_barang = barang.id_barang
            JOIN pesanan
                ON detail_pesanan.id_pesanan = pesanan.id_pesanan
            WHERE detail_pesanan.id_pesanan = :id_pesanan
            ORDER BY detail_pesanan.id_pesanan";


        $row = $this-> db -> prepare($sql);
        $row->bindParam(':id_pesanan', $id, PDO::PARAM_STR); // Ubah ke PDO::PARAM_STR
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    

//     public function tampilkan_detail_pesanan($id){
//     $sql = "SELECT detail_pesanan.id_pesanan, 
//                 barang.id_barang, 
//                 barang.nama_barang,
//                 detail_pesanan.jumlah,
//                 detail_pesanan.total,
//                 pesanan.id_member,
//                 pesanan.tanggal_input
//             FROM detail_pesanan
//             JOIN barang 
//                 ON detail_pesanan.id_barang = barang.id_barang
//             JOIN pesanan
//                 ON detail_pesanan.id_pesanan = pesanan.id_pesanan
//             WHERE detail_pesanan.id_pesanan = :id_pesanan
//             ORDER BY detail_pesanan.id_pesanan";

//     $row = $this->db->prepare($sql);
//     $row->bindParam(':id_pesanan', $id, PDO::PARAM_STR);
//     $row->execute();
//     $hasil = $row->fetchAll();
//     return $hasil;
// }





    public function toko()
    {
        $sql = "select*from toko where id_toko='1'";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function kategori()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    // public function barang()
    // {
    //     $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
    //             from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
    //             ORDER BY id DESC";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> fetchAll();
    //     return $hasil;
    // }

    public function barang()
{
    $sql = "SELECT * FROM barang ORDER BY id DESC";
    $row = $this->db->prepare($sql);
    $row->execute();
    $hasil = $row->fetchAll();
    return $hasil;
}


    public function barang_stok()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                where stok <= 3 
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_edit($id)
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori
                where id_barang=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function barang_cari($cari)
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori
                where id_barang like '%$cari%' or nama_barang like '%$cari%' or merk like '%$cari%'";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_id()
    {
        $sql = 'SELECT * FROM barang ORDER BY id DESC';
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();

        $urut = substr($hasil['id_barang'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'BR00'.$tambah.'';
        } elseif (strlen($tambah) == 2) {
            $format = 'BR0'.$tambah.'';
        } else {
            $ex = explode('BR', $hasil['id_barang']);
            $no = (int) $ex[1] + 1;
            $format = 'BR'.$no.'';
        }
        return $format;
    }

    public function pesan_id()
    {
        $sql = 'SELECT * FROM pesanan ORDER BY id DESC';
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();

        $urut = substr($hasil['id_pesanan'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'PS00'.$tambah.'';
        } elseif (strlen($tambah) == 2) {
            $format = 'PS0'.$tambah.'';
        } else {
            $ex = explode('PS', $hasil['id_pesanan']);
            $no = (int) $ex[1] + 1;
            $format = 'PS'.$no.'';
        }
        return $format;
    }

    public function serah(){
       $sql = 'SELECT * FROM member ORDER BY id DESC';
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        
}

    public function kategori_edit($id)
    {
        $sql = "select*from kategori where id_kategori=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function kategori_row()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
        return $hasil;
    }

    public function barang_row()
    {
        $sql = "select*from barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
        return $hasil;
    }

    public function barang_stok_row()
    {
        $sql ="SELECT SUM(stok) as jml FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function barang_beli_row()
    {
        $sql ="SELECT SUM(harga_beli) as beli FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual_row()
    {
        $sql ="SELECT SUM(jumlah) as stok FROM nota";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual()
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.merk, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member 
                where nota.periode = ?
                ORDER BY id_nota DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array(date('m-Y')));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function periode_jual($periode)
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.merk, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.periode = ? 
                ORDER BY id_nota ASC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($periode));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function hari_jual($hari)
    {
        $ex = explode('-', $hari);
        $monthNum  = $ex[1];
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        if ($ex[2] > 9) {
            $tgl = $ex[2];
        } else {
            $tgl1 = explode('0', $ex[2]);
            $tgl = $tgl1[1];
        }
        $cek = $tgl.' '.$monthName.' '.$ex[0];
        $param = "%{$cek}%";
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.merk, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.tanggal_input LIKE ? 
                ORDER BY id_nota ASC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($param));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function penjualan(){
        $sql ="SELECT penjualan.* , barang.id_barang, barang.nama_barang, member.id_member,
                member.nm_member from penjualan 
                left join barang on barang.id_barang=penjualan.id_barang 
                left join member on member.id_member=penjualan.id_member
                ORDER BY id_penjualan";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function tampilkan_pesanan(){
        $sql ="SELECT pesanan.id_pesanan, pesanan.total, pesanan.nama_pemesan, pesanan.id_member, member.nm_member
                FROM pesanan
                JOIN member ON pesanan.id_member = member.id_member";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    // public function tampilkan_detail_pesanan(){
    //     $sql ="SELECT barang.id_barang, barang.nama_barang
    //             FROM barang
    //             JOIN detail_pesanan ON barang.id_barang = detail_pesanan.id_barang";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> fetchAll();
    //     return $hasil;
    // }

    public function jumlah()
    {
        $sql ="SELECT SUM(total) as bayar FROM penjualan";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jumlah_nota()
    {
        $sql ="SELECT SUM(total) as bayar FROM nota";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jml()
    {
        $sql ="SELECT SUM(harga_beli*stok) as byr FROM barang";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    // public function user()
    // {
    //     $sql = "select login.*, member.id_member, member.nm_member
    //             from login inner join member on login.id_member = member.id_member 
    //             ORDER BY id DESC";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> fetchAll();
    //     return $hasil;
    // }

    // public function user(){
    //     $sql = "SELECT login.*, member.id_member, member.nm_member
    //     FROM login
    //     INNER JOIN member ON login.id_member = member.id_member
    //     ORDER BY id_login DESC";
    //     $row = $this->db->prepare($sql);
    //     $row->execute();
    //     $hasil = $row->fetchAll();
    //     return $hasil;
    // }

//     public function user(){
//     $sql = "SELECT login.*, member.id_member, member.nm_member , member.NIK, member.telepon, member.email
//             FROM login 
//             INNER JOIN member ON login.id_member = member.id_member 
//             ORDER BY login.id_login DESC"; // Pastikan untuk menambahkan prefix 'login.' untuk id_login
//     $row = $this->db->prepare($sql);
//     $row->execute();
//     $hasil = $row->fetchAll();
//     return $hasil;
// }

    public function user(){
    $sql = "SELECT member.*, login.role, login.user, login.id_login
            FROM member 
            INNER JOIN login ON member.id_member = login.id_member 
            ORDER BY login.id_login DESC"; // Pastikan untuk menambahkan prefix 'login.' untuk id_login
    $row = $this->db->prepare($sql);
    $row->execute();
    $hasil = $row->fetchAll();
    return $hasil;
}


    
}
