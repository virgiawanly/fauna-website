<?php

session_start();
require_once "functions.php";

$id = $_POST['id'];

mysqli_query($conn, "DELETE FROM tbl_fauna WHERE `id` = '$id'");

if (mysqli_affected_rows($conn) > 0) {
    setAlert("animal", "Berhasil dihapus!");
} else {
    setAlert("animal", "Terjadi kesalahan.", "danger");
}

header("Location: animal-data.php");
exit;
