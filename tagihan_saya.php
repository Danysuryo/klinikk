<?php
include 'auth_user.php';
include 'config.php';

/*
=====================================
AMBIL DATA PASIEN LOGIN
=====================================
*/

$query = $conn->prepare("
SELECT *
FROM pasien
WHERE id_user=?
");

$query->execute([
    $_SESSION['id_user']
]);

$pasien = $query->fetch(PDO::FETCH_ASSOC);

if(!$pasien){
    die("Data pasien tidak ditemukan.");
}

/*
=====================================
AMBIL TAGIHAN
=====================================
*/

$query = $conn->prepare("
SELECT
    t.id_tagihan,
    j.tanggal_janji,
    d.nama_dokter,
    d.spesialisasi,
    t.total_biaya,
    t.status_pembayaran
FROM tagihan t

JOIN janji_temu j
ON j.id_janji_temu=t.id_janji_temu

JOIN dokter d
ON d.id_dokter=j.id_dokter

WHERE j.id_pasien=?

ORDER BY j.tanggal_janji DESC
");

$query->execute([
    $pasien['id_pasien']
]);

$dataTagihan = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Tagihan Saya</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f3f7fa;
}

.container{

width:95%;

max-width:1200px;

margin:40px auto;

}

.card{

background:white;

padding:30px;

border-radius:18px;

box-shadow:0 10px 25px rgba(0,0,0,.05);

}

.title{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:30px;

}

.btn{

background:#14b8a6;

color:white;

padding:10px 20px;

text-decoration:none;

border-radius:10px;

}

.btn:hover{

background:#0f766e;

}

table{

width:100%;

border-collapse:collapse;

}

th{

background:#14b8a6;

color:white;

padding:14px;

}

td{

padding:14px;

border-bottom:1px solid #e5e7eb;

}

tr:hover{

background:#f8fafc;

}

.status{

padding:6px 12px;

border-radius:20px;

font-size:13px;

font-weight:600;

display:inline-block;

}

.lunas{

background:#dcfce7;

color:#166534;

}

.lunas{

background:#dcfce7;
color:#166534;

}

.belum-lunas{

background:#fee2e2;
color:#991b1b;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="title">

<h2>Tagihan Saya</h2>

<a
href="dashboard_user.php"
class="btn">

Kembali

</a>

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Dokter</th>

<th>Spesialisasi</th>

<th>Total</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($dataTagihan as $row){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['tanggal_janji']; ?></td>

<td><?= $row['nama_dokter']; ?></td>

<td><?= $row['spesialisasi']; ?></td>

<td>

Rp <?= number_format($row['total_biaya'],0,',','.'); ?>

</td>

<td>

<?php

$class = strtolower(str_replace(" ","-",$row['status_pembayaran']));

?>

<span class="status <?= $class; ?>">

<?= $row['status_pembayaran']; ?>

</span>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</body>

</html>