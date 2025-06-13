<?php
$info = "";
$pesan = ""; // Untuk pesan clock in/out

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_karyawan'])) {
  $id_karyawan = intval($_POST['id_karyawan']);
  $tanggal = date('Y-m-d');
  $jam = date('H:i:s');
  // Cek karyawan
  $q = mysqli_query($koneksi, "SELECT k.*, j.nama_jabatan, j.gaji_pokok FROM karyawan k JOIN jabatan j ON k.id_jabatan=j.id_jabatan WHERE k.id_karyawan=$id_karyawan");
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
    $total_gaji = $karyawan['gaji_pokok'] * $jumlah_hari;

    // gaji perbulan berdasarkan jumlah tunjangan dan gaji pokok
    
    if ($karyawan['status_perkawinan'] == 'nikah') {
      $tunjangan_perkawinan = ($total_gaji * 0.2); // 20% dari gaji pokok
    } else {
      $tunjangan_perkawinan = 0;
    }

    if ($karyawan['jumlah_anak'] >= 1) {
      $tunjangan_anak = ($total_gaji * 0.075 * $karyawan['jumlah_anak']); // 20% per anak
    } else {
      $tunjangan_anak = 0;
    }

    $jumlahTunjangan = $tunjangan_anak + $tunjangan_perkawinan;
    $jumlahTotalGaji = $tunjangan_anak + $tunjangan_perkawinan + $total_gaji;

    $q_riwayat = mysqli_query($koneksi, "SELECT tanggal, jam_masuk, jam_keluar FROM absensi WHERE id_karyawan=$id_karyawan ORDER BY tanggal DESC LIMIT 10");

    $info .= "<div class='mt-3'>";
    $info .= "<h5>Profil Karyawan</h5>";
    $info .= "<table class='table table-sm'><tr><td>ID</td><td>{$karyawan['id_karyawan']}</td></tr>";
    $info .= "<tr><td>Nama</td><td>{$karyawan['nama']}</td></tr>";
    $info .= "<tr><td>Jumlah Anak</td><td>{$karyawan['jumlah_anak']}</td></tr>";
    $info .= "<tr><td>Status Perkawinan</td><td>{$karyawan['status_perkawinan']}</td></tr>";
    $info .= "<tr><td>Jabatan</td><td>{$karyawan['nama_jabatan']}</td></tr>";
    $info .= "<tr><td>Gaji Pokok per hari</td><td>Rp " . number_format($karyawan['gaji_pokok'], 2, ',', '.') . "</td></tr>";
    $info .= "<tr><td>Tunjangan Anak Bulan ini</td><td>Rp ". number_format($tunjangan_anak, 2, ',', '.') . "</td></tr>";
    $info .= "<tr><td>Tunjangan Perkawinan Bulan ini</td><td>Rp " . number_format($tunjangan_perkawinan, 2, ',', '.') . "</td></tr>";
    $info .= "<tr><td>Total Tunjangan</td><td>Rp " . number_format($jumlahTunjangan, 2, ',', '.') . "</td></tr>";
    $info .= "<tr><td>Gaji Bulan Ini</td><td>Rp " . number_format($jumlahTotalGaji, 2, ',', '.') . "</td></tr></table>";
    $info .= "<tr><td><h6><b>Riwayat Absensi bulan ini</td></tr>: ". number_format($jumlah_hari, 0, ',', '.') . " hari </b></h6></td></tr>";

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


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Slip Gaji </h1>
</div>
<tr>
    <td width="200">Nama</td>
    <td width="1">:</td>
    <td><?= $_SESSION['USER']['nama'] ?></td>
</tr>
<div class="card">
<div class="card-body">
    <table class="table">
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Jumlah Anak</td>
            <td>Status Perkawinan</td>
            <td>Jabatan</td>
            <td>Gaji Pokok</td>
            <td>Tunjangan Anak</td>
            <td>Tunjangan Perkawinan</td>
            <td>Total Tunjangan</td>
            <td>Total Gaji Bulan Ini</td>
        </tr>

        <?php
        
            $absen = $koneksi->prepare("CALL getKaryawan()");
            $absen->execute();

            foreach ($absen->fetchAll() as $no => $data):

        ?>

        <tr>
            <td><?= $no +1?></td>
            <td><?= $data['nama'] ?>
            <td><?= $data['jumlah_anak'] ?>
            <td><?= $data['status_perkawinan'] ?>
            <td><?= $data['nama_jabatan'] ?>
      
        </tr>

        <?php
            endforeach
        ?>
    </table>
</div>
</div>


