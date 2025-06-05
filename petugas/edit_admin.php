<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Admin</h1>
</div>

<?php

$id = $_GET['id'];
$petugas = $koneksi->prepare("CALL getAdminId('$id')");
$petugas->execute();

$data = $petugas->fetch();

?>

<div class="card">
<div class="card-body">
    <form action="../kontrol/kontrolAdmin.php?aksi=edit" method="post">
    <table class="table">
            <input type="text" name="username" class="form-control mb-2" placeholder="Masukan Nomer Jabatan" value="<?= $data['username'] ?>">
            <input type="text" name="password" class="form-control mb-2" placeholder="Masukan Gaji Pokok" value="<?= $data['password'] ?>" >
            <select name="role" class="form-control mb-2">
                <option <?= $data['role'] == "admin" ? "selected" : "" ; ?> value="admin">Admin</option>
                <option <?= $data['role'] == "karyawan" ? "selected" : "" ; ?> value="karyawan">Karyawan</option>
            </select>
            
    </table>
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <button class="btn btn-primary w-100">Edit</button>
    </form>
</div>
</div>
