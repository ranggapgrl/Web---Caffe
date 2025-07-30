<?php
require 'function.php';

if (isset($_POST["tbl_register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Username berhasil terdaftar!');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal! Username mungkin sudah ada atau password tidak cocok.');
                document.location.href = 'registrasi.php'; // Kembali ke halaman registrasi
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style/registrasi.css">
</head>
<body>
    <div class="register-box">
        <h1>Halaman Registrasi</h1>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="password2">Konfirmasi Password</label>
            <input type="password" name="password2" id="password2" required>

            <button type="submit" name="tbl_register"><b>Registrasi</b></button>

            <p align="center"><a href="login.php"><b style="color: blue;">Login</b></a>,  jika sudah punya akun</p>
        </form>
    </div>
</body>
</html>