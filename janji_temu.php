<?php
include 'auth_admin.php';
include 'config.php';

$cari = $_GET['cari'] ?? '';

$sql = "
SELECT
j.id_janji_temu,
p.nama_pasien,
d.nama_dokter,
j.tanggal_janji,
j.keluhan,
j.status
FROM janji_temu j
JOIN pasien p ON j.id_pasien = p.id_pasien
JOIN dokter d ON j.id_dokter = d.id_dokter
";

if($cari != ''){
    $sql .= "
    WHERE
    LOWER(p.nama_pasien) LIKE LOWER(?)
    OR LOWER(d.nama_dokter) LIKE LOWER(?)
    ";
}

$sql .= " ORDER BY j.id_janji_temu ASC";

$query = $conn->prepare($sql);

if($cari != ''){
    $query->execute([
        "%$cari%",
        "%$cari%"
    ]);
}
else{
    $query->execute();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Data Janji Temu</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

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
min-height:100vh;
}

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

.main{
flex:1;
display:flex;
flex-direction:column;
}

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
}

.content{
padding:30px;
}

table{

width:100%;

border-collapse:collapse;

background:white;

border-radius:18px;

overflow:hidden;

box-shadow:0 8px 25px rgba(0,0,0,.05);

}

th{

background:#14b8a6;

color:white;

padding:15px;

font-size:14px;

}

td{

padding:15px;

font-size:14px;

text-align:center;

border-bottom:1px solid #eee;

}

tr:hover{

background:#f9fafb;

}

.status-menunggu{

background:#FEF3C7;

color:#B45309;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.status-diproses{

background:#DBEAFE;

color:#1D4ED8;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.status-selesai{

background:#DCFCE7;

color:#15803D;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.top{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}

.search input{

width:320px;

padding:12px;

border:1px solid #e5e7eb;

border-radius:12px;

outline:none;

}

.btn{

background:#14b8a6;

color:white;

padding:13px 20px;

text-decoration:none;

border-radius:12px;

box-shadow:0 8px 18px rgba(20,184,166,.25);

}

.btn:hover{

background:#0f9f90;

}
.action{
display:flex;
justify-content:center;
gap:10px;
}

.btn-edit,
.btn-delete{

width:38px;
height:38px;

display:flex;
align-items:center;
justify-content:center;

border-radius:8px;
text-decoration:none;
color:white;

}

.btn-edit{
background:#3b82f6;
}

.btn-delete{
background:#ef4444;
}

.action a:hover{

color:#14b8a6;

}

.pagination{

display:flex;

justify-content:center;

gap:10px;

margin-top:25px;

}

.page{

width:38px;

height:38px;

border:1px solid #e5e7eb;

display:flex;

justify-content:center;

align-items:center;

border-radius:10px;

background:white;

cursor:pointer;

}

.page.active{

background:#14b8a6;

color:white;

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

.sidebar{

    width:270px;
    min-width:270px;

    transition:
    width .35s ease,
    min-width .35s ease;

    overflow:hidden;

}

.sidebar.minimize{

    width:90px;
    min-width:90px;

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

}

.sidebar.minimize .menu-title{

    display:none;

}

.sidebar.minimize .menu a{

    justify-content:center;
    gap:0;

}

.sidebar.minimize .menu a span{

    display:none;

}

</style>

</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

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

<a href="index.php">
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

<a class="active" href="janji_temu.php">
    <i class="fa-solid fa-calendar-check"></i>
    <span>Janji Temu</span>
</a>

<a href="tagihan.php">
    <i class="fa-solid fa-file-invoice-dollar"></i>
    <span>Tagihan</span>
</a>

</div>

</div>

<div class="main">

<div class="header">

<div class="header-left">

<div style="display:flex;align-items:center;gap:18px;">

<div id="toggleSidebar"
style="
width:42px;
height:42px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
background:#f3f4f6;
cursor:pointer;
">

<i class="fa-solid fa-bars"></i>

</div>

<div>

<h2>Data Janji Temu</h2>

<p>Sistem Informasi Klinik Klunuk</p>

</div>

</div>

</div>

<div style="font-size:14px;color:#6b7280;">
Versi 1.0.0
</div>

</div>

<div class="content">

<div class="top">

<form method="GET" class="search">

<input
type="text"
name="cari"
placeholder="Cari pasien atau dokter..."
value="<?= htmlspecialchars($cari) ?>">

</form>

<a href="tambah_janji.php" class="btn">

<i class="fa-solid fa-plus"></i>

Tambah Janji Temu

</a>

</div>

<table>

<tr>

<th>ID Janji Temu</th>
<th>Pasien</th>
<th>Dokter</th>
<th>Tanggal Janji</th>
<th>Keluhan</th>
<th>Status</th>
<th>Aksi</th>

</tr>

<?php while($row = $query->fetch(PDO::FETCH_ASSOC)){ ?>

<tr>

<td><?= $row['id_janji_temu'] ?></td>

<td><?= htmlspecialchars($row['nama_pasien']) ?></td>

<td><?= htmlspecialchars($row['nama_dokter']) ?></td>

<td><?= date('d/m/Y H:i',strtotime($row['tanggal_janji'])) ?></td>

<td><?= htmlspecialchars($row['keluhan']) ?></td>

<td>

<?php

if($row['status']=="Menunggu"){

echo "<span class='status-menunggu'>Menunggu</span>";

}
elseif($row['status']=="Diproses"){

echo "<span class='status-diproses'>Diproses</span>";

}
else{

echo "<span class='status-selesai'>Selesai</span>";

}

?>

<td>

<div class="action">

<a
href="edit_janji.php?id=<?= $row['id_janji_temu'] ?>"
class="btn-edit">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="hapus_janji.php?id=<?= $row['id_janji_temu'] ?>"
class="btn-delete"
onclick="return confirm('Yakin ingin menghapus data ini?')">

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php } ?>

</table>

<div class="pagination">

<div class="page">
<i class="fa-solid fa-angle-left"></i>
</div>

<div class="page active">1</div>

<div class="page">2</div>

<div class="page">3</div>

<div class="page">4</div>

<div class="page">5</div>

<div class="page">
<i class="fa-solid fa-angle-right"></i>
</div>

</div>

</div> <!-- content -->

</div> <!-- main -->

</div> <!-- wrapper -->

<script>

const sidebar = document.getElementById("sidebar");
const toggleSidebar = document.getElementById("toggleSidebar");

toggleSidebar.addEventListener("click", function () {

    sidebar.classList.toggle("minimize");

});

</script>

</body>

</html>