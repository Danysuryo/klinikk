    <?php
    include 'auth_admin.php';
    include 'config.php';

    $keyword = $_GET['keyword'] ?? '';

    if($keyword != ''){

        $query = $conn->prepare("
            SELECT *
            FROM pasien
            WHERE LOWER(nama_pasien) LIKE LOWER(?)
            ORDER BY id_pasien ASC
        ");

        $query->execute(["%$keyword%"]);

    }else{

        $query = $conn->query("
            SELECT *
            FROM pasien
            ORDER BY id_pasien ASC
        ");

    }
    ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Data Pasien</title>

    <link rel="preconnect"
    href="https://fonts.googleapis.com">

    <link rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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

    background:#F3F7FA;
    overflow-x:hidden;

    }

    .wrapper{

    display:flex;

    width:100%;

    min-height:100vh;

    overflow:hidden;

    }

    /* =========================
    SIDEBAR
    ========================= */

    .sidebar{

    width:270px;

    min-width:270px;

    background:#FFFFFF;

    border-right:1px solid #E5E7EB;

    display:flex;

    flex-direction:column;

    transition:.35s;

    overflow:hidden;

    }

    .logo{

    display:flex;

    align-items:center;

    gap:15px;

    padding:22px;

    min-height:105px;

    border-bottom:1px solid #E5E7EB;

    transition:.35s;

    }

    .logo-icon{

    width:60px;

    height:60px;

    border-radius:15px;

    background:#14B8A6;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;

    color:white;

    box-shadow:0 8px 20px rgba(20,184,166,.25);

    }

    .logo-text{

    white-space:nowrap;

    transition:.35s;

    }

    .logo-text h2{

    font-size:18px;

    color:#111827;

    }

    .logo-text p{

    font-size:13px;

    margin-top:3px;

    color:#6B7280;

    }

    /* =========================
    MENU
    ========================= */

    .menu{

    padding:20px 15px;

    }

    .menu-title{

    font-size:12px;

    font-weight:600;

    color:#9CA3AF;

    letter-spacing:1px;

    padding:0 15px 10px;

    text-transform:uppercase;

    }

    .menu a{

    display:flex;

    align-items:center;

    gap:15px;

    padding:14px 16px;

    margin-bottom:8px;

    border-radius:12px;

    text-decoration:none;

    color:#374151;

    transition:.3s;

    }

    .menu a:hover{

    background:#E6FFFB;

    color:#14B8A6;

    }

    .menu a.active{

    background:#14B8A6;

    color:white;

    box-shadow:0 8px 18px rgba(20,184,166,.25);

    }

    .menu a i{

    width:24px;

    font-size:18px;

    text-align:center;

    }

    /* =========================
    MAIN
    ========================= */

    .main{

    flex:1;

    display:flex;

    flex-direction:column;

    overflow:hidden;

    }

    /* =========================
    HEADER
    ========================= */

    .header{

    height:80px;

    background:#FFFFFF;

    border-bottom:1px solid #E5E7EB;

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

    margin-top:3px;

    color:#6B7280;

    }

    /* =========================
    CONTENT
    ========================= */

    .content{

    padding:30px;

    flex:1;

    }

    .page-card{

    background:white;

    border-radius:20px;

    padding:35px;

    box-shadow:0 8px 25px rgba(0,0,0,.05);

    }

    .page-title{

    font-size:34px;

    font-weight:700;

    color:#111827;

    margin-bottom:30px;

    }

    /* =========================
    TOOLBAR
    ========================= */

    .toolbar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    }

    .search-box{

    width:360px;

    }

    .search-box input{

    width:100%;

    padding:13px 16px;

    border:1px solid #D1D5DB;

    border-radius:10px;

    font-size:14px;

    outline:none;

    transition:.3s;

    }

    .search-box input:focus{

    border-color:#14B8A6;

    }

    .button-group{

    display:flex;

    gap:12px;

    }

    .btn{

    padding:12px 20px;

    border-radius:10px;

    text-decoration:none;

    font-size:14px;

    font-weight:500;

    transition:.3s;

    }

    .btn-reset{

    background:#E5E7EB;

    color:#374151;

    }

    .btn-primary{

    background:#14B8A6;

    color:white;

    }

    .btn-primary:hover{

    background:#0F766E;

    }

    /* =========================
    TABLE
    ========================= */

    .table-container{

    overflow-x:auto;

    }

    table{

    width:100%;

    border-collapse:collapse;

    }

    th{

    background:#F9FAFB;

    padding:15px;

    border:1px solid #E5E7EB;

    font-size:14px;

    }

    td{

    padding:15px;

    border:1px solid #E5E7EB;

    text-align:center;

    font-size:14px;

    }

    tr:hover{

    background:#F9FAFB;

    }

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
        justify-content:center;
        align-items:center;

        border-radius:8px;

        color:white;
        text-decoration:none;

        transition:.25s;
    }

    .btn-edit{
        background:#3B82F6;
    }

    .btn-edit:hover{
        background:#2563EB;
    }

    .btn-delete{
        background:#EF4444;
    }

    .btn-delete:hover{
        background:#DC2626;
    }
    .info{

    margin-top:20px;

    display:flex;

    justify-content:space-between;

    font-size:14px;

    color:#6B7280;

    }

    /* =========================
    FOOTER
    ========================= */

    .footer{

    height:55px;

    background:white;

    border-top:1px solid #E5E7EB;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:13px;

    color:#6B7280;

    }

    /* =========================
    SIDEBAR COLLAPSE
    ========================= */

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

    width:0;

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

    <!-- =========================
    SIDEBAR
    ========================= -->

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

            <a href="pasien.php" class="active">
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

    </div>

    <!-- =========================
    MAIN
    ========================= -->

    <div class="main">

    <!-- HEADER -->

    <div class="header">

        <div class="header-left">

            <div style="display:flex;align-items:center;gap:18px;">

                <div id="toggleSidebar"
                style="
                width:42px;
                height:42px;
                border-radius:10px;
                background:#F3F4F6;
                display:flex;
                justify-content:center;
                align-items:center;
                cursor:pointer;
                ">

                    <i class="fa-solid fa-bars"></i>

                </div>

                <div>

                    <h2>Data Pasien</h2>

                    <p>Sistem Informasi Klinik Klunuk</p>

                </div>

            </div>

        </div>

        <div style="font-size:14px;color:#6B7280;">

            Versi 1.0.0

        </div>

    </div>

    <!-- CONTENT -->

    <div class="content">

    <div class="page-card">

    <h2 class="page-title">

    Data Pasien

    </h2>

    <div class="toolbar">

    <form method="GET" class="search-box">

    <input
    type="text"
    name="keyword"
    placeholder="Cari nama pasien..."
    value="<?= htmlspecialchars($keyword) ?>">

    </form>

    <div class="button-group">

    <a href="pasien.php"
    class="btn btn-reset">

    Reset

    </a>

    <a href="tambah_pasien.php"
    class="btn btn-primary">

    <i class="fa-solid fa-plus"></i>

    &nbsp;

    Tambah Pasien

    </a>

    </div>

    </div>

    <div class="table-container">

    <table>

    <thead>

    <tr>

    <th>ID</th>

    <th>Nama Pasien</th>

    <th>Tempat Lahir</th>

    <th>Tanggal Lahir</th>

    <th>Jenis Kelamin</th>

    <th>No. Telepon</th>

    <th width="110">
    Aksi
    </th>

    </tr>

    </thead>

    <tbody>

    <?php

    $total=0;

    while($data=$query->fetch(PDO::FETCH_ASSOC)){

    $total++;

    ?>

    <tr>

    <td><?= $data['id_pasien']; ?></td>

    <td><?= htmlspecialchars($data['nama_pasien']); ?></td>

    <td><?= htmlspecialchars($data['tempat_lahir']); ?></td>

    <td><?= $data['tanggal_lahir']; ?></td>

    <td><?= htmlspecialchars($data['jenis_kelamin']); ?></td>

    <td><?= htmlspecialchars($data['nomor_telepon']); ?></td>

    <td>

    <div class="aksi">

    <a
    href="edit_pasien.php?id=<?= $data['id_pasien'] ?>"
    class="btn-edit">

    <i class="fa-solid fa-pen"></i>

    </a>

   <a
href="#"
class="btn-delete"
data-id="<?= $data['id_pasien'] ?>">

<i class="fa-solid fa-trash"></i>

</a>

    </div>

    </td>

    </tr>

    <?php } ?>

    </tbody>

    </table>

    </div>

    <div class="info">

    <div>

    Menampilkan

    <b><?= $total ?></b>

    data pasien

    </div>

    <div>

    Data diperbarui secara realtime

    </div>

    </div>

    </div>
    </div>

    <!-- FOOTER -->

    <div class="footer">

    © 2026 Sistem Informasi Klinik Klunuk

    </div>

    </div>

    </div>

    <script>

    const sidebar = document.getElementById("sidebar");

    const toggleSidebar = document.getElementById("toggleSidebar");

    toggleSidebar.addEventListener("click", function(){

        sidebar.classList.toggle("minimize");

    });
   

    fetch("api/pasien_get.php")

    .then(response=>response.json())

    .then(data=>{

        console.log(data);

    });
   
    

document.querySelectorAll(".btn-delete").forEach(function(button){

    button.addEventListener("click",function(e){

        e.preventDefault();

        if(!confirm("Yakin ingin menghapus data pasien?")){

            return;

        }

        const id = this.dataset.id;

        const formData = new FormData();

        formData.append("id_pasien",id);

        fetch("api/pasien_delete.php",{

            method:"POST",

            body:formData

        })

        .then(response=>response.json())

        .then(data=>{

            alert(data.message);

            if(data.success){

                location.reload();

            }

        })

        .catch(error=>{

            console.log(error);

            alert("Terjadi kesalahan.");

        });

    });

});

</script>
    </body>
    </html>