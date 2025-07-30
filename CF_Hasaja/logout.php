<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Hapus cookie jika ada
setcookie('login', '', time() - 3600);
setcookie('id', '', time() - 3600);
setcookie('us', '', time() - 3600);

header("Location: login.php");
exit;
?>
