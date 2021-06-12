<?php

session_start();
require_once "functions.php";

$animals = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM tbl_fauna LIMIT 3"), MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>National Geographic</title>

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

        .text-secondary {
            color: #b8bcbf !important;
        }

        .btn-custom {
            border-radius: 0;
            border: 2px solid;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            background: none;
        }

        .btn-custom:hover {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-custom-primary {
            border-color: #FFCC00;
        }

        .btn-custom-danger {
            border-color: #DC3545;
        }

        .animal-banner {
            min-height: 120vh;
            width: 100%;
            background: url("img/banner-image.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            z-index: -1;
            margin-bottom: -20vh;
            animation-name: moveBg;
            animation-duration: 2s;
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

        nav.scrolled {
            background-color: rgba(0, 0, 0, 0.5);
            transition: 0.3s;
        }

        nav.scrolled a.nav-link {
            color: #fff !important;
            transition: 0.3s;
        }
    </style>
</head>

<body>
    <?php require_once "components/navbar.php" ?>

    <div class="animal-banner"></div>


    <div class="container" style="margin-top: -90vh; min-height: 70vh;">
        <div class="row">
            <div class="col-md-8">
                <h1 class="display-1">National Geographic</h1>
                <p class="text-secondary mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste corrupti sequi ad quod quidem alias architecto blanditiis aliquam, nisi, delectus quam laboriosam! Quos id beatae unde expedita. Quisquam, vero fuga!</p>
                <a href="<?= base_url('animal-data.php') ?>" class="btn btn-custom btn-custom-primary btn-lg">Explore Sekarang</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="display-4">Temukan beragam Fauna dari seluruh dunia!</h2>
                <p class="text-secondary">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illo sed necessitatibus aut minima deserunt maxime inventore, quaerat nam modi!</p>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-4 mb-4 mb-sm-0">
                <img src="<?= base_url('img/penguins.jpg') ?>" alt="" style="width:100%; height:300px; object-fit: cover; border-radius: 10%;">
            </div>
            <div class="col-md-4 mb-4 mb-sm-0">
                <img src="<?= base_url('img/camel.jpg') ?>" alt="" style="width:100%; height:300px; object-fit: cover; border-radius: 10%;">
            </div>
            <div class="col-md-4 mb-4 mb-sm-0">
                <img src="<?= base_url('img/white-tiger.jpg') ?>" alt="" style="width:100%; height:300px; object-fit: cover; border-radius: 10%;">
            </div>
        </div>

        <div class="row my-5">
            <div class="col-md-8 mx-auto text-center mt-5">
                <h2 class="display-4">Baca informasi seputar satwa</h2>
                <p class="text-secondary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos ea voluptatem odit, accusantium veniam tempora?</p>
            </div>
        </div>

        <?php foreach ($animals as $animal) : ?>
            <div class="row justify-content-center align-items-center mb-4">
                <div class="col-md-4">
                    <img src="<?= base_url('img/animals/') . $animal['foto'] ?>" class="my-4 my-md-0" style="width:100%; height:500px; object-fit: cover;">
                </div>
                <div class="col-md-6">
                    <h3 class="display-5"><?= $animal['nama'] ?></h3>
                    <p class="text-secondary fst-italic"><?= $animal['nama_ilmiah'] ?></p>
                    <p class="text-secondary"><?= substr($animal['deskripsi'], 0, 750) ?> ...</p>
                    <a class="text-warning text-decoration-none" href="<?= base_url('animal.php?name=') . $animal['slug'] ?>">Baca Selengkapnya</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require_once "components/footer.php" ?>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>