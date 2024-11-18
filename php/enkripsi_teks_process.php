<?php
// Mengimpor koneksi database
include 'db.php';

// Fungsi untuk enkripsi ROT13
function rot13Encrypt($text) {
    return str_rot13($text);  // Fungsi PHP untuk ROT13
}

// Fungsi untuk enkripsi AES
function aesEncrypt($text, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
    $ciphertext = openssl_encrypt($text, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $ciphertext); // Gabungkan IV dan ciphertext, lalu encode
}

// Mengambil input dari form
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_telepon = $_POST['no_telepon'];
$email = $_POST['email'];
$gaji = $_POST['gaji'];
$jabatan = $_POST['jabatan'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$aesKey = $_POST['aes_key'];

// Cek apakah NIK atau nama sudah ada di database
$checkQuery = "SELECT * FROM pegawai WHERE nik = ? OR nama = ?";
$stmtCheck = $konek->prepare($checkQuery);
$stmtCheck->bind_param("ss", $nik, $nama);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows > 0) {
    // Jika NIK atau nama sudah ada, tampilkan pesan error dengan alert
    echo "<script>
            alert('NIK atau nama sudah ada.');
            window.history.back();
          </script>";
    exit();
}

// Enkripsi data sensitif menggunakan ROT13 dan AES
$nikEncrypted = aesEncrypt(rot13Encrypt($nik), $aesKey);
$alamatEncrypted = aesEncrypt(rot13Encrypt($alamat), $aesKey);
$noTeleponEncrypted = aesEncrypt(rot13Encrypt($no_telepon), $aesKey);
$emailEncrypted = aesEncrypt(rot13Encrypt($email), $aesKey);
$gajiEncrypted = aesEncrypt(rot13Encrypt($gaji), $aesKey);

// Menyimpan data yang sudah dienkripsi ke dalam database
$sql = "INSERT INTO pegawai (nik, nama, alamat, no_telepon, email, gaji, jabatan, tanggal_masuk, aes_key) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $konek->prepare($sql);
$stmt->bind_param("sssssssss", $nikEncrypted, $nama, $alamatEncrypted, $noTeleponEncrypted, $emailEncrypted, $gajiEncrypted, $jabatan, $tanggal_masuk, $aesKey);

if ($stmt->execute()) {
    // Redirect dengan pesan sukses jika data berhasil disimpan
    header("Location: ../views/detail_pegawai.php?success=true");
} else {
    // Redirect dengan pesan error jika ada kesalahan
    header("Location: ../views/enkripsi_teks.php?error=true");
}
exit();
?>
