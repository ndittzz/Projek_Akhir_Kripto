<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="../js/main.js"></script>
    <link rel="shortcut icon" href="../assets/icon.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&family=Roboto+Slab:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

  </head>
  <body style="background-color: #ffffff">
    <section class="login d-flex">
      <div class="login-left">
        <div class="row h-100 justify-content-center align-items-center">
          <div class="col-7">
            <div class="header">
              <h1>Register Admin!</h1>
              <p>Selamat datang! Silahkan masukan detail anda</p>
            </div>
            <form
              id="register-form"
              class="login-form"
              method="POST"
              action="../php/register_process.php"
              onsubmit="return validatePassword()"
            >
              <label for="username" class="form-label">Username</label>
              <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                placeholder="Masukkan username"
                required
              />
              <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                  />
                  <span class="input-group-text" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                    <i id="togglePasswordIcon" class="fa fa-eye"></i>
                  </span>
                </div>

                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                  <input
                    type="password"
                    class="form-control"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Masukkan kembali password"
                    required
                  />
                  <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPasswordIcon')">
                    <i id="toggleConfirmPasswordIcon" class="fa fa-eye"></i>
                  </span>
                </div>

              <!-- <small id="passwordHelp" class="text-muted">
                Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
              </small> -->
              <button
                type="submit"
                value="REGISTER"
                class="btn btn-primary mt-3"
              >
                Daftar
              </button>
              <p>
                Sudah punya akun?
                <a href="../login.php">Klik disini</a>
              </p>
            </form>
          </div>
        </div>
      </div>
      <div class="login-right w-50">
        <img
          src="../assets/login.jpg"
          alt="Wallpaper"
          style="width: 100%; height: 100%; object-fit: cover"
        />
      </div>
    </section>

    <script>
      function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        
        if (!passwordPattern.test(password)) {
          alert("Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.");
          return false;
        }

        if (password !== confirmPassword) {
          alert("Password dan konfirmasi password tidak cocok.");
          return false;
        }

        return true;
      }


      document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const message = urlParams.get("pesan");

      if (message === "gagal") {
        alert("Login gagal! Username dan password salah!");
      } else if (message === "logout") {
        alert("Anda telah berhasil logout");
      } else if (message === "belum_login") {
        alert("Anda harus login untuk mengakses halaman admin");
      } else if (message === "username_terdaftar") {
        alert("Username sudah terdaftar. Silakan gunakan username lain.");
      } else if (message === "gagal_daftar") {
        alert("Pendaftaran gagal. Silakan coba lagi.");
      } else if (message === "password_tidak_sama") {
        alert("Password dan konfirmasi password tidak cocok.");
      } else if (message === "register_sukses") {
        alert("Registrasi berhasil! Silakan login.");
      }
    });

    function togglePasswordVisibility(inputId, iconId) {
      const passwordInput = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }


    </script>
  </body>
</html>
