<?php
include 'auth_user.php';
include 'config.php';

if(!isset($_GET['id'])){
    header("Location: janji_saya.php");
    exit;
}

$id_janji = $_GET['id'];

/*
=====================================
AMBIL DATA PASIEN LOGIN
=====================================
*/

$query = $conn->prepare("
SELECT id_pasien
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
AMBIL DETAIL JANJI
=====================================
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
WHERE
    j.id_janji_temu=?
AND
    j.id_pasien=?
");

$query->execute([
    $id_janji,
    $pasien['id_pasien']
]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if(!$data){

    die("Data tidak ditemukan.");

}

$bulan = [
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember"
];

$tanggal = date('d', strtotime($data['tanggal_janji']));
$namaBulan = $bulan[(int)date('m', strtotime($data['tanggal_janji']))];
$tahun = date('Y', strtotime($data['tanggal_janji']));

$tanggalIndonesia = $tanggal . " " . $namaBulan . " " . $tahun;
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Detail Janji</title>

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

max-width:700px;

margin:40px auto;

}

.card{

background:white;

padding:35px;

border-radius:18px;

box-shadow:0 10px 25px rgba(0,0,0,.05);

}

h2{

margin-bottom:30px;

color:#111827;

}

table{

width:100%;

border-collapse:collapse;

}

td{

padding:14px;

border-bottom:1px solid #ececec;

}

td:first-child{

font-weight:600;

width:180px;

}

.status{

display:inline-block;

padding:8px 15px;

border-radius:20px;

font-size:13px;

font-weight:600;

}

.menunggu{

background:#FEF3C7;

color:#92400E;

}

.diproses{

background:#DBEAFE;

color:#1D4ED8;

}

.selesai{

background:#DCFCE7;

color:#166534;

}

.dibatalkan{

background:#FEE2E2;

color:#991B1B;

}

.btn{

display:inline-block;

margin-top:30px;

padding:12px 25px;

background:#14b8a6;

color:white;

text-decoration:none;

border-radius:10px;

}

.btn:hover{

background:#0f766e;

}

.booking{

background:#14b8a6;

color:white;

padding:8px 18px;

border-radius:8px;

font-weight:bold;

display:inline-block;

}
</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="ticket">

    <div class="ticket-header">

        <h1>KLINIK KLUNUK</h1>

        <p>Sistem Informasi Klinik</p>

    </div>

    <div class="ticket-title">

        <h2>Bukti Janji Temu</h2>

        <p>
            Tunjukkan bukti ini kepada petugas saat registrasi.
        </p>

    </div>

    <div class="booking-number">

        <small>No. Booking</small>

        <h1><?= $data['id_janji_temu']; ?></h1>

    </div>

    <div class="info">

        <div class="item">

            <span>Dokter</span>

            <strong><?= htmlspecialchars($data['nama_dokter']); ?></strong>

        </div>

        <div class="item">

            <span>Spesialisasi</span>

            <strong><?= htmlspecialchars($data['spesialisasi']); ?></strong>

        </div>

        <div class="item">

            <span>Tanggal</span>

            <strong>

                <?= $tanggalIndonesia; ?>

            </strong>

        </div>

        <div class="item">

            <span>Status</span>

            <strong>

                <span class="status <?= strtolower($data['status']) ?>">

                    <?= $data['status']; ?>

                </span>

            </strong>

        </div>

    </div>

    <div class="keluhan">

        <h3>Keluhan Pasien</h3>

        <p>

            <?= htmlspecialchars($data['keluhan']); ?>

        </p>

    </div>

    <div class="note">

        Harap datang minimal <b>15 menit</b> sebelum jadwal pemeriksaan.
        Simpan nomor booking untuk mempermudah proses registrasi.

    </div>

    <div class="button-group">

        <a
        href="janji_saya.php"
        class="btn">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

</div>

</div>

</body>

</html>