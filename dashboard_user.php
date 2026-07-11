<?php
session_start();

if (
    !isset($_SESSION['id_user']) ||
    $_SESSION['role'] != 'user'
) {
    header("Location: login.php");
    exit;
}
include 'auth_user.php';
include "config.php";

/*
====================================
AMBIL DATA PASIEN YANG LOGIN
====================================
*/

$query = $conn->prepare("
SELECT *
FROM pasien
WHERE id_user = ?
");

$query->execute([
    $_SESSION['id_user']
]);

$pasien = $query->fetch(PDO::FETCH_ASSOC);

if (!$pasien) {
    die("Data pasien tidak ditemukan.");
}

/*
====================================
STATISTIK USER
====================================
*/

$query = $conn->prepare("
SELECT COUNT(*)
FROM janji_temu
WHERE id_pasien=?
");

$query->execute([
    $pasien['id_pasien']
]);

$jumlahJanji = $query->fetchColumn();

$query = $conn->prepare("
SELECT COUNT(*)
FROM tagihan t
INNER JOIN janji_temu j
ON t.id_janji_temu=j.id_janji_temu
WHERE j.id_pasien=?
");

$query->execute([
    $pasien['id_pasien']
]);

$jumlahTagihan = $query->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Dashboard Pasien</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* =====================================================
RESET
===================================================== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f3f7fa;
}

/* =====================================================
WRAPPER
===================================================== */

.wrapper{

    display:flex;

    width:100%;

    min-height:100vh;

    overflow:hidden;

}

/* =====================================================
SIDEBAR
===================================================== */

.sidebar{

    width:270px;

    min-width:270px;

    height:100vh;

    background:#fff;

    border-right:1px solid #e5e7eb;

    display:flex;

    flex-direction:column;

    overflow:hidden;

    transition:
        width .35s ease,
        min-width .35s ease;

}

/* =====================================================
LOGO
===================================================== */

.logo{

    display:flex;

    align-items:center;

    gap:15px;

    padding:22px;

    min-height:105px;

    border-bottom:1px solid #e5e7eb;

    flex-shrink:0;

    transition:.35s;

}

.logo-icon{

    width:60px;

    height:60px;

    border-radius:15px;

    background:#14b8a6;

    display:flex;

    justify-content:center;

    align-items:center;

    color:white;

    font-size:28px;

    box-shadow:0 8px 20px rgba(20,184,166,.25);

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

    font-size:18px;

    color:#111827;

    margin:0;

}

.logo-text p{

    margin-top:3px;

    color:#6b7280;

    font-size:13px;

}

/* =====================================================
MENU
===================================================== */

.menu{

    flex:1;

    padding:20px 15px;

    overflow-y:auto;

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

    transition:.3s;

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

/* =====================================================
LOGOUT
===================================================== */

.logout{

    margin-top:auto;

    padding:20px;

    border-top:1px solid #e5e7eb;

    background:white;

}

.logout a{

    display:flex;

    align-items:center;

    gap:15px;

    text-decoration:none;

    color:#ef4444;

    padding:14px 16px;

    border-radius:12px;

    transition:.3s;

    font-weight:600;

}

.logout a:hover{

    background:#fee2e2;

}

.sidebar.minimize .logout{

    display:flex;

    justify-content:center;

    padding:18px 0;

    display:none;


}

/* =====================================================
MAIN
===================================================== */

.main{

    flex:1;

    display:flex;

    flex-direction:column;

    width:100%;

    overflow:hidden;

    transition:.35s;

}

/* =====================================================
HEADER
===================================================== */

.header{

    height:80px;

    background:white;

    display:flex;

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

/* =====================================================
CONTENT
===================================================== */

.content{

    flex:1;

    padding:30px;

    width:100%;

    overflow-x:hidden;

}

/* =====================================================
WELCOME
===================================================== */

.welcome{

    background:white;

    border-radius:20px;

    padding:35px;

    margin-bottom:25px;

    box-shadow:0 10px 30px rgba(0,0,0,.05);

}

.welcome h1{

    font-size:28px;

    color:#111827;

    margin-bottom:10px;

}

.welcome p{

    color:#6b7280;

    font-size:15px;

    line-height:28px;

}

/* =====================================================
STATISTIC
===================================================== */

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

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:0 10px 25px rgba(0,0,0,.05);

    transition:.3s;

    min-height:140px;

}

.stat-card:hover{

    transform:translateY(-5px);

}

.stat-info{

    flex:1;

    min-width:0;

}

.stat-info h4{

    font-size:14px;

    color:#6b7280;

    margin-bottom:8px;

}

.stat-info h2{

    font-size:18px;

    color:#111827;

    font-weight:600;

    line-height:28px;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}

.stat-info p{

    margin-top:6px;

    font-size:12px;

    color:#9ca3af;

}

.stat-icon{

    width:55px;

    height:55px;

    border-radius:15px;

    display:flex;

    justify-content:center;

    align-items:center;

    color:white;

    font-size:22px;

}

.pasien{

    background:#3B82F6;

}

.telepon{

    background:#14B8A6;

}

.janji{

    background:#F59E0B;

}

.tagihan{

    background:#8B5CF6;

}

/* =====================================================
QUICK MENU
===================================================== */

.quick-title{

    font-size:22px;

    font-weight:600;

    color:#111827;

    margin-bottom:20px;

}

.quick-menu{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;

    margin-bottom:30px;

}

.quick-card{

    background:white;

    border-radius:18px;

    padding:25px;

    text-align:center;

    text-decoration:none;

    color:#374151;

    box-shadow:0 10px 25px rgba(0,0,0,.05);

    transition:.3s;

}

.quick-card:hover{

    transform:translateY(-6px);

    box-shadow:0 15px 35px rgba(0,0,0,.08);

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

    line-height:22px;

}

/* =====================================================
SIDEBAR COLLAPSE
===================================================== */

.sidebar.minimize{

    width:90px;

    min-width:90px;

}

.sidebar.minimize + .main{

    width:calc(100% - 90px);

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

.sidebar.minimize .menu-title{

    display:none;

}

.sidebar.minimize .menu a{

    justify-content:center;

    padding:16px 0;

    gap:0;

}

.sidebar.minimize .menu a span{

    opacity:0;

    visibility:hidden;

    width:0;

    margin:0;

    overflow:hidden;

}

.sidebar.minimize .menu a i{

    margin:0;

    font-size:22px;

}

.sidebar.minimize .menu a:hover{

    margin:0 10px;

    border-radius:12px;

}

/* =====================================================
ANIMATION
===================================================== */

.stat-card,
.quick-card,
.welcome{

    animation:fadeUp .45s ease;

}

@keyframes fadeUp{

    from{

        opacity:0;

        transform:translateY(20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}

/* =====================================================
RESPONSIVE
===================================================== */

@media(max-width:1200px){

    .stats{

        grid-template-columns:repeat(2,1fr);

    }

    .quick-menu{

        grid-template-columns:repeat(2,1fr);

    }

}

@media(max-width:992px){

    .header{

        padding:20px;

    }

    .content{

        padding:20px;

    }

}

@media(max-width:768px){

    .wrapper{

        flex-direction:column;

    }

    .sidebar{

        width:100%;

        min-width:100%;

        height:auto;

    }

    .stats{

        grid-template-columns:1fr;

    }

    .quick-menu{

        grid-template-columns:1fr;

    }

}

@media(max-width:576px){

    .welcome{

        padding:25px;

    }

    .welcome h1{

        font-size:22px;

    }

    .stat-info h2{

        font-size:20px;

    }

}

</style>

</head>

<body>

<div class="wrapper">

    <!-- =========================
         SIDEBAR
    ========================== -->

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

            <a href="dashboard_user.php" class="active">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>

            <a href="profil_user.php">

                <i class="fa-solid fa-user"></i>

                <span>Profil Saya</span>

            </a>

            <a href="buat_janji.php">

                <i class="fa-solid fa-calendar-plus"></i>

                <span>Buat Janji</span>

            </a>

            <a href="janji_saya.php">

                <i class="fa-solid fa-calendar-check"></i>

                <span>Janji Saya</span>

            </a>

            <a href="tagihan_saya.php">

                <i class="fa-solid fa-file-invoice-dollar"></i>

                <span>Tagihan Saya</span>

            </a>

        </div>

        <div class="logout">

            <a href="logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </a>

        </div>

    </div>

    <!-- =========================
         MAIN
    ========================== -->

    <div class="main">

        <div class="header">

            <div class="header-left">

                <div
                style="
                display:flex;
                align-items:center;
                gap:18px;
                ">

                    <div
                    id="toggleSidebar"
                    style="
                    width:42px;
                    height:42px;
                    border-radius:10px;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    background:#f3f4f6;
                    cursor:pointer;
                    font-size:20px;
                    ">

                        <i class="fa-solid fa-bars"></i>

                    </div>

                    <div>

                        <h2>

                            Dashboard Pasien

                        </h2>

                        <p>

                            Sistem Informasi Klinik Klunuk

                        </p>

                    </div>

                </div>

            </div>

           

        </div>

        <!-- =========================
             CONTENT
        ========================== -->

        <div class="content">

            <div class="welcome">

                <h1>

                    Selamat Datang,
                    <?= htmlspecialchars($pasien['nama_pasien']); ?>

                </h1>

                <p>

                    Selamat datang di Sistem Informasi Klinik Klunuk.

                    Melalui dashboard ini Anda dapat melihat data pribadi,
                    membuat janji temu,
                    melihat riwayat konsultasi,
                    serta melihat tagihan Anda.

                </p>

            </div>

            <!-- =========================
                 STATISTIK
            ========================== -->

            <div class="stats">

                <div class="stat-card">

                    <div class="stat-info">

                        <h4>Nama Pasien</h4>

                        <h2>

                            <?= htmlspecialchars($pasien['nama_pasien']); ?>

                        </h2>

                        <p>Data Profil</p>

                    </div>

                    <div class="stat-icon pasien">

                        <i class="fa-solid fa-user"></i>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="stat-info">

                        <h4>Nomor Telepon</h4>

                        <h2 style="font-size:16px;">

                        <?= htmlspecialchars($pasien['nomor_telepon']); ?>

                        </h2>

                        <p>Kontak</p>

                    </div>

                    <div class="stat-icon telepon">

                        <i class="fa-solid fa-phone"></i>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="stat-info">

                        <h4>Total Janji</h4>

                        <h2>

                            <?= $jumlahJanji; ?>

                        </h2>

                        <p>Janji Temu</p>

                    </div>

                    <div class="stat-icon janji">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                </div>

                <div class="stat-card">

                    <div class="stat-info">

                        <h4>Total Tagihan</h4>

                        <h2>

                            <?= $jumlahTagihan; ?>

                        </h2>

                        <p>Tagihan</p>

                    </div>

                    <div class="stat-icon tagihan">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                    </div>

                </div>

            </div>

            <!-- =========================
                 QUICK MENU
            ========================== -->

            <h2 class="quick-title">

                Menu Cepat

            </h2>

            <div class="quick-menu">

                <a href="profil_user.php" class="quick-card">

                    <i class="fa-solid fa-user"></i>

                    <h3>Profil Saya</h3>

                    <p>Lihat dan ubah data pribadi.</p>

                </a>

                <a href="buat_janji.php" class="quick-card">

                    <i class="fa-solid fa-calendar-plus"></i>

                    <h3>Buat Janji</h3>

                    <p>Buat jadwal konsultasi baru.</p>

                </a>

                <a href="janji_saya.php" class="quick-card">

                    <i class="fa-solid fa-calendar-check"></i>

                    <h3>Janji Saya</h3>

                    <p>Lihat seluruh riwayat janji temu.</p>

                </a>

                <a href="tagihan_saya.php" class="quick-card">

                    <i class="fa-solid fa-file-invoice-dollar"></i>

                    <h3>Tagihan Saya</h3>

                    <p>Lihat seluruh tagihan.</p>

                </a>

            </div>

        </div>

    </div>

</div>

<script>

const sidebar = document.querySelector(".sidebar");

const toggle = document.getElementById("toggleSidebar");

toggle.addEventListener("click",function(){

    sidebar.classList.toggle("minimize");

});

</script>

</body>

</html>