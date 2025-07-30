<?php
$host = "localhost:3308";
$user = "root";
$password = "";
$db = "caffe";

$conn = mysqli_connect("localhost:3308", "root", "", "caffe");

if (!$conn) {
    die("koneksi gagal : " . mysqli_connect_error());
}
 //echo "Koneksi Berhasil";
?>