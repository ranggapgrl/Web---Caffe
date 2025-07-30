<?php
require 'function.php';

  $status = []; // inisialisasi array kosong

$query = "SELECT * FROM pembayaran WHERE status_pembayaran='Belum Bayar'";

$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status[] = $row;
    }
} else {
    echo "Query gagal: " . mysqli_error($conn);
}

$query = "SELECT pesanan.no_meja, pesanan.nama, pesanan.menu, pesanan.harga, pesanan.jumlah, pembayaran.status_pembayaran,
         pembayaran.total_bayar, pembayaran.metode_pembayaran, pembayaran.tanggal_bayar FROM pesanan";

if (isset($_POST["submit"])) {
    $no_meja = mysqli_real_escape_string($conn, $_POST["no_meja"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $menu = mysqli_real_escape_string($conn, $_POST["menu"]);
    $total_bayar = floatval(str_replace('.', '', str_replace(',', '', $_POST["total_bayar"])));

    // Query harga dan jumlah dari pesanan
    $queryHarga = "SELECT harga, jumlah FROM pesanan 
                   WHERE no_meja = '$no_meja' 
                     AND nama = '$nama'
                     AND menu = '$menu'
                   LIMIT 1";

    $resultHarga = mysqli_query($conn, $queryHarga);

    if (mysqli_num_rows($resultHarga) > 0) {
        $rowHarga = mysqli_fetch_assoc($resultHarga);
        $hargaAsli = floatval($rowHarga["harga"]);
        $jumlah = intval($rowHarga["jumlah"]);
        $totalSeharusnya = $hargaAsli * $jumlah;

        if ($total_bayar != $totalSeharusnya) {
            echo "<script>
                alert('Data gagal diinput. Total bayar harusnya yaitu: ' + 
                    (new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'})).format($totalSeharusnya));
                window.history.back();
            </script>";
        } else {
            if (pembayaran($_POST) > 0){
                echo "<script>
                alert('Data berhasil diinput.');
                window.location.href='pembayaran.php';
                </script>";
            } else {
                echo "<script>
                alert('Data gagal diinput.');
                </script>";
            }
        }
    } else {
        echo "<script>
            alert('Data pesanan tidak ditemukan.');
            window.history.back();
        </script>";
    }
}



$pesanan = query("SELECT * FROM pesanan ORDER BY id_menu ASC");

 
if (isset($_GET["no_meja"]) || isset($_GET["nama"]) || isset($_GET["menu"]) || isset($_GET["status_pembayaran"]) ) {
    $keyword = ($_GET["no_meja"] ?? '') . " " . ($_GET["nama"] ?? '') 
    . " " . ($_GET["menu"] ?? '') . " " . ($_GET["status_pembayaran"] ?? '');
    
    $pesanan = cari($keyword);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Pembayaran</title>
    <link rel="stylesheet" href="style/pembayaran.css">
    <style></style>
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
 <h1>Pencarian Data Pesanan</h1>
<!-- Form Pencarian -->
 <div class="search-form">
    <form  method="GET"action="">
        <input type="text" name="no_meja" placeholder="No Meja"><br>
        <input type="text" name="nama" placeholder="Nama"><br>
        <input type="text" name="menu" placeholder="Menu"><br>
        <input type="text" name="status_pembayaran" placeholder="Status"><br>
        <button type="submit" name="submit" value="cari"><b>Cari</b></button>
    </form>
</div>
    
 <!-- Form Status Pembayaran -->
     <table border="1" cellpadding="10" cellspacing="2">
    <tr>
      <th>No.</th>
      <th>No Meja</th>
      <th>Nama</th>
      <th>Menu</th>
      <th>Harga</th>
      <th>jumlah</th>
      <th>Total Bayar</th>
      <th>Metode Pembayaran</th>
      <th>tanggal</th>
      <th>Status</th>
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
          <td><?= htmlspecialchars($row["no_meja"]); ?></td>
          <td><?= htmlspecialchars($row["nama"]); ?></td>
          <td><?= htmlspecialchars($row["menu"]); ?></td>
          <td class="rupiah"><?= htmlspecialchars($row["harga"]); ?></td>
          <td><?= htmlspecialchars($row["jumlah"]); ?></td>
          <td class="rupiah"><?= htmlspecialchars($row["total_bayar"]); ?></td>
          <td><?= htmlspecialchars($row["metode_pembayaran"]); ?></td>
          <td><?= htmlspecialchars($row["tanggal_bayar"] ?? ''); ?></td>
          <td><?= htmlspecialchars($row["status_pembayaran"]); ?></td>
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



    <!-- Form Pembayaran -->
    <form class="payment-form" method="POST" action="">
    <h2>Pembayaran</h2>

    <label for="no_meja">No Meja:</label><br>
    <input type="text" name="no_meja" id="no_meja" required><br><br>

    <label for="nama">Nama:</label><br>
    <input type="text" name="nama" id="nama" required><br><br>

    <label for="menu">Menu:</label><br>
    <input type="text" name="menu" id="menu" required><br><br>

    <label for="total_bayar">Total Bayar:</label><br>
    <input type="text" name="total_bayar" id="total_bayar" required><br><br>

    <label for="metode_pembayaran">Metode Pembayaran:</label><br>
    <select name="metode_pembayaran" id="metode_pembayaran" required>
        <option value="">Pilih Metode</option>
        <option value="Dana">Dana</option>
        <option value="QRIS">QRIS</option>
        <option value="Ovo">Ovo</option>
    </select><br><br>

    <label for="tanggal_bayar">Tanggal Bayar:</label><br>
    <input type="date" name="tanggal_bayar" id="tanggal_bayar" required><br><br>


    <input type="submit" name="submit" value="Bayar">
</form>
</body>
</html>
