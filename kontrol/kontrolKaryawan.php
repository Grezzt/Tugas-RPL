<?php

require '../request.php';

if($_GET['aksi'] == "tambah"){
    $username = $_POST['nama'];
    $nama_petugas = $_POST['alamat'];
    $level = $_POST['no_hp'];
    $anak = $_POST['jumlah_anak'];
    $statusPerkawinan = $_POST['status_perkawinan'];
    $password = $_POST['id_jabatan'];

    $tambah = $koneksi->prepare("CALL tambahKaryawan('$username', '$nama_petugas', '$level', '$anak', '$statusPerkawinan', '$password')");
    $tambah->execute();

    header("location:../petugas?page=karyawan");

}

if($_GET['aksi'] == "edit"){
    $id_petugas = $_POST['id'];
    $username = $_POST['username'];
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];
    $anak = $_POST['anak'];
    $statusPerkawinan = $_POST['statusPerkawinan'];
    $password = md5($_POST['password']);

    $edit = $koneksi->prepare("CALL editPetugas('$id_petugas', '$username', '$nama_petugas', '$level', '$anak', '$statusPerkawinan', '$password')");
    $edit->execute();

    header("location:../petugas?page=petugas");

}

if($_GET['aksi'] == "delete"){
    $id_petugas = $_POST['id_karyawan'];

    $hapus = $koneksi->prepare("CALL hapusKaryawan('$id_petugas')");
    $hapus->execute();

    header("location:../petugas?page=karyawan");

}



?>