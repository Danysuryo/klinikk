<?php

include "../config.php";

$query = $conn->query("
SELECT *
FROM pasien
ORDER BY id_pasien
");

$data = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($data);