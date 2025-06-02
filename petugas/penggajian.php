<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Penggajian</h1>
</div>
<a href="?page=tambah_gaji" class="btn btn-success mb-2">Tambah Penggajian +</a>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Tanggal Gaji</td>
            <td>Total Gaji</td>
            <td>Aksi</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getPenggajian()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):
            
        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['tanggal_gaji'] ?></td>
            <td><?= $data['total_gaji'] ?></td>
            <td>
                <form action="../kontrol/kontrolGaji.php?aksi=delete" method="post" class="d-inline">
                    <input type="hidden" name="id_gaji" value="<?= $data['id_gaji'] ?>">
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