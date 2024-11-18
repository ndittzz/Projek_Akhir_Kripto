<?php
session_start();

include "../php/db.php";

if (!isset($_SESSION['username']) || $_SESSION['status'] != "login") {
    header("Location: ../login.php?pesan=belum_login");
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="../assets/icon.png" />

    <title>Dashboard Admin</title>
    <link
      href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
      rel="stylesheet"
    />
    <link href="../css/bootstrap.css" rel="stylesheet" />
    <script
      src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="dashboard.php">DASHBOARD</a>
      <!-- Sidebar Toggle-->
      <button
        class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
        id="sidebarToggle"
        href="#!"
      >
        <i class="fas fa-bars"></i>
      </button>
      <!-- Navbar Search-->
      <form
        class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"
      >
      </form>
      <!-- Navbar-->
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            id="navbarDropdown"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            ><i class="fas fa-user fa-fw"></i
          ></a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdown"
          >
            <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
            <div class="nav">
              <div class="sb-sidenav-menu-heading">Menu Utama</div>
              <a class="nav-link" href="dashboard.php">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-tachometer-alt"></i>
                </div>
                Dashboard
              </a>
              <div class="sb-sidenav-menu-heading">Menu Enkripsi</div>
              <a class="nav-link" href="enkripsi_teks.php">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-chart-area"></i>
                </div>
                Input Pegawai
              </a>
              <a class="nav-link" href="detail_pegawai.php">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-chart-area"></i>
                </div>
                Detail Pegawai
              </a>
              <a class="nav-link" href="enkripsi_file.php">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-chart-area"></i>
                </div>
                Enkripsi File
              </a>
              <a class="nav-link" href="enkripsi_gambar.php">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Enkripsi Gambar
              </a>
            </div>
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Daftar Pegawai</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Daftar Pegawai</li>
            </ol>
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Pegawai
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <th>Email</th>
                      <th>Gaji</th>
                      <th>Jabatan</th>
                      <th>Masuk</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        // Mengambil data dari tabel pegawai
                        $query = mysqli_query($konek, "SELECT * FROM pegawai");
                        while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?= $row['id_pegawai']; ?></td>
                        <td><?= $row['nik']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['gaji']; ?></td>
                        <td><?= $row['jabatan']; ?></td>
                        <td><?= $row['tanggal_masuk']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>  
        </main>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="js/scripts.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="../js/main.js"></script>
    <script src="../js/scripts.js"></script>
  </body>
</html>
