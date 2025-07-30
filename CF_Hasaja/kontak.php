<?php
require 'function.php';

if (isset($_POST["submit"])) {
    if (($_POST) > 0){
        echo "<script>
        alert('Terimakasih atas sarannya.');
        document.location.href = 'kontak.php';
        </script>";
    } else {
       echo "<script>
        alert('Data gagal dikirim');
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="style/about.css" />
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <a href="index1.2.php"><img src="img/logo.png" alt="Logo" /></a>
    </div>
    <div class="nav-links">
      <a href="index1.2.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="pembayaran.php">Pembayaran</a>
      <a href="kontak.php">Contact</a>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </nav>

  <h1>Hubungi Kami</h1>

  <form action="" method="post">
    <div class="kontak">
      <li>
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" required />
      </li>
      <li>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" required />
      </li>
      <li>
        <label for="pesan">Pesan</label>
      </li>
      <li>
        <textarea id="pesan" name="pesan" rows="15" cols="80"></textarea>
      </li>
    </div>
    <button type="submit" name="submit"><b>Kirim Pesan</b></button>
  </form><br><br><br>

<div class="maps">
    <h1>Lokasi Cafe</h1>
    <iframe
     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d283509.1018968323!2d107.61427667631466!3d-6.944703741320412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68d7dad22ca547%3A0x504a1b4c82b52076!2sToleransi%20Kopi%20Jatinangor!5e1!3m2!1sid!2sid!4v1752823326239!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
      width="600"
      height="450"
      style="border:0;"
      allowfullscreen=""
      loading="lazy">
    </iframe>
  </div>
</div>
</body>
</html>
