<?php
require 'function.php';

if (!isset($_GET["id_menu"])) {
    echo "<script>
    alert('ID tidak ditemukan');
    document.location.href = 'menu.php';
    </script>";
    exit;
}

$id = $_GET["id_menu"];

$pesanan = query("SELECT * FROM pesanan WHERE id_menu = $id")[0];

if (isset($_POST["submit"])) {
    if (ubah($_POST) > 0){
        echo "<script>
        alert('data berhasil diubah');
        document.location.href = 'menu.php';
        </script>";
    } else {
       echo "<script>
        alert('data gagal diubah');
        </script>";
    }
}
?>

<link rel="stylesheet" href="style/ubah.css"/>
<body>
<div class="ubah-box">
  <h1>Ubah Data</h1>
  <form action="" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id_menu" value="<?= $pesanan['id_menu']; ?>">
    <input type="hidden" name="fotoOld" value="<?= $pesanan['foto']; ?>">

    <label for="no_meja">No Meja</label>
    <input type="text" name="no_meja" id="no_meja" required value="<?= $pesanan['no_meja']; ?>" />

    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" required value="<?= $pesanan['nama']; ?>"/>

    <label for="menu">Menu:</label>
    <input type="text" name="menu" id="menu" required value="<?= $pesanan['menu']; ?>"/>

    <label for="harga">Harga:</label>
    <input type="number" name="harga" id="harga" required value="<?= $pesanan['harga']; ?>"/>

    <label for="jumlah">Jumlah:</label>
    <input type="number" name="jumlah" id="jumlah" required value="<?= $pesanan['jumlah']; ?>"/>

    <h2>Ubah Foto</h2>
    <label>Foto Sebelumnya:</label><br>
    <img src="img/<?= $pesanan['foto']; ?>" width="100"><br>

    <label>Ubah Foto:</label>
    <input type="file" name="foto">

    <button type="submit" name="submit">Ubah Pesanan</button>
  </form>
  Kembali ke <a href="menu.php"><b style="color: #1976d2;">Menu</b></a>
</div>
</body>
