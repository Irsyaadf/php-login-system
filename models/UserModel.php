<?php
// Memasukkan file connection.php yang berisi fungsi untuk membuka koneksi ke database
require_once '../config/connection.php';

// Mendefinisikan kelas UserModel untuk mengelola operasi database terkait pengguna
class UserModel
{
    // Deklarasi properti untuk menyimpan objek koneksi database
    private $conn;

    // Konstruktor kelas yang dipanggil saat objek UserModel dibuat
    public function __construct()
    {
        // Membuka koneksi ke database dan menyimpannya dalam properti $conn
        $this->conn = openConnection();
    }

    // Metode untuk mendaftarkan pengguna baru ke dalam database
    public function register($name, $gender, $date_of_birth, $email, $phone_number, $password)
    {
        // Mengenkripsi password menggunakan algoritma BCRYPT
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Menyusun pernyataan SQL untuk menyisipkan data pengguna ke tabel `users`
        $sql = "INSERT INTO users (name, gender, date_of_birth, email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Mempersiapkan pernyataan SQL untuk menghindari SQL injection
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter ke dalam pernyataan SQL
        $stmt->bind_param("ssssss", $name, $gender, $date_of_birth, $email, $phone_number, $hashed_password);

        // Mengeksekusi pernyataan SQL dan memeriksa apakah berhasil
        if ($stmt->execute()) {
            // Jika berhasil, mengarahkan pengguna ke halaman count.php
            header("Location: ../views/count.php");
        } else {
            // Jika gagal, menampilkan pesan error
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    // Metode untuk melakukan login pengguna berdasarkan email
    public function login($email)
    {
        // Menyusun pernyataan SQL untuk mencari pengguna berdasarkan email
        $sql = "SELECT * FROM users WHERE email=?";
        
        // Mempersiapkan pernyataan SQL
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter email ke dalam pernyataan SQL
        $stmt->bind_param("s", $email);
        
        // Mengeksekusi pernyataan SQL
        $stmt->execute();
        
        // Mengambil hasil dari eksekusi
        $result = $stmt->get_result();

        // Memeriksa apakah hasilnya mengandung satu baris, yaitu pengguna ditemukan
        if ($result->num_rows == 1) {
            // Mengambil data pengguna dalam bentuk array asosiatif
            $user = $result->fetch_assoc();
            return $user;
        } else {
            // Jika pengguna tidak ditemukan, mengembalikan nilai null
            return null;
        }
    }

    // Metode untuk mendapatkan informasi pengguna berdasarkan ID pengguna
    public function getUserById($id)
    {
        // Menyusun pernyataan SQL untuk mencari pengguna berdasarkan ID
        $sql = "SELECT * FROM users WHERE id=?";
        
        // Mempersiapkan pernyataan SQL
        $stmt = $this->conn->prepare($sql);
        
        // Mengikat parameter ID ke dalam pernyataan SQL
        $stmt->bind_param("i", $id);
        
        // Mengeksekusi pernyataan SQL
        $stmt->execute();
        
        // Mengambil hasil dari eksekusi
        $result = $stmt->get_result();

        // Memeriksa apakah hasilnya mengandung satu baris, yaitu pengguna ditemukan
        if ($result->num_rows == 1) {
            // Mengambil data pengguna dalam bentuk array asosiatif
            $user = $result->fetch_assoc();
            return $user;
        } else {
            // Jika pengguna tidak ditemukan, mengembalikan nilai null
            return null;
        }
    }

    // Metode untuk menutup koneksi ke database
    public function closeConnection()
    {
        // Menutup koneksi database yang tersimpan dalam properti $conn
        $this->conn->close();
    }
}
