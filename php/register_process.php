<?php
session_start();
// Menghubungkan dengan database
$query = new mysqli('localhost', 'root', '', 'projek_akhir_kripto');

// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validasi password (minimal 8 karakter, huruf besar, huruf kecil, angka, simbol)
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
    header("location:../views/register.php?pesan=gagal_validasi_password");
    exit();
}

// Validasi apakah password dan konfirmasi password sama
if ($password !== $confirm_password) {
    header("location:../views/register.php?pesan=password_tidak_sama");
    exit();
}

// Hash password menggunakan MD5
$password_hashed = md5($password);

// Mengecek apakah username sudah ada
$cek_user = mysqli_query($query, "SELECT * FROM admin WHERE username='$username'");
if (mysqli_num_rows($cek_user) > 0) {
    // Username sudah terdaftar
    header("location:../views/register.php?pesan=username_terdaftar");
} else {
    // Menyimpan data ke database
    $result = mysqli_query($query, "INSERT INTO admin (username, password) VALUES ('$username', '$password_hashed')");
    
    if ($result) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        // Redirect dengan pesan sukses
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href = '../login.php';
        </script>";
    } else {
        header("location:../views/register.php?pesan=gagal_daftar");
    }
}
?>
