<?php
// Koneksi ke database
$conn = mysqli_connect("localhost:3307", "root", "", "caffe");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function menu($data) {
    global $conn;
    
    $no_meja = ($data["no_meja"]);
    $nama = ($data["nama"]);
    $menu = ($data["menu"]);
    $harga = ($data["harga"]);
    $jumlah = ($data["jumlah"]);

    $foto = upload();
    if (!$foto) {
        return false;
    }

    $query = "INSERT INTO pesanan (no_meja, nama, menu, harga, jumlah, foto) VALUES ('$no_meja', '$nama', '$menu',  '$harga', '$jumlah',$foto')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// menghapus data pemesan
function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM pesanan WHERE id_menu = $id");
    return mysqli_affected_rows($conn);
}

// mengubah data pemesan
function ubah($data){
    global $conn;

    $id = $data["id_menu"];
    $no_meja = htmlspecialchars($data["no_meja"]);
    $nama = htmlspecialchars($data["nama"]);
    $menu = htmlspecialchars($data["menu"]);
    $harga = $data["harga"];
    $jumlah = $data["jumlah"];
    $fotoOld = isset($data["fotoOld"]) ? $data["fotoOld"] : ''; // tambahan pengecekan agar tidak warning

    // cek apakah input file "foto" ada dan tidak error
    if (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] === 4) {
        $foto = $fotoOld;
    } else {
        $foto = upload();
        if (!$foto) {
            return 0; 
        }

        // menghapus foto lama dari folder sebelumnya
        if (!empty($fotoOld) && file_exists("img/$fotoOld")) {
            unlink("img/$fotoOld");
        }
    }

    $query = "UPDATE pesanan SET
        no_meja = '$no_meja',
        nama = '$nama',
        menu = '$menu',
        harga = '$harga',
        jumlah = '$jumlah',
        foto = '$foto'
        WHERE id_menu = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}




 function upload(){
    if (!isset($_FILES['foto'])) {
        echo "<script>alert('Tidak ada file yang diupload');</script>";
        return false;
    }

    $filename = $_FILES['foto']['name'];
    $filesize = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if($error === 4){
        echo "<script>alert('Upload gambar terlebih dahulu!');</script>";
        return false; 
    }

    $fileExtensionValid = ['jpg', 'jpeg', 'png'];
    $fileExtension = explode('.', $filename);
    $fileExtension = strtolower(end($fileExtension));

    if(!in_array($fileExtension, $fileExtensionValid)){
        echo "<script>alert('Ekstensi file tidak valid. Upload JPG, JPEG, atau PNG');</script>";
        return false;
    }

    if($filesize > 1000000){
        echo "<script>alert('Ukuran gambar terlalu besar');</script>";
        return false;
    }

    $newFileName = uniqid() . '.' . $fileExtension;
    move_uploaded_file($tmpName, 'img/' . $newFileName);
    return $newFileName;
}




function cari($keyword){
    global $conn;
    $keywords = explode(" ", $keyword); 
    $query = "SELECT * FROM pesanan WHERE 1=1";

    foreach($keywords as $word){
        $word = trim(mysqli_real_escape_string($conn, $word));
        $query .= " AND (no_meja LIKE '%$word%' OR nama LIKE '%$word%' OR menu LIKE '%$word%' OR status_pembayaran LIKE '%$word%')";
    }

    return query($query);
}

 function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = $data["password"];  
    $password2 = $data["password2"]; 

    
    $stmt = mysqli_prepare($conn, "SELECT username FROM registrasi WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username); 
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!');
              </script>";
        return false;
    }
    mysqli_stmt_close($stmt); 

    // Cek konfirmasi password 
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
              </script>";
        return false;
    }

    // Hash password 
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO registrasi (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password_hashed); // 'ss' untuk dua string
    mysqli_stmt_execute($stmt);

    $affected_rows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $affected_rows;
}
function pembayaran($data) {
    global $conn;

    $no_meja = htmlspecialchars($data["no_meja"]);
    $nama = htmlspecialchars($data["nama"]);
    $menu = htmlspecialchars($data["menu"]);
    $total_bayar = htmlspecialchars($data["total_bayar"]);
    $metode_pembayaran = htmlspecialchars($data["metode_pembayaran"]);
    $tanggal_bayar = htmlspecialchars($data["tanggal_bayar"]);
    $status_pembayaran = "Lunas"; // tambahkan deklarasi status pembayaran

    // Update tabel pesanan
    $queryPesanan = "UPDATE pesanan SET 
                        total_bayar = '$total_bayar',
                        metode_pembayaran = '$metode_pembayaran',
                        tanggal_bayar = '$tanggal_bayar',
                        status_pembayaran = 'Sudah Dibayar'
                    WHERE no_meja = '$no_meja' 
                    AND nama = '$nama' 
                    AND menu = '$menu'";

    $updatePesanan = mysqli_query($conn, $queryPesanan);

    // Insert ke tabel pembayaran
    $query = "INSERT INTO pembayaran 
    (no_meja, nama, menu, total_bayar, metode_pembayaran, tanggal_bayar, status_pembayaran)
    VALUES 
    ('$no_meja', '$nama', '$menu',  '$total_bayar', '$metode_pembayaran', '$tanggal_bayar', '$status_pembayaran')";

    $insertPembayaran = mysqli_query($conn, $query);

    // Cek apakah update dan insert berhasil
    if ($updatePesanan && $insertPembayaran) {
        return true; // sukses
    } else {
        return false; // gagal
    }
}








    

    
?>