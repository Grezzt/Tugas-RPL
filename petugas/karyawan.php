<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Karyawan</h1>
</div>
<a href="?page=tambah_karyawan" class="btn btn-success mb-2">Tambah Karyawan +</a>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Alamat</td>
            <td>No HP</td>
            <td>Jumlah Anak</td>
            <td>Status Perkawinan</td>
            <td>Jabatan</td>
            <td>Aksi</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getKaryawan()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):

        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['alamat'] ?></td>
            <td><?= $data['no_hp'] ?></td>
            <td><?= $data['jumlah_anak'] ?></td>
            <td><?= $data['status_perkawinan'] ?></td>
            <td><?= $data['nama_jabatan'] ?></td>
            <td>
                <a href="?page=edit_karyawan&id=<?= $data['id_karyawan'] ?>" class="btn btn-primary">EDIT</a>
                <form action="../kontrol/kontrolKaryawan.php?aksi=delete" method="post" class="d-inline">
                    <input type="hidden" name="id_karyawan" value="<?= $data['id_karyawan'] ?>">
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