<?php
include '../koneksi.php';
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penggajian</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="../kontrol/kontrolGaji.php?aksi=tambah" method="post">
            
            <select required name="id_karyawan" id="id_karyawan" class="form-control mb-2">
                <option value="">-- Pilih Nama Karyawan --</option>
                <?php
                $query_karyawan = mysqli_query($koneksi, "SELECT id_karyawan, nama FROM karyawan");
                while ($data = mysqli_fetch_assoc($query_karyawan)) {
                    echo '<option value="' . $data['id_karyawan'] . '">' . $data['nama'] . '</option>';
                }
                ?>
            </select>

            <input required type="date" name="tanggal_gaji" class="form-control mb-2" placeholder="Masukan Tanggal Gaji">

            <input required type="text" name="total_gaji" id="total_gaji" class="form-control mb-2" readonly placeholder="Total Gaji (Rp)">

            <button class="btn btn-primary w-100">Tambah</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#id_karyawan').on('change', function () {
        var id_karyawan = $(this).val();
        if (id_karyawan) {
            $.ajax({
                url: 'get_gaji.php',
                type: 'POST',
                data: { id_karyawan: id_karyawan },
                success: function (data) {
                    $('#total_gaji').val(data);
                }
            });
        } else {
            $('#total_gaji').val('');
        }
    });
</script>
