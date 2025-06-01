<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Petugas</h1>
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
            <input type="text" name="no_meja" class="form-control mb-2" placeholder="Masukan Nomer Meja" value="<?= $data['no_meja'] ?>" readonly>
            <select name="status" class="form-control mb-2">
                <option <?= $data['status'] == "ready" ? "selected" : "" ; ?> value="ready">Ready</option>
                <option <?= $data['status'] == "cleaning" ? "selected" : "" ; ?> value="cleaning">Cleaning</option>
                <option <?= $data['status'] == "used" ? "selected" : "" ; ?> value="used">Used</option>
            </select>
    </table>
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <button class="btn btn-primary w-100">Tambah</button>
    </form>
</div>
</div>
