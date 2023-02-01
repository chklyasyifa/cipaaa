<?php

// ---------------------------------------------------------------------------
// KODE PHP DIBAWAH MERUPAKAN FUNGSI UNTUK MENGHUBUNGKAN WEB DENGAN DATABASE
// ---------------------------------------------------------------------------


// Koneksi ke database mysql
$host = "localhost"; // Lokal IP / Lokal Host komputer
$user = "root"; // User database
$password = ""; // Password Database
$db = "crud"; // Nama Database

$connect = mysqli_connect($host, $user, $password, $db);

if(!$connect){
    die("Koneksi Gagal / Error: ". mysqli_connect_error());
}
