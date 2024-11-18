<?php
session_start();
include '../php/db.php';

if (!isset($_SESSION['username']) || $_SESSION['status'] != "login") {
    header("Location: ../login.php?pesan=belum_login");
    exit(); 
}

$query = "SELECT id_pegawai, nama FROM pegawai";
$result = mysqli_query($konek, $query);
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
                Enkripsi Teks
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
            <h1 class="mt-4">Enkripsi Gambar</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Enkripsi Gambar</li>
            </ol>
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Enkripsi Gambar 
              </div>
              <div class="card-body">
                <form action="../php/enkripsi_gambar_process.php" method="post" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="pegawai" class="col-sm-2 col-form-label">Pilih Pegawai</label>
                    <div class="col-sm-10">
                    <select class="form-control" id="id_pegawai" name="id_pegawai" required onchange="updatePegawaiNama()">
                        <option value=""> Pilih ID - Nama Pegawai </option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id_pegawai'] . "' data-nama='" . $row['nama'] . "'>" . $row['id_pegawai'] . " - " . $row['nama'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" id="nama_pegawai" name="nama_pegawai">

                    </div>
                  </div>
                
                  <div class="row mb-3">
                      <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                      <div class="col-sm-10">
                          <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required onchange="previewImage(event)" />
                          <img id="imagePreview" src="" alt="Image Preview" style="display:none; margin-top: 10px; max-width: 100%; height: auto;" />
                      </div>
                  </div>

                  <div class="row mb-3">
                        <label for="plaintext" class="col-sm-2 col-form-label">Pesan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="plaintext" name="plaintext" rows="3" required></textarea>
                        </div>
                  </div>

                  <div class="text-center">
                      <button type="submit" class="btn btn-secondary">Encrypt</button>
                  </div><br>

                  <?php
                    // Display download link if encryption is successful
                    if (isset($_GET['success']) && $_GET['success'] == 'true') {
                        $downloadLink = $_GET['gambar'];
                        echo "<div class='alert alert-success'>Images has been encrypted. <a href='$downloadLink' class='btn btn-primary' download>Download Encrypted Images</a></div>";
                    }
                  ?>

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
    <script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = 'block';
    }
    </script>
        <script>
      function updatePegawaiNama() {
          const select = document.getElementById("id_pegawai");
          const namaPegawai = select.options[select.selectedIndex].getAttribute("data-nama");
          document.getElementById("nama_pegawai").value = namaPegawai;
      }
    </script>
  </body>
</html>
