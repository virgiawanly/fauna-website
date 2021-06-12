<?php

session_start();
require_once "functions.php";

$keyword = isset($_GET['search']) ? $_GET['search'] : '';
if (isset($_POST['search'])) $keyword = $_POST['search'];

// Pengaturan Pagination
$dataPerPage = 5;
$activePage = isset($_GET['page']) ? $_GET['page'] : 1;
$dataStart = ($activePage - 1) * $dataPerPage;

// Hitung total data
$sql =  "SELECT COUNT(*) FROM tbl_fauna WHERE nama LIKE '%$keyword%' OR nama_ilmiah LIKE '%$keyword%' OR kelas LIKE '%$keyword%' OR ordo LIKE '%$keyword%'";
$dataCount = (int) mysqli_fetch_row(mysqli_query($conn, $sql))[0];

// Hitung total halaman
$totalPage = ceil($dataCount / $dataPerPage);

// Jika halaman tidak ditemukan
if ($totalPage > 0) {
    if ($activePage > $totalPage) {
        header("location: ?search=$keyword&page=1");
    }
}

// Jika page kurang dari 1
if ($activePage < 1) {
    header("location: ?search=$keyword&page=1");
}

// Query Data
if ($dataCount != 0) {
    $animals = mysqli_fetch_all(mysqli_query($conn, ("SELECT * FROM tbl_fauna  WHERE nama LIKE '%$keyword%' OR nama_ilmiah LIKE '%$keyword%' OR kelas LIKE '%$keyword%' OR ordo LIKE '%$keyword%' LIMIT $dataStart, $dataPerPage")), MYSQLI_ASSOC);
} else {
    $animals = [];
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

    <title>Animals</title>

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

        .search-input {
            background: none;
            color: #b8bcbf;
            border: none;
            border-radius: 0;
            border-bottom: 1px solid #808080;
            box-shadow: none;
            padding: 10px 1px;
        }

        .search-input:focus {
            border-color: #fff;
            background: none;
            box-shadow: none;
            color: #fff;
        }

        .search-button {
            border-top: none;
            border-left: none;
            border-right: none;
            border-width: 1px;
        }

        .search-button:focus {
            box-shadow: none;
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


    <div class="container">
        <?php getAlert("animal") ?>
        <div class="row justify-content-between align-items-center mt-3 mb-5">
            <div class="col-sm-4">
                <h1 class="display-6">Data Hewan</h1>
            </div>

            <div class="form-group col-sm-4 text-center">
                <form action="" method="post" class="d-flex">
                    <input type="text" placeholder="Cari Hewan" name="search" class="form-control search-input">
                    <button class="btn btn-custom btn-custom-primary search-button">Search</button>
                </form>
            </div>

            <div class="col-sm-4">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-custom btn-custom-primary float-end" data-bs-toggle="modal" data-bs-target="#insertModal">
                    Tambah Data
                </button>
            </div>
        </div>

        <table class="table table-borderless">
            <thead>
                <tr class="text-center align-middle text-white">
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama Ilmiah</th>
                    <th scope="col">URL</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Ordo</th>
                    <th scope="col" style="width: 15%;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($animals)) : ?>
                    <?php $i = $dataStart + 1 ?>
                    <?php foreach ($animals as $animal) : ?>
                        <tr class="text-secondary animal-data">
                            <th scope="row"><?= $i++ ?></th>
                            <td><a href="<?= base_url('animal.php?name=') . $animal['slug'] ?>" class="text-white text-decoration-none"><?= $animal['nama'] ?></a></td>
                            <td><img class="animal-image" src="<?= base_url('img/animals/') . $animal['foto'] ?>" style="width:100px; height:100px; border-radius:10%; object-fit: cover; object-position: center; filter: grayscale(1);" loading="lazy" alt=""></td>
                            <td><?= $animal['nama_ilmiah'] ?></td>
                            <td><a class="text-decoration-none text-white fs-semibold" href="<?= base_url('animal.php?name=') . $animal['slug'] ?>"><?= base_url('animal.php?name=') . $animal['slug'] ?></a></td>
                            <td><?= $animal['kelas'] ?></td>
                            <td><?= $animal['ordo'] ?></td>
                            <td class="text-center align-middle">
                                <a class="btn btn-custom btn-custom-primary" href="edit-animal.php?id=<?= $animal['id'] ?>">Edit</a>
                                <button type="button" class="btn btn-custom btn-custom-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-animal-id="<?= $animal['id'] ?>" data-bs-animal-name="<?= $animal['nama'] ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center text-white py-4">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center py-4">
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                <a class="btn btn-custom btn-custom-primary" href="?search=<?= $keyword ?>&page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Delete animal modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="delete-animal.php" method="post">
                    <input type="hidden" id="animalId" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center fs-4">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Insert Modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="store-animal.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Tambah Data Hewan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="img/no-photo.svg" id="animal-preview" class="w-100 img-thumbnail" style="max-height: 350px; object-fit: cover; object-position: center;" alt="">
                                <div class="my-4">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="foto" name="foto" data-output-id="animal-preview" onchange="previewImage(event)">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group my-4">
                                    <label class="mb-2" for="nama">Nama Hewan</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Hewan" value="<?= getInput("nama") ?>" required>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="namaIlmiah">Nama Ilmiah</label>
                                    <input type="text" class="form-control" name="nama_ilmiah" id="namaIlmiah" onkeyup="generateSlug(this.value)" placeholder="Nama Ilmiah" autocomplete="off" value="<?= getInput("nama_ilmiah") ?>" required>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="slug">SLug URL</label>
                                    <div class="input-group mb-3">
                                        <label for="slug" class="input-group-text" id="basic-addon3"><?= base_url('animal.php?name=') ?></label>
                                        <input type="text" class="form-control" id="slug" name="slug" readonly value="<?= getInput("slug") ?>" required>
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
                                    <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas (ex. Mammalia)" value="<?= getInput("kelas") ?>" required>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="ordo">Ordo</label>
                                    <input type="text" class="form-control" name="ordo" id="ordo" placeholder="Ordo (ex. Carnivora)" value="<?= getInput("ordo") ?>" required>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="8" placeholder="Deskripsi" required><?= getInput("deskripsi") ?></textarea>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="habitat">Habitat</label>
                                    <textarea name="habitat" id="habitat" class="form-control" cols="30" rows="8" placeholder="Habitat" required><?= getInput("habitat") ?></textarea>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="makanan">Makanan</label>
                                    <textarea name="makanan" id="makanan" class="form-control" cols="30" rows="8" placeholder="Makanan" required><?= getInput("makanan") ?></textarea>
                                </div>
                                <div class="form-group my-4">
                                    <label class="mb-2" for="populasi">Populasi</label>
                                    <textarea name="populasi" id="populasi" class="form-control" cols="30" rows="8" placeholder="Populasi" required><?= getInput("populasi") ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php require_once "components/footer.php" ?>

    <script>
        var deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var animalId = button.getAttribute('data-bs-animal-id')
            var animalName = button.getAttribute('data-bs-animal-name')
            var modalBody = deleteModal.querySelector('.modal-body')
            var animalIdInput = deleteModal.querySelector('input#animalId')
            animalIdInput.value = animalId
            modalBody.textContent = "Hapus " + animalName + "?"
        })

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
        }

        const animalImages = document.querySelectorAll(".animal-image")


        window.onscroll = function() {
            animalImages.forEach(function(image) {
                let rect = image.getBoundingClientRect()
                image.style.filter = "grayscale(" + ((rect.top - 250) / window.scrollY - 0.3) + ")"
            })
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>