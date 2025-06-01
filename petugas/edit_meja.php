<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Petugas</h1>
</div>

<?php

$id = $_GET['id'];
$petugas = $koneksi->prepare("CALL getMejaId('$id')");
$petugas->execute();

$data = $petugas->fetch();

$is_admin = $_SESSION['USER']['level'] == 'admin'; 

?>

<div class="card">
<div class="card-body">
    <form action="../kontrol/kontrolMeja.php?aksi=edit" method="post">
    <table class="table">
        <?php if ($is_admin): ?>
            <input type="text" name="no_meja" class="form-control mb-2" placeholder="Masukan Nomer Meja" value="<?= $data['no_meja'] ?>">
        <?php else: ?>
            <input type="text" name="no_meja" class="form-control mb-2" placeholder="Masukan Nomer Meja" value="<?= $data['no_meja'] ?>" readonly>
        <?php endif; ?>

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
