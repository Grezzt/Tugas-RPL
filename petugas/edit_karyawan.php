<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Karyawan</h1>
</div>

<?php

$id = $_GET['id'];
$petugas = $koneksi->prepare("CALL getKaryawanId('$id')");
$petugas->execute();

$data = $petugas->fetch();

?>

<div class="card">
<div class="card-body">
    <form action="../kontrol/kontrolKaryawan.php?aksi=edit" method="post">
    <table class="table">
            <input type="text" name="nama" class="form-control mb-2" placeholder="Masukan Nomer Meja" value="<?= $data['nama'] ?>">
            <input type="text" name="alamat" class="form-control mb-2" placeholder="Masukan Alamat" value="<?= $data['alamat'] ?>" >
            <input type="text" name="no_hp" class="form-control mb-2" placeholder="Masukan No HP" value="<?= $data['no_hp'] ?>" >
            <select name="id_jabatan" class="form-control mb-2">
                <?php
                    $kel = mysqli_query($koneksi, "SELECT*FROM jabatan");
                    while ($kelas = mysqli_fetch_array($kel)) {
                ?>

                <option <?php if($data['id_jabatan'] == $kelas['id_jabatan']) echo'selected'; ?> value="<?= $kelas['id_jabatan'] ?>"><?= $kelas['nama_jabatan'] ?></option>

                <?php
                }
                ?>
            </select>
            
    </table>
    <input type="hidden" name="id_jabatan" value="<?= $data['id_jabatan'] ?>">
    <button class="btn btn-primary w-100">Tambah</button>
    </form>
</div>
</div>
