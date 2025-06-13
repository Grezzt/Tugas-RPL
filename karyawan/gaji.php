<?php

// Ambil ID karyawan dari session
$id_karyawan = $_SESSION['USER']['id_karyawan'] ?? null;
$nama_karyawan = $_SESSION['USER']['nama'] ?? '';

// Jika tidak ada id_karyawan di session, hentikan
if (!$id_karyawan) {
    die("Anda belum login atau session telah habis.");
}

// Ambil data lengkap karyawan dengan prepared statement untuk keamanan
$stmt = $koneksi->prepare("
    SELECT k.*, j.nama_jabatan, j.gaji_pokok 
    FROM karyawan k 
    JOIN jabatan j ON k.id_jabatan = j.id_jabatan 
    WHERE k.id_karyawan = :id_karyawan
");
$stmt->execute(['id_karyawan' => $id_karyawan]);
$data = $stmt->fetch();

if (!$data) {
    die("Data karyawan tidak ditemukan.");
}

// Hitung gaji dan tunjangan bulan ini
$bulan_ini = date('Y-m');
$stmt2 = $koneksi->prepare("
    SELECT COUNT(*) AS jumlah 
    FROM absensi 
    WHERE id_karyawan = :id_karyawan 
      AND DATE_FORMAT(tanggal, '%Y-%m') = :bulan_ini
");
$stmt2->execute([
    'id_karyawan' => $id_karyawan,
    'bulan_ini' => $bulan_ini
]);
$jumlah_hari = $stmt2->fetch()['jumlah'] ?? 0;

$gaji_pokok = $data['gaji_pokok'];
$total_gaji = $gaji_pokok * $jumlah_hari;

// Hitung tunjangan
$tunjangan_anak = ($data['jumlah_anak'] > 0) ? $total_gaji * 0.075 * $data['jumlah_anak'] : 0;
$tunjangan_perkawinan = (strtolower($data['status_perkawinan']) === 'nikah') ? $total_gaji * 0.2 : 0;
$total_tunjangan = $tunjangan_anak + $tunjangan_perkawinan;
$total_gaji_bulanan = $total_gaji + $total_tunjangan;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Slip Gaji Karyawan</title>
  <link href="./template/SB Admin 2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="./template/SB Admin 2/css/sb-admin-2.min.css" rel="stylesheet" />
  <style>
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Slip Gaji - <?= htmlspecialchars($nama_karyawan) ?></h4>
    </div>
    <div class="card-body">
      <table class="table table-borderless mb-4">
        <tr>
          <td width="200">Nama</td>
          <td width="10">:</td>
          <td><?= htmlspecialchars($data['nama']) ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?= htmlspecialchars($data['nama_jabatan']) ?></td>
        </tr>
        <tr>
          <td>Jumlah Anak</td>
          <td>:</td>
          <td><?= (int)$data['jumlah_anak'] ?></td>
        </tr>
        <tr>
          <td>Status Perkawinan</td>
          <td>:</td>
          <td><?= ucfirst(htmlspecialchars($data['status_perkawinan'])) ?></td>
        </tr>
      </table>

      <h5 class="mb-3">Rincian Gaji Bulan Ini (<?= date('F Y') ?>)</h5>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>Hari Masuk</th>
            <th>Gaji Pokok per Hari</th>
            <th>Total Gaji</th>
            <th>Tunjangan Anak</th>
            <th>Tunjangan Perkawinan</th>
            <th>Total Tunjangan</th>
            <th>Total Gaji Bulan Ini</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?= $jumlah_hari ?> hari</td>
            <td>Rp <?= number_format($gaji_pokok, 0, ',', '.') ?></td>
            <td>Rp <?= number_format($total_gaji, 0, ',', '.') ?></td>
            <td>Rp <?= number_format($tunjangan_anak, 0, ',', '.') ?></td>
            <td>Rp <?= number_format($tunjangan_perkawinan, 0, ',', '.') ?></td>
            <td>Rp <?= number_format($total_tunjangan, 0, ',', '.') ?></td>
            <td><strong>Rp <?= number_format($total_gaji_bulanan, 0, ',', '.') ?></strong></td>
          </tr>
        </tbody>
      </table>

      <a href="absensi.php" class="btn btn-secondary mt-3">Download</a>
    </div>
  </div>
</div>

<script src="./template/SB Admin 2/vendor/jquery/jquery.min.js"></script>
<script src="./template/SB Admin 2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./template/SB Admin 2/js/sb-admin-2.min.js"></script>
</body>
</html>
