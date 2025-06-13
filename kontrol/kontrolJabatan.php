<?php

require '../request.php';

if($_GET['aksi'] == "tambah"){
    $username = $_POST['nama_jabatan'];
    $nama_petugas = $_POST['gaji_pokok'];
    $tambah = $koneksi->prepare("CALL tambahJabatan('$username', '$nama_petugas')");
    $tambah->execute();

    header("location:../petugas?page=jabatan");

}

if($_GET['aksi'] == "edit"){
    $id_petugas = $_POST['id_jabatan'];
    $username = $_POST['nama_jabatan'];
    $nama_petugas = $_POST['gaji_pokok'];

    $edit = $koneksi->prepare("CALL editJabatan('$id_petugas', '$username', '$nama_petugas')");
    $edit->execute();

    header("location:../petugas?page=jabatan");

}

if($_GET['aksi'] == "delete"){
    $id_petugas = $_POST['id_jabatan'];

    $hapus = $koneksi->prepare("CALL hapusJabatan('$id_petugas')");
    $hapus->execute();

    header("location:../petugas?page=jabatan");

}



?>