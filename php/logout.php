<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Arahkan ke halaman login dengan pesan logout
header("Location: ../login.php?pesan=logout");
exit();
?>
