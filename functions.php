<?php

require_once "connection.php";


# Masukan data ke dalam tabel
function insert($data, $table)
{
    global $conn;

    $query = "INSERT INTO $table (";

    $i = 0;
    foreach ($data as $column => $d) {
        $query .= "$column";
        if (++$i != count($data)) {
            $query .= ',';
        }
    }

    $query .= ") VALUES (";

    $i = 0;
    foreach ($data as $d) {
        $query .= "'" . mysqli_real_escape_string($conn, $d) . "'";
        if (++$i != count($data)) {
            $query .= ',';
        }
    }

    $query .= ")";

    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $response = (object) [
            "success" => true,
            "message" => "Success!"
        ];
        return $response;
    } else {
        $response = (object) [
            "success" => false,
            "message" => "Terjadi kesalahan."
        ];
        return $response;
    }
}

function update($data, $id, $table)
{
    global $conn;

    $query = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $column => $d) {
        $query .= "`$column` = '$d'";
        if (++$i != count($data)) {
            $query .= ',';
        }
    }

    $query .= " WHERE id = $id";

    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $response = (object) [
            "success" => true,
            "message" => "Berhasil diupdate!"
        ];
        return $response;
    } else {
        $response = (object) [
            "success" => false,
            "message" => "Terjadi kesalahan."
        ];
        return $response;
    }
}


# Membuat session untuk alert
function setAlert($name, $message = "", $type = "success")
{
    $_SESSION["$name"] = "<div class='alert alert-$type alert-dismissible fade show' role='alert'>$message
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
}

# Menampilkan session yang telah dibuat oleh function setAlert
function getAlert($name)
{
    if (isset($_SESSION["$name"])) {
        echo $_SESSION["$name"];
        unset($_SESSION["$name"]);
    }
}

# URL utama aplikasi
function base_url($url = '')
{
    $host = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $folder = explode('/', $path);
    $baseurl = "http://" . $host . '/' . $folder[1] . "/";

    if ($url != '') {
        $baseurl .= $url;
    }
    return $baseurl;
}

# functions untuk upload gambar
function upload_image($file, $directory, $prefix = '')
{
    // Jika ada file diupload
    if ($file['error'] !== 4) {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileDir = $file['tmp_name'];

        // Ekstensi file yang diperbolehkan
        $allowedType = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

        // Mendapatkan ekstensi file
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));

        // Cek apakah tipe file diperbolehkan
        if (!in_array($fileExtension, $allowedType)) {
            return (object) [
                "success" => false,
                "message" => "File bukan gambar"
            ];
        }

        // Cek ukuran gambar
        if ($fileSize > 1_000_000) {
            return (object) [
                "success" => false,
                "message" => "Ukuran file terlalu besar!"
            ];
        }

        // Generate nama baru
        $newFileName = uniqid() . "." . $fileExtension;

        # move file
        move_uploaded_file($fileDir, $directory . $newFileName);

        return (object) [
            "success" => true,
            "filename" => $newFileName,
            "message" => "File berhasil diupload!"
        ];;
    } else {
        return (object) [
            "success" => false,
            "message" => "Harap upload gambar!"
        ];
    }
}

function setInput($input)
{
    foreach ($input as $name => $value) {
        $_SESSION[$name] = $value;
    }
}

function getInput($name, $alternative = null)
{
    if (isset($_SESSION["$name"])) {
        $value = $_SESSION["$name"];
        unset($_SESSION["$name"]);
        return $value;
    } else {
        return $alternative;
    }
}
