<?php
include 'auth_user.php';
include 'config.php';

/*
=================================
AMBIL DATA PASIEN LOGIN
=================================
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
=================================
AMBIL JANJI USER
=================================
*/

$query = $conn->prepare("
SELECT
    j.id_janji_temu,
    j.tanggal_janji,
    j.keluhan,
    j.status,
    d.nama_dokter,
    d.spesialisasi
FROM janji_temu j
JOIN dokter d
ON d.id_dokter=j.id_dokter
WHERE j.id_pasien=?
ORDER BY j.tanggal_janji DESC
");

$query->execute([
    $pasien['id_pasien']
]);

$dataJanji = $query->fetchAll(PDO::FETCH_ASSOC);

$totalJanji = count($dataJanji);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Janji Saya</title>

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

.title h2{

color:#111827;

}

.btn{

background:#14b8a6;

color:white;

text-decoration:none;

padding:10px 20px;

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

.menunggu{

background:#fef3c7;

color:#92400e;

}

.selesai{

background:#dcfce7;

color:#166534;

}

.diproses{

background:#dbeafe;

color:#1d4ed8;

}

.aksi{

display:flex;

justify-content:center;

align-items:center;

gap:10px;

flex-wrap:wrap;

}

.detail-btn,
.cancel-btn{

display:flex;

align-items:center;

justify-content:center;

gap:6px;

min-width:100px;

padding:10px 14px;

border-radius:8px;

text-decoration:none;

font-size:13px;

font-weight:500;

transition:.25s;

}

.detail-btn{

background:#3b82f6;

color:white;

}

.detail-btn:hover{

background:#2563eb;

}

.cancel-btn{

background:#ef4444;

color:white;

}

.cancel-btn:hover{

background:#dc2626;

}

.detail-btn:hover{

background:#2563eb;

}

.cancel-btn{

display:inline-block;

padding:8px 12px;

background:#ef4444;

color:white;

text-decoration:none;

border-radius:8px;

font-size:13px;

}

.cancel-btn:hover{

background:#dc2626;

}

.dibatalkan{

background:#FEE2E2;

color:#991B1B;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="title">

<div>

<h2>

Riwayat Janji Saya

</h2>

<p
style="
margin-top:8px;
color:#6b7280;
">

Total Janji :
<b><?= $totalJanji ?></b>

</p>

</div>

<a
href="dashboard_user.php"
class="btn">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Tanggal</th>

<th>Dokter</th>

<th>Spesialis</th>

<th>Keluhan</th>

<th>Status</th>

<th width="240">
Aksi
</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($dataJanji as $row){

?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<?= $row['tanggal_janji']; ?>

</td>

<td>

<?= $row['nama_dokter']; ?>

</td>

<td>

<?= $row['spesialisasi']; ?>

</td>

<td>

<?= $row['keluhan']; ?>

</td>

<td>

<?php

$status = strtolower($row['status']);

?>

<span class="status <?= $status; ?>">

<?= $row['status']; ?>

</span>

</td>

<td>

<div class="aksi">

<a
href="detail_janji.php?id=<?= $row['id_janji_temu']; ?>"
class="detail-btn">

<i class="fa-solid fa-eye"></i>

Detail

</a>

<?php if($row['status']=="Menunggu"){ ?>

<a
href="batalkan_janji.php?id=<?= $row['id_janji_temu']; ?>"
class="cancel-btn"
onclick="return confirm('Batalkan janji ini?')">

<i class="fa-solid fa-ban"></i>

Batalkan

</a>

<?php } ?>

</div>

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