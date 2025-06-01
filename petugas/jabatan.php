<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Jabatan</h1>
</div>
<a href="?page=tambah_jabatan" class="btn btn-success mb-2">Tambah Jabatan +</a>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Jabatan</td>
            <td>Gaji Pokok</td>
            <td>Tunjangan</td>
            <td>Aksi</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getJabatan()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):

        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['nama_jabatan'] ?></td>
            <td><?= $data['gaji_pokok'] ?></td>
            <td><?= $data['tunjangan'] ?></td>
            <td>
                <a href="?page=edit_jabatan&id=<?= $data['id_jabatan'] ?>" class="btn btn-primary">EDIT</a>
                <form action="../kontrol/kontrolJabatan.php?aksi=delete" method="post" class="d-inline">
                    <input type="hidden" name="id_jabatan" value="<?= $data['id_jabatan'] ?>">
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