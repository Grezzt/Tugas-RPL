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
                <?php
                    $pet = mysqli_query($koneksi, "SELECT*FROM jabatan");
                    while ($data = mysqli_fetch_array($pet)) {
                ?>

                <option value="<?php echo $data['id_jabatan']; ?>"><?php echo $data['nama_jabatan']; ?></option>


                <?php
                }
                ?>
            </select>

            <button class="btn btn-primary w-100">Tambah</button>
        </form>
    </div>
</div>
