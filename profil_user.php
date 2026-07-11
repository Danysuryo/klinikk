<?php
include 'auth_user.php';
include 'config.php';

/*
====================================
AMBIL DATA USER LOGIN
====================================
*/

$query = $conn->prepare("
SELECT
    u.id_user,
    u.username,
    p.*
FROM users u
JOIN pasien p
ON u.id_user = p.id_user
WHERE u.id_user = ?
");

$query->execute([
    $_SESSION['id_user']
]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if(!$data){

    die("Data pasien tidak ditemukan.");

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Profil Saya</title>

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

    width:900px;

    margin:40px auto;

}

.card{

    background:white;

    border-radius:18px;

    padding:35px;

    box-shadow:0 10px 25px rgba(0,0,0,.05);

}

.title{

    margin-bottom:30px;

}

.title h2{

    color:#111827;

}

.title p{

    color:#6b7280;

    margin-top:5px;

}

.form-group{

    margin-bottom:20px;

}

.form-group label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

    color:#374151;

}

.form-group input,

.form-group textarea,

.form-group select{

    width:100%;

    padding:12px 15px;

    border:1px solid #d1d5db;

    border-radius:10px;

    font-size:15px;

}

.form-group textarea{

    resize:none;

    height:100px;

}

.btn{

    background:#14b8a6;

    color:white;

    border:none;

    padding:12px 30px;

    border-radius:10px;

    cursor:pointer;

    font-size:15px;

}

.btn:hover{

    background:#0f9b8a;

}

.back{

    display:inline-block;

    margin-bottom:20px;

    text-decoration:none;

    color:#14b8a6;

    font-weight:600;

}
</style>

</head>

<body>

<div class="container">

<a href="dashboard_user.php" class="back">
    <i class="fa-solid fa-arrow-left"></i>
    Kembali ke Dashboard
</a>

<div class="card">

<div class="title">

<h2>Profil Saya</h2>

<p>
Silakan perbarui informasi pribadi Anda.
</p>

</div>

<form action="proses_update_profil.php" method="POST">

<input
type="hidden"
name="id_user"
value="<?= $data['id_user']; ?>">

<div class="form-group">

<label>Username</label>

<input
type="text"
value="<?= htmlspecialchars($data['username']); ?>"
readonly>

</div>

<div class="form-group">

<label>Nama Lengkap</label>

<input
type="text"
name="nama_pasien"
value="<?= htmlspecialchars($data['nama_pasien']); ?>"
required>

</div>

<div class="form-group">

<label>Tempat Lahir</label>

<input
type="text"
name="tempat_lahir"
value="<?= htmlspecialchars($data['tempat_lahir']); ?>"
required>

</div>

<div class="form-group">

<label>Tanggal Lahir</label>

<input
type="date"
name="tanggal_lahir"
value="<?= $data['tanggal_lahir']; ?>"
required>

</div>

<div class="form-group">

<label>Jenis Kelamin</label>

<select
name="jenis_kelamin"
required>

<option
value="Laki-laki"
<?= $data['jenis_kelamin']=="Laki-laki" ? "selected" : ""; ?>>

Laki-laki

</option>

<option
value="Perempuan"
<?= $data['jenis_kelamin']=="Perempuan" ? "selected" : ""; ?>>

Perempuan

</option>

</select>

</div>

<div class="form-group">

<label>Alamat</label>

<textarea
name="alamat"
required><?= htmlspecialchars($data['alamat']); ?></textarea>

</div>

<div class="form-group">

<label>Nomor Telepon</label>

<input
type="text"
name="nomor_telepon"
value="<?= htmlspecialchars($data['nomor_telepon']); ?>"
required>

</div>

<button
type="submit"
class="btn">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Perubahan

</button>

</form>

</div>

</div>

</body>

</html>