<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
            <div class="form-group">
              <input type="text" class="form-control form-control-user" id="id_karyawan" name="id_karyawan" placeholder="ID Karyawan" required>
            </div>
            <div class="form-group d-flex justify-content-between">
              <button type="submit" name="clock_in" class="btn btn-success btn-user w-50 mr-2">Clock In</button>
              <button type="submit" name="clock_out" class="btn btn-danger btn-user w-50 ml-2">Clock Out</button>
            </div>
          </form>
        </div>
      </div>
      <div class="right">
        <div class="right-container">
          <?php
          $info = "";
          $pesan = ""; // Untuk pesan clock in/out

          if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_karyawan'])) {
            $id_karyawan = intval($_POST['id_karyawan']);
            $tanggal = date('Y-m-d');
            $jam = date('H:i:s');
            // Cek karyawan
            $q = mysqli_query($koneksi, "SELECT k.*, j.nama_jabatan, j.gaji_pokok, j.tunjangan FROM karyawan k JOIN jabatan j ON k.id_jabatan=j.id_jabatan WHERE k.id_karyawan=$id_karyawan");
            $karyawan = mysqli_fetch_assoc($q);
            if (!$karyawan) {
              $pesan = "<div class='alert alert-danger'>ID Karyawan tidak ditemukan.</div>";
            } else {
              if (isset($_POST['clock_in'])) {
                $cek = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_karyawan=$id_karyawan AND tanggal='$tanggal'");
                if (mysqli_num_rows($cek) > 0) {
                  $pesan = "<div class='alert alert-warning'>Anda sudah melakukan Clock In hari ini.</div>";
                } else {
                  mysqli_query($koneksi, "INSERT INTO absensi (id_karyawan, tanggal, jam_masuk) VALUES ($id_karyawan, '$tanggal', '$jam')");
                  $pesan = "<div class='alert alert-success'>Clock In berhasil pada $jam</div>";
                }
              } elseif (isset($_POST['clock_out'])) {
                $cek = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_karyawan=$id_karyawan AND tanggal='$tanggal' AND jam_keluar IS NULL");
                if (mysqli_num_rows($cek) == 0) {
                  $pesan = "<div class='alert alert-warning'>Anda belum Clock In atau sudah Clock Out hari ini.</div>";
                } else {
                  mysqli_query($koneksi, "UPDATE absensi SET jam_keluar='$jam' WHERE id_karyawan=$id_karyawan AND tanggal='$tanggal' AND jam_keluar IS NULL");
                  $pesan = "<div class='alert alert-success'>Clock Out berhasil pada $jam</div>";
                }
              }

              // Info karyawan dan riwayat absensi
              $bulan_ini = date('Y-m');
              $q_jumlah = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM absensi WHERE id_karyawan=$id_karyawan AND DATE_FORMAT(tanggal, '%Y-%m')='$bulan_ini'");
              $jumlah_hari = mysqli_fetch_assoc($q_jumlah)['jumlah'];
              $total_gaji = ($karyawan['gaji_pokok'] + $karyawan['tunjangan']) * $jumlah_hari;

              $q_riwayat = mysqli_query($koneksi, "SELECT tanggal, jam_masuk, jam_keluar FROM absensi WHERE id_karyawan=$id_karyawan ORDER BY tanggal DESC LIMIT 10");

              $info .= "<div class='mt-3'>";
              $info .= "<h5>Profil Karyawan</h5>";
              $info .= "<table class='table table-sm'><tr><td>ID</td><td>{$karyawan['id_karyawan']}</td></tr>";
              $info .= "<tr><td>Nama</td><td>{$karyawan['nama']}</td></tr>";
              $info .= "<tr><td>Jabatan</td><td>{$karyawan['nama_jabatan']}</td></tr>";
              $info .= "<tr><td>Gaji Pokok</td><td>Rp " . number_format($karyawan['gaji_pokok'] + $karyawan['tunjangan'], 2, ',', '.') . "</td></tr>";
              $info .= "<tr><td>Gaji Bulan Ini</td><td>Rp " . number_format($total_gaji, 2, ',', '.') . "</td></tr></table>";

              $info .= "<h6>Riwayat Absensi (10 Terakhir)</h6>";
              $info .= "<table class='table table-bordered table-sm'><thead><tr><th>Tanggal</th><th>Masuk</th><th>Keluar</th></tr></thead><tbody>";
              while ($a = mysqli_fetch_assoc($q_riwayat)) {
                $keluar = $a['jam_keluar'] ? $a['jam_keluar'] : "<span class='text-danger'>Belum Clock Out</span>";
                $info .= "<tr><td>{$a['tanggal']}</td><td>{$a['jam_masuk']}</td><td>{$keluar}</td></tr>";
              }
              $info .= "</tbody></table>";
              $info .= "</div>";
            }
          }
          // Tampilkan info karyawan dulu, lalu pesan clock in/out di bawahnya
          echo $info;
          echo $pesan;
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="./template/SB Admin 2/vendor/jquery/jquery.min.js"></script>
  <script src="./template/SB Admin 2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="./template/SB Admin 2/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="./template/SB Admin 2/js/sb-admin-2.min.js"></script>
</body>

</html>