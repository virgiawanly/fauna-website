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
            background: url("<?= ($animal != null) ? base_url('img/animals/') . $animal['foto'] : "img/default-banner.jpg" ?>");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            z-index: -1;
            margin-bottom: -75vh;
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
    <?php require_once "components/navbar-simple.php" ?>

    <div class="animal-banner" style="margin-top: -100px;"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-10 mx-auto">
                <?php if ($animal != null) : ?>
                    <h1 class="my-5 display-1">
                        <?= $animal['nama'] ?>
                    </h1>
                    <div class="row">
                        <div class="col-sm-4 fst-italic text-white"><?= $animal['nama_ilmiah'] ?></div>
                        <div class="col-sm-4 fst-italic text-secondary"><span class="text-white">Kelas : </span><?= $animal['kelas'] ?></div>
                        <div class="col-sm-4 fst-italic text-secondary"><span class="text-white">Ordo : </span><?= $animal['ordo'] ?></div>
                    </div>
                    <div class="my-5 text-secondary"><?= $animal['deskripsi'] ?></div>
                    <div class="my-5">
                        <h2 class="display-6">Habitat</h2>
                        <div class="text-secondary"><?= $animal['habitat'] ?></div>
                    </div>
                    <div class="my-5">
                        <h2 class="display-6">Makanan</h2>
                        <div class="text-secondary"><?= $animal['makanan'] ?></div>
                    </div>
                    <div class="my-5">
                        <h2 class="display-6">Populasi</h2>
                        <div class="text-secondary"><?= $animal['populasi'] ?></div>
                    </div>
                <?php else : ?>
                    <h1 class="my-4 display-1">
                        Hewan tidak ditemukan
                    </h1>
                    <p class="text-secondary">Aduh! Hewan yang kamu cari gaada.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require_once "components/footer.php" ?>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>