<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
</div>
<a href="?page=tambah_admin" class="btn btn-success mb-2">Tambah Admin +</a>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Username</td>
            <td>Password</td>
            <td>Role</td>
            <td>Aksi</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getAdmin()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):

        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['username'] ?></td>
            <td><?= $data['password'] ?></td>
            <td><?= $data['role'] ?></td>
            <td>
                <a href="?page=edit_admin&id=<?= $data['id'] ?>" class="btn btn-primary">EDIT</a>
                <form action="../kontrol/kontrolAdmin.php?aksi=delete" method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">DELETE</button>
                </form>
                
            </td>
        </tr>

        <?php
            endforeach
        ?>
    </table>
</div>
</div>