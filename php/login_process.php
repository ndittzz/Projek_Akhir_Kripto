<?php
session_start(); // Mulai sesi

// Koneksi ke database
$query = new mysqli('localhost', 'root', '', 'projek_akhir_kripto');
if ($query->connect_error) {
    die("Connection failed: " . $query->connect_error);
}

// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Hash password menggunakan MD5 untuk dicocokkan dengan hash di database
$password_hashed = md5($password);

// Menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($query, "SELECT * FROM admin WHERE username='$username' AND password='$password_hashed'");
if (!$data) {
    die("Query error: " . mysqli_error($query));
}

// Mengecek apakah data ditemukan
$cek = mysqli_num_rows($data);
if ($cek > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("Location: ../views/dashboard.php?pesan=login_berhasil"); // Tambahkan pesan login berhasil
} else {
    header("Location: ../login.php?pesan=gagal"); // Redirect ke halaman login dengan pesan error
}
?>
