

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="./template/SB Admin 2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./template/SB Admin 2/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9" style="margin-top: 15%;">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6" style="margin-left: 25%;">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                  </div>
                  <form class="user" action="./kontrol/kontrolLogin.php?aksi=loginKaryawan" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="nama" placeholder="Enter Nama">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Enter Password">
                    </div>
                    <button class="btn btn-primary btn-user btn-block">Login</button>
                    <a href="absensi.php" class="btn btn-danger btn-user btn-block">Absen</a>
                    
                  </form>
                  <hr>
                  
                </div>
              </div>
            </div>
          </div>
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
