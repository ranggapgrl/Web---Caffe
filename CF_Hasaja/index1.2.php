<?php
session_start();
require 'function.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Home</title>
  <link rel="stylesheet" href="style/index1.css" />
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo">
      <a href="index1.2.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <div class="nav-links">
      <a href="index1.2.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="kontak.php">Contact</a>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </nav>

  <!-- HERO SECTION -->
  <section class="hero">
  <div class="left">
    <h1>COFFEE CULTURE</h1>
    <p>Nikmati kopi dengan berbagai varian dan cita rasa yang baru.</p>
    <a href="menu.php">
      <button>BELI SEKARANG</button>
    </a>
  </div>
  <div class="right">
    <div class="carousel">
      <img src="img/coffe.png" class="carousel-image active" alt="Coffee 1">
      <img src="img/coffe2.png" class="carousel-image" alt="Coffee 2">
      <img src="img/coffe3.png" class="carousel-image" alt="Coffee 3">
    </div>
  </div>
</section>




<script>
  const images = document.querySelectorAll('.carousel-image');
  let current = 0;

  function showNextImage() {
    images[current].classList.remove('active');
    current = (current + 1) % images.length;
    images[current].classList.add('active');
  }

  setInterval(showNextImage, 3000); // ganti gambar setiap 3 detik
</script>



</body>
</html>
