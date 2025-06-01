<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Absensi</h1>
</div>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Tanggal</td>
            <td>Jam Masuk</td>
            <td>Jam Keluar</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getAbsen()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):

        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['nama'] ?></td>
            <td><?= $data['tanggal'] ?></td>
            <td><?= $data['jam_masuk'] ?></td>
            <td><?= $data['jam_keluar'] ?></td>
        </tr>

        <?php
            endforeach
        ?>
    </table>
</div>
</div>