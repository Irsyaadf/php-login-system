<?php
// Menghancurkan semua data sesi, sehingga semua variabel sesi akan dihapus
session_destroy();

// Menghapus semua variabel sesi saat ini
session_unset();

// Mengarahkan pengguna kembali ke halaman login.php
header("Location: ../views/login.php");

// Menghentikan eksekusi skrip setelah pengalihan
exit;
