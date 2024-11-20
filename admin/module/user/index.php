        <h4>Data User</h4>
        <br />
        <?php if(isset($_GET['success-stok'])){?>
        <div class="alert alert-success">
            <p>Tambah Stok Berhasil !</p>
        </div>
        <?php }?>
        <?php if(isset($_GET['success'])){?>
        <div class="alert alert-success">
            <p>Tambah Data Berhasil !</p>
        </div>
        <?php }?>
        <?php if(isset($_GET['remove'])){?>
        <div class="alert alert-danger">
            <p>Hapus Data Berhasil !</p>
        </div>
        <?php }?>

        
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-md mr-2" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus"></i> Insert Data</button>
        
        <!-- <a href="index.php?page=user" class="btn btn-success btn-md">
            <i class="fa fa-refresh"></i> Refresh Data</a> -->
        <div class="clearfix"></div>
        <br />
        <!-- view barang -->
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="example1">
                    <thead>
                        <tr style="background:#DFF0D8;color:#333;">
                            <th>No.</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>No. HP</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $hasil = $lihat -> user();
                        $no = 1;
                        foreach($hasil as $isi){
                            ?>
                        <tr>
                            <td><?php echo $no  ?> <input type="hidden" value="<?php echo $isi['id_login'];?>"> </td>
                            <td><?php echo $isi['user'] ?></td>
                            <td><?php echo $isi['nm_member'] ?></td>
                            <td><?php echo $isi['NIK']?></td>
                            <td><?php echo $isi['telepon']?></td>
                            <td><?php echo $isi['email']?></td>
                            <td><?php echo $isi['role']?></td>
                            <td>
                                <a href="index.php?page=detail&id_member=<?php echo $isi['id_member'];?>"><button
                                        class="btn btn-primary btn-xs">Details</button></a>
                                <a href="fungsi/hapus/hapus.php?user=hapus&id=<?php echo $isi['id_member'];?>"><button
                                        class="btn btn-warning btn-xs">Hapus</button></a>
                            </td>
                        </tr>
                    
                        <?php 
                            $no++; } ?>
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- end view barang -->
        <!-- tambah barang MODALS-->
        <!-- Modal -->

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style=" border-radius:0px;">
                    <div class="modal-header" style="background:#285c64;color:#fff;">
                        <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="fungsi/tambah/tambah.php?user=tambah" method="POST">
                        <div class="modal-body">
                            <table class="table table-striped bordered">
                                <tr>
                                    <td>Username</td>
                                    <td><input type="text" placeholder="Username" required class="form-control"
                                            name="username"></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><input type="password" placeholder="Password" required class="form-control"
                                            name="password"></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td><input type="text" placeholder="Nama" required class="form-control"
                                            name="nm_member"></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><input type="text" placeholder="alamat" required class="form-control"
                                            name="alamat"></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td><input type="number" placeholder="NIK" required class="form-control"
                                            name="NIK"></td>
                                </tr>
                                <tr>
                                    <td>E-Mail</td>
                                    <td><input type="email" placeholder="example@gmail.com" required class="form-control"
                                            name="email"></td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td><input type="number" placeholder="Nomor Hp" required class="form-control"
                                            name="telepon"></td>
                                </tr>

                                <tr>
                                    <td>Role</td>
                                    <td>
                                        <select name="role" class="form-control" required>
                                            <option value="#">Pilih Role</option>
                                            <option value="admin">admin</option>
                                            <option value="pegawai">pegawai</option>
                                        </select>
                                    </td>
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
    $('#restok').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id = button.data('id');
        var nama = button.data('nama');
        var merk = button.data('merk');
        var stok = button.data('stok');

        // Mengisi data ke dalam modal
        var modal = $(this);
        modal.find('input[name="id"]').val(id);
        modal.find('input[name="nama"]').val(nama);
        modal.find('input[name="merk"]').val(merk);
        modal.find('input[name="stok"]').val(stok);
    });
</script>
