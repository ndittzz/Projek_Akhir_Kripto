<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['id_pegawai'];
    $aes_key = $_POST['aes_key'];
    $file = $_FILES['file'];
    $nama_pegawai = $_POST['nama_pegawai'];

    // Validasi file
    if ($file['error'] == 0) {
        $fileName = $file['name'];
        $fileContent = file_get_contents($file['tmp_name']);
        
        // 1. Validasi nama file dengan database
        $query = "SELECT file, aes_key FROM file WHERE id_pegawai = '$pegawai_id'";
        $result = mysqli_query($konek, $query);
        $row = mysqli_fetch_assoc($result);

        if (!$row || $row['file'] != $fileName) {
            echo "<script>
                alert('Nama file tidak sesuai. Harap unggah file dengan nama: {$row['file']}');
                window.location.href = '../views/deskripsi_file.php';
            </script>";
            exit();
        }

        // 2. Validasi kunci enkripsi
        if ($row['aes_key'] != $aes_key) {
            echo "<script>
                alert('Kunci enkripsi tidak valid. Proses dihentikan.');
                window.location.href = '../views/deskripsi_file.php';
            </script>";
            exit();
        }

        // 2. Periksa apakah file terenkripsi
        function calculateEntropy($data) {
            $length = strlen($data);
            if ($length === 0) {
                return 0; // File kosong
            }
        
            $counts = count_chars($data, 1); // Hitung kemunculan setiap byte
            $entropy = 0.0;
        
            foreach ($counts as $count) {
                $frequency = $count / $length;
                $entropy -= $frequency * log($frequency, 2);
            }
        
            return $entropy;
        }
        
        function isEncrypted($data) {
            $entropy = calculateEntropy($data);
            return $entropy > 7.5; // File dengan entropi > 7.5 diasumsikan terenkripsi
        }

        // Periksa apakah file terenkripsi
        if (!isEncrypted($fileContent)) {
            echo "<script>
                alert('File yang diunggah tidak terenskripsi. Proses dihentikan.');
                window.location.href = '../views/deskripsi_file.php';
            </script>";
            exit();
        }


        // Fungsi untuk dekripsi RC4
        function rc4Decrypt($data, $key) {
            $s = range(0, 255);
            $j = 0;

            // Key Scheduling Algorithm (KSA)
            for ($i = 0; $i < 256; $i++) {
                $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
                [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
            }

            // Pseudo-Random Generation Algorithm (PRGA)
            $i = $j = 0;
            $result = '';
            for ($k = 0; $k < strlen($data); $k++) {
                $i = ($i + 1) % 256;
                $j = ($j + $s[$i]) % 256;
                [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
                $result .= chr(ord($data[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
            }
            return $result;
        }

        // Dekripsi file
        $decryptedData = rc4Decrypt($fileContent, $aes_key);

        // Menyimpan file hasil dekripsi
        $decryptedFileName = 'decrypted_' . basename($file['name']);
        $decryptedFilePath = '../decrypted_files/' . $decryptedFileName;
        file_put_contents($decryptedFilePath, $decryptedData);

        // Redirect dengan pesan sukses
        header("Location: ../views/deskripsi_file.php?success=true&file=$decryptedFilePath");
        exit();
    } else {
        echo "<script>
            alert('Gagal mengunggah file. Silakan coba lagi.');
            window.location.href = '../views/deskripsi_file.php';
        </script>";
    }
}
?>
