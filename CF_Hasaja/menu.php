<?php
require 'function.php';
$koneksi = mysqli_connect("localhost:3307", "root", "", "caffe");

if (isset($_POST["submit"])) {
    $no_meja = $_POST["no_meja"];
    $nama = $_POST["nama"];
    $menu = $_POST["menu"];
    $harga = $_POST["harga"];
    $jumlah = $_POST["jumlah"];
    $status_pembayaran = "Belum Bayar";

    // Panggil function upload()
    $foto = upload();
    if (!$foto) {
        // Jika upload gagal, batalkan insert
        return false;
    }

    $query = "INSERT INTO pesanan (no_meja, nama, menu, harga, jumlah, status_pembayaran, foto)
              VALUES ('$no_meja','$nama','$menu','$harga','$jumlah','$status_pembayaran','$foto')";

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "<script>alert('Pesanan sudah ditambahkan');</script>";
    } else {
        echo "<script>alert('Pesanan gagal dibuat');</script>";
    }
}


$ambilPesanan = mysqli_query($koneksi, "SELECT * FROM pesanan");
$pesanan = [];
while ($row = mysqli_fetch_assoc($ambilPesanan)) {
    $pesanan[] = $row;
}

 
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Menu</title>
  <link rel="stylesheet" href="style/menu.css" />
  <style>
    table {
  margin: 20px auto;
  border-collapse: collapse;
  width: 90%; 
  background-color: #fff;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

table th, table td {
  padding: 12px 15px;
  text-align: center;
  border: 1px solid #ddd;
}

table th {
  background-color: #074c43; 
  color: white;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.rupiah {
  color: #4B3832;
  font-weight: bold;
}


  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <a href="index1.2.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <div class="nav-links">
      <a href="index1.2.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="pembayaran.php">Pembayaran</a>
      <a href="kontak.php">Contact</a>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </nav>
  <div class="header">
    <h1>Selamat Datang</h1>
    <p>Pilih menu terlebih dahulu.</p>
  </div>

  <div class="container">
    <div class="image-container">
      <img src="img/MENU.jpg" alt="Menu" />
    </div>

    <div class="form-container">
      <form action="" method="post" enctype="multipart/form-data">

        <ul>
          <li>
            <label for="no_meja">No Meja</label>
            <input type="text" name="no_meja" id="no_meja" required />
          </li>
          <li>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required />
          </li>
          <li>
            <label for="menu">Menu:</label>
            <input type="text" name="menu" id="menu" required />
          </li>
          <li>
            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required />
          </li>
          <li>
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" id="jumlah" required />
          </li>
          <li>
                <label>Foto: </label>
                <input type="file" name="foto">
            </li>
          <li>
            <button type="submit" name="submit">Tambah Pesanan</button>
          </li>
        </ul>
      </form>
    </div>
  </div>

  <!-- Tabel Pesanan -->
  <table border="1" cellpadding="10" cellspacing="2">br
    <tr>
      <th>No.</th>
      <th>Update Pesanan</th>
      <th>No Meja</th>
      <th>Nama</th>
      <th>Menu</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Foto</th>
    </tr>

    <?php if (count($pesanan) === 0): ?>
      <tr>
        <td colspan="8" align="center">Tidak ada data yang dipesan.</td>
      </tr>
    <?php else: ?>
      <?php $i = 1; ?>
      <?php foreach ($pesanan as $row): ?>
        <tr>
          <td><?= $i; ?></td>
          <td>
            <a href="ubah.php?id_menu=<?= $row['id_menu']; ?>"><b>Ubah</b></a> 
            <a href="hapus.php?id=<?= $row['id_menu']; ?>" onclick="return confirm('Yakin ingin menghapus?')"><b>Hapus</b></a>
          </td>
          <td><?= htmlspecialchars($row["no_meja"]); ?></td>
          <td><?= htmlspecialchars($row["nama"]); ?></td>
          <td><?= htmlspecialchars($row["menu"]); ?></td>
          <td class="rupiah"><?= htmlspecialchars($row["harga"]); ?></td>
          <td><?= htmlspecialchars($row["jumlah"]); ?></td>
            <td>
                    <?php if (!empty($row["foto"]) && file_exists("img/" . $row["foto"])): ?>
                        <img src="img/<?= htmlspecialchars($row["foto"]); ?>" width="50">
                    <?php else: ?>
                        <span>Tidak ada foto</span>
                    <?php endif; ?>
                </td>
         </tr>
        <?php $i++; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </table><br><br>
        <a href="pembayaran.php">
          <button type="button">Bayar</button>
         </a>

   <script>
      const formatRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR'
        }).format(angka);
      };

      document.querySelectorAll('.rupiah').forEach(cell => {
        const nilai = parseFloat(cell.textContent);
        if (!isNaN(nilai)) {
          cell.textContent = formatRupiah(nilai);
        }
      });
    </script>

</body>
</html>

