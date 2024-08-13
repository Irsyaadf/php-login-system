<?php
// Memulai sesi untuk melacak data pengguna di seluruh halaman web
session_start();

// Memasukkan file UserModel.php yang berisi definisi kelas UserModel
require_once '../models/UserModel.php';

// Memeriksa apakah request yang diterima adalah POST (misalnya, dari form login)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil nilai email yang dikirim melalui form login
    $email = $_POST['email'];

    // Mengambil nilai password yang dikirim melalui form login
    $password = $_POST['password'];

    // Membuat objek dari kelas UserModel
    $userModel = new UserModel();

    // Memanggil metode login pada objek userModel untuk memeriksa apakah email ada dalam database
    $user = $userModel->login($email);

    // Memeriksa apakah pengguna dengan email yang dimasukkan ditemukan
    if ($user) {
        // Memverifikasi apakah password yang dimasukkan cocok dengan password yang tersimpan di database
        if (password_verify($password, $user['password'])) {
            // Jika cocok, menyimpan ID dan password pengguna dalam sesi
            $_SESSION['id'] = $user['id'];
            $_SESSION['password'] = $user['password'];

            // Mengarahkan pengguna ke halaman home.php
            header("Location: ../views/home.php");
            exit(); // Menghentikan eksekusi skrip setelah pengalihan
        } else {
            // Jika password salah, menyimpan pesan error di sesi
            $_SESSION['password_error'] = "Password yang Anda masukkan salah";

            // Mengarahkan kembali ke halaman login.php
            header("Location: ../views/login.php");
            exit(); // Menghentikan eksekusi skrip setelah pengalihan
        }
    } else {
        // Jika email tidak ditemukan, menyimpan pesan error di sesi
        $_SESSION['email_error'] = "Email tidak terdaftar";

        // Menutup koneksi ke database
        $userModel->closeConnection();
        
        // Mengarahkan kembali ke halaman login.php
        header("Location: ../views/login.php");
        exit(); // Menghentikan eksekusi skrip setelah pengalihan
    }
}
