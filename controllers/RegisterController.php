<?php

// Memulai sesi untuk melacak data pengguna di seluruh halaman web
session_start();

// Memasukkan file UserModel.php yang berisi definisi kelas UserModel
require_once '../models/UserModel.php';

// Memeriksa apakah request yang diterima adalah POST (misalnya, dari form registrasi)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai yang dikirim melalui form registrasi
    $name = $_POST['name']; // Nama pengguna
    $gender = $_POST['gender']; // Jenis kelamin pengguna
    $date_of_birth = $_POST['date_of_birth']; // Tanggal lahir pengguna
    $email = $_POST['email']; // Email pengguna
    $phone_number = $_POST['phone_number']; // Nomor telepon pengguna
    $password = $_POST['password']; // Password yang dimasukkan pengguna
    $confirm_password = $_POST['confirm_password']; // Konfirmasi password yang dimasukkan pengguna

    // Memeriksa apakah password dan konfirmasi password cocok
    if ($password != $confirm_password) {
        // Jika tidak cocok, menampilkan pesan error dan menghentikan eksekusi skrip
        echo "Konfirmasi password tidak sesuai";
        exit;
    }

    // Membuat objek dari kelas UserModel
    $userModel = new UserModel();

    // Memanggil metode register pada objek userModel untuk menyimpan data pengguna ke database
    $userModel->register($name, $gender, $date_of_birth, $email, $phone_number, $password);

    // Setelah registrasi berhasil, login pengguna secara otomatis dan menyimpan ID pengguna dalam sesi
    $_SESSION['id'] = $userModel->login($email)['id'];

    // Menutup koneksi ke database
    $userModel->closeConnection();
    
    // Mengarahkan pengguna ke halaman home.php setelah registrasi dan login berhasil
    header("Location: ../views/home.php");
    exit(); // Menghentikan eksekusi skrip setelah pengalihan
}
