<?php

require '../request.php';

if($_GET['aksi'] == "tambah"){
    $username = $_POST['id_karyawan'];
    $nama_petugas = $_POST['tanggal_gaji'];
    $level = $_POST['total_gaji'];

    $tambah = $koneksi->prepare("CALL tambahGaji('$username', '$nama_petugas', '$level')");
    $tambah->execute();

    header("location:../petugas?page=penggajian");

}

if($_GET['aksi'] == "edit"){
    $id_petugas = $_POST['id'];
    $username = $_POST['username'];
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];
    $password = md5($_POST['password']);

    $edit = $koneksi->prepare("CALL editPetugas('$id_petugas', '$username', '$nama_petugas', '$level', '$password')");
    $edit->execute();

    header("location:../petugas?page=petugas");

}

if($_GET['aksi'] == "delete"){
    $id_petugas = $_POST['id_gaji'];

    $hapus = $koneksi->prepare("CALL hapusGaji('$id_petugas')");
    $hapus->execute();

    header("location:../petugas?page=penggajian");

}



?>