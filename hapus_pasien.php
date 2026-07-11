<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$query = $conn->prepare("DELETE FROM pasien WHERE id_pasien=?");
$query->execute([$id]);

header("Location: pasien.php");

?>