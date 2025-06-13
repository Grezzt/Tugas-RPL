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
            <input required type="number" name="jumlah_anak" class="form-control mb-2" placeholder="Masukan Jumlah Anak">

            <select required name="status_perkawinan" class="form-control mb-2">
                <option value="">-- Pilih Status Perkawinan --</option>
                <?php
                $query_status = mysqli_query($koneksi, "SELECT DISTINCT status_perkawinan FROM karyawan");
                if ($query_status && mysqli_num_rows($query_status) > 0) {
                    while ($data_status = mysqli_fetch_assoc($query_status)) {
                ?>
                        <option value="<?php echo htmlspecialchars($data_status['status_perkawinan']); ?>">
                            <?php echo htmlspecialchars($data_status['status_perkawinan']); ?>
                        </option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="">Tidak ada data status perkawinan</option>
                <?php
                }
                ?>
            </select>

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