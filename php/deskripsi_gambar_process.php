<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['id_pegawai'];
    $uploadDir = '../encrypted_images/';
    $fileName = $_FILES['gambar']['name'];
    $tempName = $_FILES['gambar']['tmp_name'];
    $filePath = $uploadDir . $fileName;

    // 1. Validasi nama gambar dengan database
    $query = "SELECT gambar FROM gambar WHERE id_pegawai = '$pegawai_id'";
    $result = mysqli_query($konek, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row || $row['gambar'] != $fileName) {
        echo "<script>
            alert('Nama gambar tidak sesuai. Harap unggah gambar dengan nama: {$row['gambar']}');
            window.location.href = '../views/deskripsi_gambar.php';
        </script>";
        exit();
    }

    // 2. Handle file upload
    if (move_uploaded_file($tempName, $filePath)) {
        $image = imagecreatefromstring(file_get_contents($filePath));
        if (!$image) {
            die("Failed to load image.");
        }

        $width = imagesx($image);
        $height = imagesy($image);

        $binaryMessage = '';
        $message = '';

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $b = $rgb & 0xFF;

                $binaryMessage .= ($b & 1);

                if (strlen($binaryMessage) == 8) {
                    $char = chr(bindec($binaryMessage));
                    if ($char === '|') {
                        $terminatorCheck = substr($message, -3) . $char;
                        if ($terminatorCheck === 'END|') {
                            $message = substr($message, 0, -3);
                            break 2;
                        }
                    }
                    $message .= $char;
                    $binaryMessage = '';
                }
            }
        }
        $message = rtrim($message, '|');
        imagedestroy($image);
        unlink($filePath);

        if ($message) {
            header("Location: ../views/deskripsi_gambar.php?plaintext=" . urlencode($message));
        } else {
            echo "<script>alert('Pesan tidak ditemukan atau tidak valid dalam gambar.'); window.location.href = '../views/deskripsi_gambar.php';</script>";
        }
    } else {
        echo "Failed to upload the file.";
    }
} else {
    header("Location: ../views/deskripsi_gambar.php");
    exit();
}
?>
