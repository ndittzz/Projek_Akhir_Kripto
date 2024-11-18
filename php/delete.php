<?php
include "db.php";
$id_pegawai = $_GET['id_pegawai'];
$query = mysqli_query($konek, "DELETE FROM pegawai where id_pegawai=$id_pegawai");
if ($query) {
    header('Location: ../views/deskripsi_teks.php');
} else {
    header('Location: ../views/deskripsi_teks.php');
}
?>