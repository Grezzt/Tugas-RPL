<?php

require '../request.php';

if($_GET['aksi'] == "tambah"){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['role'];

    $tambah = $koneksi->prepare("CALL tambahAdmin('$username', '$password', '$level')");
    $tambah->execute();

    header("location:../petugas?page=admin");

}

if($_GET['aksi'] == "edit"){
    $id_petugas = $_POST['id'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['role'];

    $edit = $koneksi->prepare("CALL editAdmin('$id_petugas', '$username', '$password', '$level')");
    $edit->execute();

    header("location:../petugas?page=admin");

}

if($_GET['aksi'] == "delete"){
    $id_petugas = $_POST['id'];

    $hapus = $koneksi->prepare("CALL hapusAdmin('$id_petugas')");
    $hapus->execute();

    header("location:../petugas?page=admin");

}



?>