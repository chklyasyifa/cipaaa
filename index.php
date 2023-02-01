<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian CRUD - Home</title>
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
        <h4 class="text-center mt-5">DAFTAR NAMA SISWA</h4>

        <?php

        // -----------------------------------------------------------------------
        // KODE PHP DIBAWAH MERUPAKAN FUNGSI UNTUK MELAKUKAN READ DAN DELETE
        // -----------------------------------------------------------------------


        // Mengimport file connect.php untuk mengakses ke database
        include "connect.php";

        // Memberikan ERROR
        if (isset($_GET["error"])) {
            echo "<script>alert('foto sudah tersedia');</script>";
        }

        if (isset($_GET['id_siswa'])) {
            $id = htmlspecialchars($_GET["id_siswa"]);

            // Mengambil semua data dari tabel siswa
            $all = "select * from siswa where id='$id'";
            $hasil = mysqli_query($connect, $all);
            $data = mysqli_fetch_assoc($hasil);

            // Mengambil foto dari folder 'foto' untuk dihapus
            $foto_dir = 'foto/';
            $foto_nama = $data["foto"];

            // Apakah kondisi diatas berhasil atau tidak
            if ($hasil) {
                // Kondisi mengapus Data dan Foto
                $sql = "delete from siswa where id='$id' ";
                $que = mysqli_query($connect, $sql);
                unlink($foto_dir . $foto_nama);
                header("Location:index.php");
            }
            // Jika kondisi gagal
            else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }
        }
        ?>

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

        <table class="my-3 table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Absen</th>
                    <th>Kelas</th>
                    <th colspan='2'>Aksi</th>
                </tr>
            </thead>
            <?php
            include "connect.php";

            $sql = "select * from siswa order by id desc";
            $hasil = mysqli_query($connect, $sql);

            // Looping data pada tabel
            $no = 0;
            while ($data = mysqli_fetch_array($hasil)) {
                $no++;
            ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $no ?>
                        </td>
                        <td style="width: 150px !important;">
                            <img src="foto/<?php echo $data["foto"]; ?>" alt="" srcset="" class="rounded img-fluid">
                        </td>
                        <td>
                            <?php echo $data["nama"] ?>
                        </td>
                        <td>
                            <?php echo $data["absen"] ?>
                        </td>
                        <td>
                            <?php echo $data["kelas"] ?>
                        </td>
                        <td class="w-25">
                            <a href="edit.php?id_siswa=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning">Edit</a>
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_siswa=<?php echo $data['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
        <a href="create.php" class="btn btn-primary">Buat Data</a>
    </div>

</body>
<!-- Framework Style Boostrap biar ga perlu styling manual -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>