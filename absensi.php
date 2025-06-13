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
            <a href="login_kar.php" class="btn btn-warning btn-user w-50 ml-2">Cek Slip Gaji</a>
          </form>
          
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