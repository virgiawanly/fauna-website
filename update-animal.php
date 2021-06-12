<?php

session_start();
require_once "functions.php";

$id = $_POST['id'];
// Jika tidak ada gambar diupload
if ($_FILES['foto']['error'] == 4) {
    // Gunakan gambar lama
    $foto = $_POST['oldFoto'];
} else {
    // Jika tidak, upload gambar baru
    $upload = upload_image($_FILES['foto'], 'img/animals/');

    if ($upload->success == false) {
        setAlert("animal", $upload->message, "danger");
        setInput($_POST);
        header("Location: edit-animal.php?id=$id");
        exit;
    };

    // Dapatkan nama file baru
    $foto = $upload->filename;

    // Hapus gambar lama
    if ($_POST['oldFoto'] != '') {
        if (file_exists("img/animals/" . $_POST['oldFoto'])) {
            unlink("img/animals/" . $_POST['oldFoto']);
        }
    }
}

$query = update([
    "slug" => $_POST['slug'],
    "nama" => $_POST['nama'],
    "nama_ilmiah" => $_POST['nama_ilmiah'],
    "kelas" => $_POST['kelas'],
    "ordo" => $_POST['ordo'],
    "deskripsi" => $_POST['deskripsi'],
    "habitat" => $_POST['habitat'],
    "makanan" => $_POST['makanan'],
    "populasi" => $_POST['populasi'],
    "foto" => $foto
], $_POST['id'], 'tbl_fauna');

setAlert("animal", $query->message, ($query->success == true) ? "success" : "danger");
header("Location: animal-data.php");
exit;
