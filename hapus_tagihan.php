<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$query = $conn->prepare("
DELETE FROM tagihan
WHERE id_tagihan = ?
");

$query->execute([$id]);

header("Location: tagihan.php");
exit;
?>