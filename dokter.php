<?php
include 'auth_admin.php';
include 'config.php';

$keyword = $_GET['keyword'] ?? '';

if($keyword != ''){

    $query = $conn->prepare("
        SELECT *
        FROM dokter
        WHERE LOWER(nama_dokter) LIKE LOWER(?)
        ORDER BY id_dokter ASC
    ");

    $query->execute(["%$keyword%"]);

}else{

    $query = $conn->query("
        SELECT *
        FROM dokter
        ORDER BY id_dokter ASC
    ");

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Dokter</title>

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

/* ======================
LAYOUT
====================== */

.wrapper{
    display:flex;
    min-height:100vh;
}

/* ======================
SIDEBAR
====================== */

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

/* ======================
MAIN
====================== */

.main{
    flex:1;
    display:flex;
    flex-direction:column;
}

/* ======================
HEADER
====================== */

.header{
    height:80px;
    background:white;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 35px;
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
    gap:15px;
}

.circle{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#f3f4f6;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
}

.circle:hover{
    background:#14b8a6;
    color:white;
}

/* ======================
CONTENT
====================== */

.content{
    padding:30px;
}

.page-title{
    font-size:28px;
    font-weight:600;
    color:#111827;
    margin-bottom:25px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.search-box{
    width:380px;
    position:relative;
}

.search-box i{
    position:absolute;
    left:15px;
    top:15px;
    color:#9ca3af;
}

.search-box input{
    width:100%;
    padding:12px 15px 12px 45px;
    border:1px solid #e5e7eb;
    border-radius:10px;
    outline:none;
}

.btn-add{
    background:#14b8a6;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:500;
}

.btn-add:hover{
    background:#0f766e;
}

/* ======================
CARD TABLE
====================== */

.card{
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#14b8a6;
    color:white;
    padding:15px;
    font-size:14px;
}

td{
    padding:15px;
    border-bottom:1px solid #e5e7eb;
}

tr:hover{
    background:#f8fafc;
}

.center{
    text-align:center;
}

/* ======================
AKSI
====================== */

.aksi{
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

    color:white;
    text-decoration:none;

    border-radius:8px;
}

.btn-edit{
    background:#3b82f6;
}

.btn-edit:hover{
    background:#2563eb;
}

.btn-delete{
    background:#ef4444;
}

.btn-delete:hover{
    background:#dc2626;
}

/* ======================
FOOTER TABLE
====================== */

.table-footer{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:#6b7280;
    font-size:14px;
}

.pagination{
    display:flex;
    gap:8px;
}

.page{
    width:35px;
    height:35px;
    display:flex;
    justify-content:center;
    align-items:center;
    border:1px solid #e5e7eb;
    border-radius:8px;
}

.active-page{
    background:#14b8a6;
    color:white;
    border:none;
}

.sidebar{
    width:270px;
    min-width:270px;
    transition:
    width .35s ease,
    min-width .35s ease;
    overflow:hidden;
}

.logo{
    transition:all .35s ease;
}

.sidebar.minimize{
    width:90px;
    min-width:90px;
}

.sidebar.minimize .logo{
    justify-content:center;
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
    gap:0;
}

.sidebar.minimize .menu a span{
    display:none;
}
</style>

</head>

<body>

<div class="wrapper">

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

<a href="dokter.php" class="active">
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

<h2>Data Dokter</h2>

<p>Sistem Informasi Klinik Klunuk</p>

</div>

</div>

</div>

<div style="font-size:14px;color:#6b7280;">
Versi 1.0.0
</div>

</div>

<div class="content">

<div class="page-title">
Data Dokter
</div>

<div class="top-bar">

<form method="GET">

<div class="search-box">

<i class="fa-solid fa-magnifying-glass"></i>

<input
type="text"
name="keyword"
placeholder="Cari dokter..."
value="<?= htmlspecialchars($keyword) ?>">

</div>

</form>

<a href="tambah_dokter.php" class="btn-add">

<i class="fa-solid fa-plus"></i>
Tambah Dokter

</a>

</div>

<div class="card">

<table>

<tr>

<th>ID Dokter</th>
<th>Nama Dokter</th>
<th>Spesialisasi</th>
<th>No. Telepon</th>
<th>Aksi</th>

</tr>

<?php
$total = 0;

while($data = $query->fetch(PDO::FETCH_ASSOC)){

$total++;
?>

<tr>

<td class="center">
D<?= str_pad($data['id_dokter'],3,'0',STR_PAD_LEFT) ?>
</td>

<td>
<?= htmlspecialchars($data['nama_dokter']) ?>
</td>

<td>
<?= htmlspecialchars($data['spesialisasi']) ?>
</td>

<td>
<?= htmlspecialchars($data['nomor_telepon']) ?>
</td>

<td>

<div class="aksi">

<a
href="edit_dokter.php?id=<?= $data['id_dokter'] ?>"
class="btn-edit">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="hapus_dokter.php?id=<?= $data['id_dokter'] ?>"
class="btn-delete"
onclick="return confirm('Yakin ingin menghapus data dokter ini?')">

<i class="fa-solid fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php } ?>

<?php if($total == 0){ ?>

<tr>

<td colspan="5" class="center">
Data dokter tidak ditemukan.
</td>

</tr>

<?php } ?>

</table>

<div class="table-footer">

<div>
Menampilkan <?= $total ?> data dokter
</div>

<div class="pagination">

<div class="page">
<
</div>

<div class="page active-page">
1
</div>

<div class="page">
>
</div>

</div>

</div>

</div>

</div>

</div>

</div>
<script>

const sidebar =
document.getElementById("sidebar");

const toggleSidebar =
document.getElementById("toggleSidebar");

toggleSidebar.addEventListener("click", function(){

    sidebar.classList.toggle("minimize");

});

</script>
</body>
</html>