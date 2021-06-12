<?php

session_start();
require_once "functions.php";

$upload = upload_image($_FILES['foto'], 'img/animals/');

if ($upload->success == false) {
    setAlert("animal", $upload->message, "danger");
    setInput($_POST);
    header("Location: animal-data.php");
    exit;
};

$foto = $upload->filename;

$query = insert([
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
], 'tbl_fauna');

setAlert("animal", $query->message, ($query->success == true) ? "success" : "danger");
header("Location: animal-data.php");
exit;
