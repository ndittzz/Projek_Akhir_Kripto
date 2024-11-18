<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $pegawai_id = $_POST['id_pegawai'];
    $aes_key = $_POST['aes_key'];
    $file = $_FILES['file'];
    $pegawai_id = $_POST['id_pegawai'];
    $nama_pegawai = $_POST['nama_pegawai'];

    // Check if the selected employee name already exists in the database
    $checkQuery = "SELECT * FROM file WHERE id_pegawai = '$pegawai_id' AND nama = '$nama_pegawai'";
    $checkResult = mysqli_query($konek, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        // Display error and redirect to enkripsi_file.php
        echo "<script>
                alert('Enkripsi tidak bisa dilakukan karena CV pegawai atas nama $nama_pegawai sudah ada di sistem.');
                window.location.href = '../views/enkripsi_file.php';
              </script>";
        exit();
    }

    // Validasi file
    if ($file['error'] == 0) {
        // Membaca isi file asli
        $fileContent = file_get_contents($file['tmp_name']);
        
        // Fungsi untuk enkripsi RC4
        function rc4Encrypt($data, $key) {
            $s = range(0, 255);
            $j = 0;
            
            // Key Scheduling Algorithm (KSA)
            for ($i = 0; $i < 256; $i++) {
                $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
                $temp = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $temp;
            }

            // Pseudo-Random Generation Algorithm (PRGA)
            $i = 0;
            $j = 0;
            $result = '';
            for ($k = 0; $k < strlen($data); $k++) {
                $i = ($i + 1) % 256;
                $j = ($j + $s[$i]) % 256;
                
                $temp = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $temp;
                
                $result .= chr(ord($data[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
            }
            return $result;
        }

        // Enkripsi file dengan kunci yang diberikan
        $encryptedData = rc4Encrypt($fileContent, $aes_key);

        // Menyimpan file hasil enkripsi
        $encryptedFileName = 'encrypted_' . basename($file['name']);
        $encryptedFilePath = '../encrypted_files/' . $encryptedFileName;
        file_put_contents($encryptedFilePath, $encryptedData);

        // Simpan informasi file ke database
        $query = "INSERT INTO file (id_pegawai, nama, file, aes_key, upload) VALUES ('$pegawai_id', '$nama_pegawai', '$encryptedFileName', '$aes_key', NOW())";
        if (mysqli_query($konek, $query)) {
            header("Location: ../views/enkripsi_file.php?success=true&file=$encryptedFilePath");
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($konek) . "');</script>";
        }

    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
}
?>
