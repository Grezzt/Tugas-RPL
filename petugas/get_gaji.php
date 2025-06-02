<?php
include '../koneksi.php';

if (isset($_POST['id_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];

    // Ambil data jabatan dari karyawan yang dipilih
    $query = "
        SELECT j.gaji_pokok, j.tunjangan 
        FROM karyawan k
        JOIN jabatan j ON k.id_jabatan = j.id_jabatan
        WHERE k.id_karyawan = '$id_karyawan'
    ";

    $result = mysqli_query($koneksi, $query);
    if ($data = mysqli_fetch_assoc($result)) {
        $total = $data['gaji_pokok'] + $data['tunjangan'];
        echo $total;
    } else {
        echo "0";
    }
}
?>
