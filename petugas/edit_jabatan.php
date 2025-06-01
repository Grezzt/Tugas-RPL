<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Petugas</h1>
</div>

<?php

$id = $_GET['id'];
$petugas = $koneksi->prepare("CALL getJabatanId('$id')");
$petugas->execute();

$data = $petugas->fetch();

?>

<div class="card">
<div class="card-body">
    <form action="../kontrol/kontrolJabatan.php?aksi=edit" method="post">
    <table class="table">
            <input type="text" name="nama_jabatan" class="form-control mb-2" placeholder="Masukan Nomer Jabatan" value="<?= $data['nama_jabatan'] ?>">
            <input type="text" name="gaji_pokok" class="form-control mb-2" placeholder="Masukan Gaji Pokok" value="<?= $data['gaji_pokok'] ?>" >
            <input type="text" name="tunjangan" class="form-control mb-2" placeholder="Masukan Tunjangan" value="<?= $data['tunjangan'] ?>" >
            
    </table>
    <input type="hidden" name="id_jabatan" value="<?= $data['id_jabatan'] ?>">
    <button class="btn btn-primary w-100">Tambah</button>
    </form>
</div>
</div>
