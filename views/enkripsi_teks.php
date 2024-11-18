<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['status'] != "login") {
    header("Location: ../login.php?pesan=belum_login");
    exit(); 
}

$ciphertext = isset($_GET['ciphertext']) ? $_GET['ciphertext'] : '';

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
            <h1 class="mt-4">Enkripsi Teks</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Enkripsi Teks</li>
            </ol>
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Super Enkripsi Teks ROT13 & AES
              </div>
              
              <div class="card-body">
                
              <form action="../php/enkripsi_teks_process.php" method="post">
                <!-- Input NIK -->
                <div class="row mb-3">
                    <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nik" name="nik" required />
                    </div>
                </div>

                <!-- Input Nama -->
                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required />
                    </div>
                </div>

                <!-- Input Alamat -->
                <div class="row mb-3">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>

                <!-- Input Nomor Telepon -->
                <div class="row mb-3">
                    <label for="no_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_telepon" name="no_telepon" required />
                    </div>
                </div>

                <!-- Input Email -->
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                </div>

                <!-- Input Gaji -->
                <div class="row mb-3">
                    <label for="gaji" class="col-sm-2 col-form-label">Gaji</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="gaji" name="gaji" required />
                    </div>
                </div>

                <!-- Input Jabatan -->
                <div class="row mb-3">
                    <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required />
                    </div>
                </div>

                <!-- Input Tanggal Masuk -->
                <div class="row mb-3">
                    <label for="tanggal_masuk" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required />
                    </div>
                </div>

                <!-- Input untuk AES Key -->
                <div class="row mb-3">
                    <label for="aes_key" class="col-sm-2 col-form-label">AES Key</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="aes_key" name="aes_key" required />
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div><br>
            </form>



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
