<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pegawai = $_POST['id_pegawai'];
    $nama_pegawai = $_POST['nama_pegawai'];
    $plaintext = $_POST['plaintext'];
    $uploadDir = '../encrypted_images/';
    
    // Handle file upload
    $fileName = $_FILES['gambar']['name'];
    $tempName = $_FILES['gambar']['tmp_name'];
    $filePath = $uploadDir . $fileName;

    // Check if the selected employee name already exists in the database
    $checkQuery = "SELECT * FROM gambar WHERE id_pegawai = '$id_pegawai' AND nama = '$nama_pegawai'";
    $checkResult = mysqli_query($konek, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        // Display error and redirect to enkripsi_file.php
        echo "<script>
                alert('Steganografi tidak bisa dilakukan karena foto pegawai atas nama $nama_pegawai sudah ada di sistem.');
                window.location.href = '../views/enkripsi_gambar.php';
              </script>";
        exit();
    }

    if (move_uploaded_file($tempName, $filePath)) {
        // Read image into memory
        $image = imagecreatefromstring(file_get_contents($filePath));
        if (!$image) {
            die("Failed to load image.");
        }

        // Encode plaintext into image using LSB
        $binaryMessage = '';
        foreach (str_split($plaintext . '|END|') as $char) {
            $binaryMessage .= sprintf('%08b', ord($char));
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $binaryLength = strlen($binaryMessage);
        $messageIndex = 0;

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if ($messageIndex >= $binaryLength) break 2;

                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $lsb = $binaryMessage[$messageIndex++];
                $newB = ($b & 0xFE) | $lsb;

                $newColor = imagecolorallocate($image, $r, $g, $newB);
                imagesetpixel($image, $x, $y, $newColor);
            }
        }

        $encryptedImagePath = $uploadDir . 'encrypted_' . $fileName;
        imagepng($image, $encryptedImagePath);
        imagedestroy($image);
        
        // Hapus gambar asli setelah terenkripsi
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        

        // Insert data into database
        $uploadDate = date('Y-m-d H:i:s');
        $encryptedFileName = 'encrypted_' . $fileName;
        $query = "INSERT INTO gambar (id_pegawai, nama, gambar, upload) VALUES ('$id_pegawai', '$nama_pegawai', '$encryptedFileName', '$uploadDate')";
        $result = mysqli_query($konek, $query);

        if ($result) {
            header("Location: ../views/enkripsi_gambar.php?success=true&gambar=$encryptedImagePath");
        } else {
            echo "Failed to save data into database.";
        }
    } else {
        echo "Failed to upload the file.";
    }
} else {
    header("Location: ../views/enkripsi_gambar.php");
    exit();
}
?>
