<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:../login.php?pesan=belum_login");
}
?>
<html>

<head>
    <title>Halaman Session</title>
</head>

<body>
    <?php
    echo $_SESSION['username'];
    ?>
    <br>
    <a href="logout.php">Logout</a>
</body>

</html>