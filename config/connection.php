<?php
function openConnection()
{
    // Mendeklarasikan variabel untuk nama host, nama pengguna, kata sandi, dan nama database
    $hostname = "localhost"; // Nama host database, biasanya 'localhost'
    $username = "root"; // Nama pengguna untuk mengakses database, defaultnya 'root'
    $password = ""; // Kata sandi untuk pengguna, kosong dalam kasus ini
    $database = "php_login_system"; // Nama database yang ingin diakses

    // Membuat koneksi ke database menggunakan objek mysqli
    $conn = new mysqli($hostname, $username, $password, $database);

    // Memeriksa apakah terjadi kesalahan koneksi
    if ($conn->connect_error) {
        // Menghentikan eksekusi script dan menampilkan pesan error jika koneksi gagal
        die("Connection failed: " . $conn->connect_error);
    }

    // Mengembalikan objek koneksi jika koneksi berhasil
    return $conn;
}

