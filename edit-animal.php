<?php

session_start();
require_once "functions.php";

$id = $_GET['id'];
$animal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_fauna WHERE id = '$id'"));

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>Edit Animal</title>

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
            height: 50vh;
            width: 100%;
            background: url("img/default-banner.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            z-index: -1;
            margin-top: -100px;
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

        .alert {
            border-radius: 0;
            background: none;
            border: 3px solid;
            color: #fff;
        }

        .alert-success {
            background: linear-gradient(to right, rgba(36, 150, 38, 0.1), rgba(36, 150, 38, 0.3));
            border-color: #249626;
        }

        .alert-danger {
            background: linear-gradient(to right, rgba(209, 45, 33, 0.1), rgba(209, 45, 33, 0.3));
            border-color: #DC3545;
        }

        .form-group label {
            font-size: 0.8em;
            letter-spacing: 1px;
            color: #8c8c8c;
        }

        .form-group .form-control {
            background: none;
            color: #b8bcbf;
            border: none;
            border-radius: 0;
            border-bottom: 1px solid #808080;
            box-shadow: none;
            padding: 10px 1px;
        }

        .form-group .form-control:focus {
            border-color: #fff;
        }

        textarea.form-control {
            resize: vertical;
        }
    </style>
</head>

<body>
    <?php require_once "components/navbar-simple.php" ?>

    <div class="animal-banner"></div>

    <div class="container">
        <?php getAlert('animal') ?>
        <form action="update-animal.php" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?= $animal['id'] ?>" name="id">
            <input type="hidden" value="<?= $animal['foto'] ?>" name="oldFoto">
            <div class="row">
                <div class="col-lg-4">
                    <label for="foto">
                        <img src="img/animals/<?= $animal['foto'] ?>" id="animal-preview" class="w-100" style="height: 250px; object-fit: cover; object-position: center; border-radius: 5%; cursor:pointer">
                    </label>
                    <div class="mb-4">
                        <label for="foto" class="form-label">Foto</label>
                        <input class="form-control" type="file" accept="image/png, image/gif, image/jpeg, image/svg" id="foto" name="foto" data-output-id="animal-preview" onchange="previewImage(event)" hidden>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group mb-4">
                        <label class="mb-2" for="nama">Nama Hewan</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Hewan" value="<?= getInput("nama", $animal['nama']) ?>">
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="namaIlmiah">Nama Ilmiah</label>
                        <input type="text" class="form-control" name="nama_ilmiah" id="namaIlmiah" onkeyup="generateSlug(this.value)" placeholder="Nama Ilmiah" autocomplete="off" value="<?= getInput("nama_ilmiah", $animal['nama_ilmiah']) ?>">
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="slug">SLug URL</label>
                        <div class="input-group mb-3">
                            <label for="slug" class="input-group-text text-white" style="background:none;" id="basic-addon3"><?= base_url("animal.php?name=") ?></label>
                            <input type="text" class="form-control" style="padding-left: 10px;" id="slug" name="slug" readonly value="<?= getInput("slug", $animal['slug']) ?>">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkGenerateSlug" checked>
                            <label class="form-check-label" for="checkGenerateSlug">
                                Generate slug otomatis
                            </label>
                        </div>
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="kelas">Kelas</label>
                        <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas (ex. Mammalia)" value="<?= getInput("kelas", $animal['kelas']) ?>">
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="ordo">Ordo</label>
                        <input type="text" class="form-control" name="ordo" id="ordo" placeholder="Ordo (ex. Carnivora)" value="<?= getInput("ordo", $animal['ordo']) ?>">
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="8" placeholder="Deskripsi"><?= getInput("deskripsi", $animal['deskripsi']) ?></textarea>
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="habitat">Habitat</label>
                        <textarea name="habitat" id="habitat" class="form-control" cols="30" rows="8" placeholder="Habitat"><?= getInput("habitat", $animal['habitat']) ?></textarea>
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="makanan">Makanan</label>
                        <textarea name="makanan" id="makanan" class="form-control" cols="30" rows="8" placeholder="Makanan"><?= getInput("makanan", $animal['makanan']) ?></textarea>
                    </div>
                    <div class="form-group my-4">
                        <label class="mb-2" for="populasi">Populasi</label>
                        <textarea name="populasi" id="populasi" class="form-control" cols="30" rows="8" placeholder="Populasi"><?= getInput("populasi", $animal['populasi']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-lg btn-custom btn-custom-primary my-4">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>

    <?php require_once "components/footer.php" ?>

    <script>
        let automateSlug = true
        const checkGenerateSlug = document.querySelector("input#checkGenerateSlug")

        const generateSlug = (str) => {
            if (automateSlug) {
                str = str.replace(/^\s+|\s+$/g, '')
                str = str.toLowerCase()

                // remove accents, swap ñ for n, etc
                var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                var to = "aaaaeeeeiiiioooouuuunc------";
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
                }

                str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')

                document.querySelector('input#slug').value = str
            }
        }

        checkGenerateSlug.addEventListener("change", function(e) {
            automateSlug = (e.target.checked) ? true : false
            document.querySelector("input#slug").readOnly = automateSlug
            generateSlug(document.querySelector("input#namaIlmiah").value)
        })


        const previewImage = function(event) {
            outputId = event.target.getAttribute("data-output-id")
            var output = document.getElementById(outputId)
            output.src = URL.createObjectURL(event.target.files[0])
        };
    </script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>