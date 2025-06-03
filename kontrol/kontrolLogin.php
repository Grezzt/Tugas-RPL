<?php
require '../request.php';

if($_GET['aksi'] == "loginPetugas"){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $hasil = $koneksi->prepare("CALL getLoginPetugas(:username, :password)");
    $hasil->bindParam(':username', $username);
    $hasil->bindParam(':password', $password);
    $hasil->execute();

    $petugas = $hasil->fetch();

    if($petugas){     
        $_SESSION['USER']['id'] = $petugas['id'];
        $_SESSION['USER']['tipe'] = 'admin';
        $_SESSION['USER']['role'] = $petugas['admin'];

        header("location:../petugas?page=absen");
        exit;  
    } else {
        echo "<script>alert('Username / Password Salah'); window.location= '../login.php' </script>";
        exit;
    }

} elseif($_GET['aksi'] == "logout"){
    session_destroy();
    header("location:../login.php");
    exit;
}
?>
