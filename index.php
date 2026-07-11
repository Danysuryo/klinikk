
<?php
include 'auth_admin.php';
include 'config.php';
$jumlah_pasien = $conn->query("SELECT COUNT(*) FROM pasien")->fetchColumn();

$jumlah_dokter = $conn->query("SELECT COUNT(*) FROM dokter")->fetchColumn();

$jumlah_janji = $conn->query("SELECT COUNT(*) FROM janji_temu")->fetchColumn();

$jumlah_tagihan = $conn->query("SELECT COUNT(*) FROM tagihan")->fetchColumn();
/* ===========================
STATUS JANJI TEMU
=========================== */

$statusJanji = $conn->query("
SELECT status,
COUNT(*) AS total
FROM janji_temu
GROUP BY status
");

$statusLabel = [];
$statusData = [];

while($row = $statusJanji->fetch(PDO::FETCH_ASSOC)){

    $statusLabel[] = $row['status'];
    $statusData[] = (int)$row['total'];

}

/* ===========================
TREN 7 HARI
=========================== */

$trend = $conn->query("
SELECT
tanggal_janji,
COUNT(*) AS total
FROM janji_temu
GROUP BY tanggal_janji
ORDER BY tanggal_janji DESC
LIMIT 7
");

$tanggal = [];
$totalJanji = [];

while($row = $trend->fetch(PDO::FETCH_ASSOC)){

    $tanggal[] = date('d M', strtotime($row['tanggal_janji']));
    $totalJanji[] = (int)$row['total'];

}

$tanggal = array_reverse($tanggal);
$totalJanji = array_reverse($totalJanji);

/* ===========================
JANJI TERBARU
=========================== */

$janjiTerbaru = $conn->query("
SELECT
p.nama_pasien,
d.nama_dokter,
j.tanggal_janji,
j.status
FROM janji_temu j
JOIN pasien p ON p.id_pasien=j.id_pasien
JOIN dokter d ON d.id_dokter=j.id_dokter
ORDER BY j.id_janji_temu DESC
LIMIT 5
");

/* ===========================
TAGIHAN TERBARU
=========================== */

$tagihanTerbaru = $conn->query("
SELECT

p.nama_pasien,
t.total_biaya,
t.status_pembayaran

FROM tagihan t

JOIN janji_temu j
ON j.id_janji_temu=t.id_janji_temu

JOIN pasien p
ON p.id_pasien=j.id_pasien

ORDER BY t.id_tagihan DESC

LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Klinik</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
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

.wrapper{

display:flex;

width:100%;

min-height:100vh;

overflow:hidden;

}
.chart-wrapper{

width:100%;

max-width:450px;

margin:20px auto;

}

/* =======================
SIDEBAR
========================== */

.sidebar{
    width:270px;
    min-width:270px;
    background:#fff;
    border-right:1px solid #e5e7eb;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    transition:
    width .35s ease,
    min-width .35s ease;
}

.logo-text{

    opacity:1;
    visibility:visible;
    width:auto;

    white-space:nowrap;
    overflow:hidden;

    transition:
        opacity .25s ease,
        width .35s ease,
        margin .35s ease;

}

.logo-text h2{

    margin:0;

    font-size:18px;

}

.logo-text p{

    margin-top:3px;

}

.logo-icon{

width:60px;

height:60px;

border-radius:15px;

background:#14b8a6;

display:flex;

align-items:center;

justify-content:center;

font-size:28px;

color:white;

box-shadow:0 8px 20px rgba(20,184,166,.25);

}

.logo h2{

font-size:18px;

color:#111827;

font-weight:600;

}

.logo p{

font-size:13px;

color:#6b7280;

margin-top:3px;

}

/* ===========================
MENU
=========================== */

.menu{

padding:20px 15px;

}

.menu-title{

font-size:12px;

font-weight:600;

color:#9ca3af;

padding:0 15px 10px;

text-transform:uppercase;

letter-spacing:1px;

}

.menu a{

display:flex;

align-items:center;

gap:15px;

text-decoration:none;

color:#374151;

padding:14px 16px;

margin-bottom:8px;

border-radius:12px;

transition:all .35s ease;

}

.menu a:hover{

background:#e6fffb;

color:#14b8a6;

}

.menu a.active{

background:#14b8a6;

color:white;

box-shadow:0 8px 18px rgba(20,184,166,.25);

}

.menu a i{

width:24px;

font-size:18px;

text-align:center;

}

/* ===========================
MAIN
=========================== */

.main{

flex:1;

display:flex;

flex-direction:column;

width:100%;

overflow:hidden;

transition:.35s;

}

/* ===========================
HEADER
=========================== */

.header{

height:80px;

background:white;

display:flex;

justify-content:space-between;

align-items:center;

padding:0 35px;

border-bottom:1px solid #e5e7eb;

}

.header-left h2{

font-size:24px;

color:#111827;

}

.header-left p{

font-size:13px;

color:#6b7280;

}

.header-right{

display:flex;

align-items:center;

gap:18px;

}

.circle{

width:45px;

height:45px;

border-radius:50%;

background:#f3f4f6;

display:flex;

justify-content:center;

align-items:center;

font-size:18px;

color:#374151;

cursor:pointer;

transition:.2s;

}

.circle:hover{

background:#14b8a6;

color:white;

}

/* ===========================
CONTENT
=========================== */

.content{

padding:30px;

flex:1;

width:100%;

overflow-x:hidden;

}

.welcome{

background:white;

border-radius:20px;

padding:35px;

box-shadow:0 10px 30px rgba(0,0,0,.05);

margin-bottom:25px;

}

.welcome h1{

font-size:28px;

color:#111827;

margin-bottom:8px;

}

.welcome p{

font-size:15px;

color:#6b7280;

line-height:28px;

}

/* ===========================
STATISTIC CARD
=========================== */

.stats{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:30px;

}

.stat-card{

background:white;

border-radius:18px;

padding:25px;

box-shadow:0 10px 25px rgba(0,0,0,.05);

display:flex;

justify-content:space-between;

align-items:center;

transition:.3s;

}

.stat-card:hover{

transform:translateY(-5px);

}

.stat-info h4{

font-size:14px;

color:#6b7280;

margin-bottom:8px;

}

.stat-info h2{

font-size:32px;

color:#111827;

}

.stat-info p{

font-size:12px;

color:#9ca3af;

margin-top:5px;

}

.stat-icon{

width:65px;

height:65px;

border-radius:15px;

display:flex;

justify-content:center;

align-items:center;

font-size:28px;

color:white;

}

.pasien{

background:#3B82F6;

}

.dokter{

background:#14B8A6;

}

.janji{

background:#F59E0B;

}

.tagihan{

background:#8B5CF6;

}

/* ======================
QUICK MENU
====================== */

.quick-title{

font-size:22px;

font-weight:600;

margin-bottom:20px;

color:#111827;

}

.quick-menu{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-bottom:30px;

}

.quick-card{

background:white;

padding:25px;

border-radius:18px;

text-decoration:none;

box-shadow:0 10px 25px rgba(0,0,0,.05);

text-align:center;

transition:.3s;

color:#374151;

}

.quick-card:hover{

transform:translateY(-6px);

}

.quick-card i{

font-size:40px;

color:#14b8a6;

margin-bottom:15px;

}

.quick-card h3{

font-size:18px;

margin-bottom:10px;

}

.quick-card p{

font-size:13px;

color:#6b7280;

}

/* ======================
CHART AREA
====================== */

.chart-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

}

.chart-box{

background:white;

border-radius:18px;

padding:25px;

min-height:500px;

box-shadow:0 8px 25px rgba(0,0,0,.06);

}

.chart-box h3{

margin-bottom:20px;

color:#111827;

}



.bottom-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

margin-top:25px;

}

.panel{

background:white;

border-radius:18px;

padding:25px;

box-shadow:0 8px 25px rgba(0,0,0,.05);

}

.panel h3{

margin-bottom:20px;

font-size:18px;

color:#111827;

}

.panel table{

width:100%;

border-collapse:collapse;

}

.panel table th{

padding:12px;

background:#14b8a6;

color:white;

font-size:14px;

}

.panel table td{

padding:12px;

border-bottom:1px solid #eee;

font-size:14px;

}

.badge{

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.menunggu{

background:#FEF3C7;

color:#B45309;

}

.selesai{

background:#DCFCE7;

color:#15803D;

}

.bayar{

background:#DBEAFE;

color:#1D4ED8;

}

/* =======================
SIDEBAR COLLAPSE
======================= */



.main{

transition:.35s ease;

}

/* =======================================
SIDEBAR COLLAPSE
======================================= */
.sidebar.minimize{

    width:90px;

    min-width:90px;

}

.sidebar.minimize + .main{

width:calc(100% - 90px);

}

/* logo */

.logo{

    display:flex;

    align-items:center;

    gap:15px;

    padding:22px;

    min-height:105px;

    border-bottom:1px solid #e5e7eb;

    flex-shrink:0;
    
    transition:all .35s ease;

}


/* menu */

.menu a{

    display:flex;

    align-items:center;

    gap:15px;

    transition:.3s;

}

.menu a span{

    display:inline-block;

    opacity:1;
    visibility:visible;

    transition:
        opacity .25s ease,
        width .35s ease,
        margin .35s ease;

}

.sidebar.minimize .menu-title{

    display:none;

}

.sidebar.minimize .menu a{

    justify-content:center;

    gap:0;

    padding:16px 0;

}



.sidebar.minimize .menu a i{

    margin:0;

    font-size:22px;

}

.sidebar.minimize .logo{

    justify-content:center;

    padding:22px 0;

}

.sidebar.minimize .logo-text{

    opacity:0;
    visibility:hidden;
    width:0;
    margin:0;
    overflow:hidden;

}
/* Logo */


/* Judul menu */

.sidebar.minimize .menu-title{
    display:none;
}

/* Menu */

.sidebar.minimize .menu a{

    display:flex;

    justify-content:center;

    align-items:center;

    padding:16px 0;

    gap:0;

}
.sidebar.minimize .menu a span{

    opacity:0;
    width:0;
    margin:0;
    overflow:hidden;
    visibility:hidden;

}

.sidebar{
    display:flex;
    flex-direction:column;
    height:100vh;
}

.sidebar-menu{
    flex:1;
}

.logout{
    padding:20px;
    border-top:1px solid #e5e7eb;
}

.logout a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 18px;
    border-radius:10px;
    text-decoration:none;
    color:#ef4444;
    font-weight:600;
    transition:.3s;
}

.logout a:hover{
    background:#fee2e2;
}

/* Hover */

.sidebar.minimize .menu a:hover{

    border-radius:12px;

    margin:0 10px;

}
</style>

</head>

<body>

<div class="wrapper">

<div class="sidebar">
    

<div class="logo">

    <div class="logo-icon">
        <i class="fa-solid fa-house-medical"></i>
    </div>

    <div class="logo-text">

        <h2>Klinik Klunuk</h2>

        <p>Sistem Informasi</p>

    </div>

</div>

<div class="menu">

<div class="menu-title">

MAIN MENU

</div>

<a class="active" href="index.php">

<i class="fa-solid fa-house"></i>

<span>Dashboard</span>

</a>

<a href="pasien.php">

<i class="fa-solid fa-user-group"></i>

<span>Pasien</span>

</a>

<a href="dokter.php">

<i class="fa-solid fa-user-doctor"></i>

<span>Dokter</span>

</a>

<a href="janji_temu.php">

<i class="fa-solid fa-calendar-check"></i>

<span>Janji Temu</span>

</a>

<a href="tagihan.php">

<i class="fa-solid fa-file-invoice-dollar"></i>

<span>Tagihan</span>

</a>

</div>

<div class="logout">

    <a href="logout.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </a>

</div>

</div>

<div class="main">

<div class="header">

<div class="header-left">

<div style="display:flex;align-items:center;gap:18px;">

<div id="toggleSidebar" style="
width:42px;
height:42px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
background:#f3f4f6;
cursor:pointer;
font-size:20px;
">

<i class="fa-solid fa-bars"></i>

</div>

<div>

<h2>Dashboard</h2>

<p>Sistem Informasi Klinik Klunuk</p>

</div>

</div>

</div>

</div>

<div class="content">

<div class="welcome">

<h1>Selamat Datang</h1>

<p>

Dashboard ini digunakan untuk mengelola data pasien, dokter,
janji temu, dan tagihan secara terintegrasi.

</p>

</div>

<div class="stats">

<div class="stat-card">

<div class="stat-info">

<h4>Jumlah Pasien</h4>

<h2><?= $jumlah_pasien ?></h2>

<p>Data pasien terdaftar</p>

</div>

<div class="stat-icon pasien">

<i class="fa-solid fa-user-group"></i>

</div>

</div>

<div class="stat-card">

<div class="stat-info">

<h4>Jumlah Dokter</h4>

<h2><?= $jumlah_dokter ?></h2>

<p>Dokter aktif</p>

</div>

<div class="stat-icon dokter">

<i class="fa-solid fa-user-doctor"></i>

</div>

</div>

<div class="stat-card">

<div class="stat-info">

<h4>Janji Temu</h4>

<h2><?= $jumlah_janji ?></h2>

<p>Total konsultasi</p>

</div>

<div class="stat-icon janji">

<i class="fa-solid fa-calendar-check"></i>

</div>

</div>

<div class="stat-card">

<div class="stat-info">

<h4>Tagihan</h4>

<h2><?= $jumlah_tagihan ?></h2>

<p>Total transaksi</p>

</div>

<div class="stat-icon tagihan">

<i class="fa-solid fa-file-invoice-dollar"></i>

</div>

</div>

</div>

<h2 class="quick-title">

Menu Cepat

</h2>

<div class="quick-menu">

<a href="pasien.php" class="quick-card">

<i class="fa-solid fa-user-group"></i>

<h3>Pasien</h3>

<p>Kelola data pasien.</p>

</a>

<a href="dokter.php" class="quick-card">

<i class="fa-solid fa-user-doctor"></i>

<h3>Dokter</h3>

<p>Kelola data dokter.</p>

</a>

<a href="janji_temu.php" class="quick-card">

<i class="fa-solid fa-calendar-days"></i>

<h3>Janji Temu</h3>

<p>Kelola jadwal konsultasi.</p>

</a>

<a href="tagihan.php" class="quick-card">

<i class="fa-solid fa-file-invoice"></i>

<h3>Tagihan</h3>

<p>Kelola pembayaran pasien.</p>

</a>

</div>

<div class="chart-grid">

    <div class="chart-box">

        <h3>Status Janji Temu</h3>

    <div class="chart-wrapper">

    <canvas id="statusChart"></canvas>

</div>

    </div>

    <div class="chart-box">

        <h3>Tren Janji Temu</h3>

        <canvas id="trendChart"></canvas>

    </div>

</div>

<div class="bottom-grid">

    <div class="panel">

        <h3>Janji Temu Terbaru</h3>

        <table>

            <tr>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Status</th>
            </tr>

            <?php while($r=$janjiTerbaru->fetch(PDO::FETCH_ASSOC)){ ?>

            <tr>

                <td><?= $r['nama_pasien']; ?></td>

                <td><?= $r['nama_dokter']; ?></td>

                <td>
                    <span class="badge <?= strtolower($r['status']) ?>">
                        <?= $r['status']; ?>
                    </span>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <div class="panel">

        <h3>Tagihan Terbaru</h3>

        <table>

            <tr>
                <th>Pasien</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <?php while($r=$tagihanTerbaru->fetch(PDO::FETCH_ASSOC)){ ?>

            <tr>

                <td><?= $r['nama_pasien']; ?></td>

                <td>
                    Rp <?= number_format($r['total_biaya'],0,',','.') ?>
                </td>

                <td>
                    <span class="badge bayar">
                        <?= $r['status_pembayaran']; ?>
                    </span>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>
</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const statusChart = document.getElementById('statusChart');

new Chart(statusChart,{

type:'doughnut',

data:{
    labels: <?= json_encode($statusLabel) ?>,
    datasets:[{
        data: <?= json_encode($statusData) ?>,
        backgroundColor:[
            '#14B8A6',
            '#3B82F6',
            '#F59E0B',
            '#EF4444',
            '#8B5CF6'
        ]
    }]
},

options:{

    responsive:true,

    maintainAspectRatio:true,

    aspectRatio:1,

    plugins:{
        legend:{
            position:'bottom'
        }
    }

}

});
const trendChart = document.getElementById('trendChart');

new Chart(trendChart, {

    type: 'line',

    data: {

        labels: <?= json_encode($tanggal) ?>,

        datasets: [{

            label: 'Janji Temu',

            data: <?= json_encode($totalJanji) ?>,

            borderColor: '#14B8A6',

            backgroundColor: 'rgba(20,184,166,.15)',

            fill: true,

            tension: .4

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});

</script>

<script>

const sidebar=document.querySelector(".sidebar");

const toggle=document.getElementById("toggleSidebar");

toggle.addEventListener("click", function(){

    sidebar.classList.toggle("minimize");

});
</script>

</body>

</html>