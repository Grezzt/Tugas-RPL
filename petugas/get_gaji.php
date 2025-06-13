<?php
include '../koneksi.php';

if (isset($_POST['id_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];

    // Ambil data karyawan dan jabatan
    $query = "
        SELECT k.jumlah_anak, k.status_perkawinan, j.gaji_pokok
        FROM karyawan k
        JOIN jabatan j ON k.id_jabatan = j.id_jabatan
        WHERE k.id_karyawan = ?
    ";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $id_karyawan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($data = $result->fetch_assoc()) {
        // Hitung jumlah hari masuk bulan ini #mulai berubah disini
        $bulan_ini = date('Y-m');
        $query2 = "
            SELECT COUNT(*) AS jumlah 
            FROM absensi 
            WHERE id_karyawan = ? 
              AND DATE_FORMAT(tanggal, '%Y-%m') = ?
        ";
        $stmt2 = $koneksi->prepare($query2);
        $stmt2->bind_param("ss", $id_karyawan, $bulan_ini);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $jumlah_hari = $result2->fetch_assoc()['jumlah'] ?? 0;

        $gaji_pokok = $data['gaji_pokok'];
        $total_gaji = $gaji_pokok * $jumlah_hari;

        // Hitung tunjangan 
        $tunjangan_anak = ($data['jumlah_anak'] > 0) ? $total_gaji * 0.075 * $data['jumlah_anak'] : 0;
        $tunjangan_perkawinan = (strtolower($data['status_perkawinan']) === 'nikah') ? $total_gaji * 0.2 : 0;
        $total_tunjangan = $tunjangan_anak + $tunjangan_perkawinan;
        $total_gaji_bulanan = $total_gaji + $total_tunjangan;

        echo $total_gaji_bulanan;
    } else {
        echo "0";
    }
}
?>