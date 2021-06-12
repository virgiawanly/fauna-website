<?php

require_once "functions.php";

if (isset($_GET['name'])) {
    $slug = $_GET['name'];
    $animal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_fauna WHERE slug = '$slug'"));
} else {
    $animal = null;
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title><?= $animal != null ? $animal['nama'] : "Tidak ditemukan" ?></title>

    <style>
        body {
            background-color: #000;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #fff !important;
        }

        .animal-banner {
            height: 100vh;
            width: 100%;
            background: url("img/nature-bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            z-index: -1;
            margin-bottom: -50vh;
        }

        .animal-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1));
        }

        .text-secondary {
            color: #b8bcbf !important;
        }
    </style>
</head>

<body>
    <?php require_once "components/navbar.php" ?>

    <div class="animal-banner" style="margin-top: -100px;"></div>

    <div class="container" style="margin-bottom: 100px;">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4">
                <img src="<?= base_url('img/foto-saya.jpg') ?>" alt="" style="width:90%; height:300px; object-fit: cover; object-position: top; border-radius: 10%;">
            </div>
            <div class="col-lg-6">
                <p class="text-secondary mt-4 mt-lg-0">Assalamualaikum! Nama saya</p>
                <h1 class="my-4 display-3">
                    Virgiawan Listiyandi
                </h1>
                <p class="text-secondary">Saya berumur 17 tahun, saat ini saya bersekolah di SMKN 1 Cianjur jurusan Rekayasa Perangkat Lunak. Saya memiliki minat dalam bidang programming dan desain. Tujuan saya membuat website ini adalah untuk memenuhi tugas ujian praktek mata pelajaran Pemrograman Web dan Perangkat Bergerak.</p>
            </div>
        </div>
    </div>

    <?php require_once "components/footer.php" ?>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>