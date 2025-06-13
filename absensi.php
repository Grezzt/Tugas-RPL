<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$pesan = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_karyawan'])) {
    $id_karyawan = intval($_POST['id_karyawan']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    // Cek apakah id_karyawan ada di tabel karyawan
    $stmt = $koneksi->prepare("SELECT k.*, j.nama_jabatan, j.gaji_pokok 
                               FROM karyawan k 
                               JOIN jabatan j ON k.id_jabatan = j.id_jabatan 
                               WHERE k.id_karyawan = ?");
    $stmt->bind_param("i", $id_karyawan);
    $stmt->execute();
    $result = $stmt->get_result();
    $karyawan = $result->fetch_assoc();
    $stmt->close();

    if (!$karyawan) {
        $pesan = "<div class='alert alert-danger'>ID Karyawan tidak ditemukan.</div>";
    } else {
        if (isset($_POST['clock_in'])) {
            // Cek apakah sudah clock in hari ini
            $stmt = $koneksi->prepare("SELECT * FROM absensi WHERE id_karyawan = ? AND tanggal = ?");
            $stmt->bind_param("is", $id_karyawan, $tanggal);
            $stmt->execute();
            $result = $stmt->get_result();
            $jumlah = $result->num_rows;
            $stmt->close();

            if ($jumlah > 0) {
                $pesan = "<div class='alert alert-warning'>Anda sudah melakukan Clock In hari ini.</div>";
            } else {
                // Insert absensi dengan jam_masuk
                $stmt = $koneksi->prepare("INSERT INTO absensi (id_karyawan, tanggal, jam_masuk) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id_karyawan, $tanggal, $jam);
                if ($stmt->execute()) {
                    $pesan = "<div class='alert alert-success'>Clock In berhasil pada $jam</div>";
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal melakukan Clock In.</div>";
                }
                $stmt->close();
            }
        } elseif (isset($_POST['clock_out'])) {
            // Cek apakah sudah clock in tapi belum clock out hari ini
            $stmt = $koneksi->prepare("SELECT * FROM absensi WHERE id_karyawan = ? AND tanggal = ? AND jam_keluar IS NULL");
            $stmt->bind_param("is", $id_karyawan, $tanggal);
            $stmt->execute();
            $result = $stmt->get_result();
            $jumlah = $result->num_rows;
            $stmt->close();

            if ($jumlah == 0) {
                $pesan = "<div class='alert alert-warning'>Anda belum Clock In atau sudah Clock Out hari ini.</div>";
            } else {
                // Update jam_keluar
                $stmt = $koneksi->prepare("UPDATE absensi SET jam_keluar = ? WHERE id_karyawan = ? AND tanggal = ? AND jam_keluar IS NULL");
                $stmt->bind_param("sis", $jam, $id_karyawan, $tanggal);
                if ($stmt->execute()) {
                    $pesan = "<div class='alert alert-success'>Clock Out berhasil pada $jam</div>";
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal melakukan Clock Out.</div>";
                }
                $stmt->close();
            }
        }
    }
}
?>

<!-- HTML form kamu tetap sama -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Absensi Karyawan</title>
 <!-- Custom fonts for this template-->
  <link href="./template/SB Admin 2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="./template/SB Admin 2/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/absensi.css">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="card-container">
      <div class="left">
        <div class="left-container">
          <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Form Absensi Karyawan</h1>
          </div>
          <form class="user" method="post" action="">
            <?php if (!empty($pesan)) echo "<div class='text-center mx-auto mb-3' style='max-width: 400px;'>$pesan</div>"; ?>
            <div class="form-group">
              <input type="text" class="form-control form-control-user" id="id_karyawan" name="id_karyawan" placeholder="ID Karyawan" required />
            </div>
            <div class="form-group d-flex justify-content-between">
              <button type="submit" name="clock_in" class="btn btn-success btn-user w-50 mr-2">Clock In</button>
              <button type="submit" name="clock_out" class="btn btn-danger btn-user w-50 ml-2">Clock Out</button>
            </div>
            <a href="login_kar.php" class="btn btn-warning btn-user w-50 ml-2">Cek Slip Gaji</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="./template/SB Admin 2/vendor/jquery/jquery.min.js"></script>
  <script src="./template/SB Admin 2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./template/SB Admin 2/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="./template/SB Admin 2/js/sb-admin-2.min.js"></script>
</body>
</html>
