<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jabatan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="../kontrol/kontrolJabatan.php?aksi=tambah" method="post">
            <input required type="text" name="nama_jabatan" class="form-control mb-2" placeholder="Masukan Jabatan">
            <input required type="text" name="gaji_pokok" class="form-control mb-2" placeholder="Masukan Gaji Pokok">


            <button class="btn btn-primary w-100">Tambah</button>
        </form>
    </div>
</div>
