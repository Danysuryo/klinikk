<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$query = $conn->prepare("
DELETE FROM janji_temu
WHERE id_janji_temu = ?
");

$query->execute([$id]);

header("Location: janji_temu.php");
exit;

?>