<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$query = $conn->prepare("
DELETE FROM dokter
WHERE id_dokter=?
");

$query->execute([$id]);

header("Location: dokter.php");
exit;

?>