<?php
include '../koneksi.php';
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="../kontrol/kontrolKaryawan.php?aksi=tambah" method="post">
            <input required type="text" name="nama" class="form-control mb-2" placeholder="Masukan Nama">
            <input required type="text" name="alamat" class="form-control mb-2" placeholder="Masukan Alamat">
            <input required type="text" name="no_hp" class="form-control mb-2" placeholder="Masukan No HP">

            <select required name="id_jabatan" class="form-control mb-2">
                <option value="">-- Pilih Jabatan --</option>
                <?php
                $query_jabatan = mysqli_query($koneksi, "SELECT id_jabatan, nama_jabatan FROM jabatan");
                if ($query_jabatan && mysqli_num_rows($query_jabatan) > 0) {
                    while ($data_jabatan = mysqli_fetch_assoc($query_jabatan)) {
                ?>
                        <option value="<?php echo htmlspecialchars($data_jabatan['id_jabatan']); ?>">
                            <?php echo htmlspecialchars($data_jabatan['nama_jabatan']); ?>
                        </option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="">Tidak ada data jabatan</option>
                <?php
                }
                ?>
            </select>

            <button class="btn btn-primary w-100">Tambah</button>
        </form>
    </div>
</div>