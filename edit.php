<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian CRUD - Perbaruhi Data</title>
    <link rel="stylesheet" href="style/custom.css">
    <!-- Framework Style Boostrap biar ga perlu styling manual -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-uppercase text-light mx-5 fw-bold" href="index.php">Chikalbakal Syifa</a>
        </div>
    </nav>
    <div class="container">
        <?php

        // -----------------------------------------------------------------------------
        // KODE PHP DIBAWAH MERUPAKAN FUNGSI UNTUK MELAKUKAN EDIT ATAU PERUBAHAN DATA
        // -----------------------------------------------------------------------------


        // Mengimport file connect.php untuk terhubung ke database
        include "connect.php";

        // Fungsi untuk untuk mencegah inputan karakter yg tidak sesuai
        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Cek apakah ada nilai yg dikirim dengan method GET dengan nama id_siswa
        if (isset($_GET['id_siswa'])) {
            $id = input($_GET["id_siswa"]);

            $sql = "select * from siswa where id='$id'";
            $hasil = mysqli_query($connect, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }

        // Cek apakah ada kiriman form dari method POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = htmlspecialchars($_POST["id_siswa"]);
            $nama = input($_POST["nama"]);
            $absen = input($_POST["absen"]);
            $kelas = input($_POST["kelas"]);
            $foto = $_FILES["foto"]["name"];
            $oldFoto = input($_POST["oldFoto"]);

            // Merubah nama foto pada tabel database
            if ($foto != "") {
                $update_namafile = $_FILES["foto"]["name"];
            } else {
                $update_namafile = $oldFoto;
            }

            // Mengecek apakah nama foto tersedia atau tidak
            if ($_FILES["foto"]["name"] != '') {
                // Mengecek apakah foto sudah tersedia didalam folder 'foto'
                if (file_exists("foto/" . $_FILES["foto"]["name"])) {
                    $namafile = $_FILES["foto"]["name"];
                    header('Location:index.php?error');
                } 
                // Menjalankan perintah untuk merubah data
                else {
                    $query = "update siswa set 
                    foto='$update_namafile',
                    nama='$nama',
                    absen='$absen',
                    kelas='$kelas' 
                    where id=$id";
                    $query_run = mysqli_query($connect, $query);

                    if ($query_run) {
                        if ($_FILES["foto"]["name"] != '') {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], "foto/" . $_FILES["foto"]["name"]);
                            unlink("foto/" . $oldFoto);
                        }
                        header('Location:index.php');
                    } else {
                        header('Location:index.php');
                    }
                }
            } 
            // Menjalankan perintah untuk merubah data
            else {
                $query = "update siswa set 
                    foto='$update_namafile',
                    nama='$nama',
                    absen='$absen',
                    kelas='$kelas' 
                    where id=$id";
                $query_run = mysqli_query($connect, $query);

                if ($query_run) {
                    if ($_FILES["foto"]["name"] != '') {
                        move_uploaded_file($_FILES["foto"]["tmp_name"], "foto/" . $_FILES["foto"]["name"]);
                        unlink("foto/" . $oldFoto);
                    }
                    header('Location:index.php');
                } else {
                    header('Location:index.php');
                }
            }
        }
        ?>

        <h2 class="mt-5 text-center">Perbaruhi Data Siswa</h2>

        <?php 
            if(isset($_SESSION['status']) && $_SESSION != ''){
                ?>

                <div class="alert alert-warnig alert-dismissible fade show">
                    <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                </div>

                <?php
                unset($_SESSION['status']);
            }
            ?>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <label for="foto">Masukan foto:</label><br>
                <img src="foto/<?php echo $data["foto"]; ?>" style="width: 100px !important;" alt="">
                <input type="file" name="foto" class="mt-1">
                <input type="hidden" name="oldFoto" value="<?php echo $data["foto"]; ?>">
            </div>
            <div class="form-group mt-2">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="<?php echo $data["nama"]; ?>" required />
            </div>
            <div class="form-group mt-3">
                <label>Absen :</label>
                <input type="text" name="absen" class="form-control" placeholder="Masukan Absen" value="<?php echo $data["absen"]; ?>" required />
            </div>
            <div class="form-group mt-3">
                <label>Kelas:</label>
                <input type="text" name="kelas" class="form-control" placeholder="Masukan Kelas" value="<?php echo $data["kelas"]; ?>" required />
            </div>
            <input type="hidden" name="id_siswa" value="<?php echo $data['id']; ?>" />
            <button type="submit" name="submit" class="btn btn-primary mt-3">Perbaruhi</button>
        </form>
        <a href="index.php" class="btn btn-danger mt-2">Kembali</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>