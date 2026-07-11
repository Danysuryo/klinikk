<?php
include 'auth_user.php';
include 'config.php';

/*
====================================
AMBIL DATA PASIEN LOGIN
====================================
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
====================================
AMBIL SPESIALISASI
====================================
*/

$spesialis = $conn->query("
SELECT DISTINCT spesialisasi
FROM dokter
ORDER BY spesialisasi
");

/*
====================================
AMBIL SELURUH DOKTER
====================================
*/

$dokter = $conn->query("
SELECT *
FROM dokter
ORDER BY nama_dokter
");

$dokterData = $dokter->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Buat Janji Temu</title>

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

width:850px;

margin:40px auto;

}

.card{

background:white;

padding:35px;

border-radius:18px;

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

label{

display:block;

margin-bottom:8px;

font-weight:600;

}

input,
select,
textarea{

width:100%;

padding:12px;

border:1px solid #d1d5db;

border-radius:10px;

font-size:15px;

}

textarea{

resize:none;

height:120px;

}

.button{

display:flex;

justify-content:space-between;

margin-top:30px;

}

.btn{

background:#14b8a6;

color:white;

border:none;

padding:12px 30px;

border-radius:10px;

cursor:pointer;

text-decoration:none;

}

.btn:hover{

background:#0f766e;

}

.back{

background:#6b7280;

}

.back:hover{

background:#4b5563;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<div class="title">

<h2>Buat Janji Temu</h2>

<p>

Silakan isi formulir berikut.

</p>

</div>

<form
action="proses_buat_janji.php"
method="POST">

<input
type="hidden"
name="id_pasien"
value="<?= $pasien['id_pasien']; ?>">

<div class="form-group">

<label>Nama Pasien</label>

<input
type="text"
value="<?= htmlspecialchars($pasien['nama_pasien']); ?>"
readonly>

</div>

<div class="form-group">

<label>Spesialisasi</label>

<select
id="spesialisasi"
required>

<option value="">-- Pilih Spesialisasi --</option>

<?php while($s = $spesialis->fetch(PDO::FETCH_ASSOC)){ ?>

<option
value="<?= htmlspecialchars($s['spesialisasi']) ?>">

<?= htmlspecialchars($s['spesialisasi']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Dokter</label>

<select
id="id_dokter"
name="id_dokter"
required>

<option value="">

-- Pilih Dokter --

</option>

</select>

</div>


<div class="form-group">

<label>Tanggal Janji</label>

<input
type="date"
name="tanggal_janji"
min="<?= date('Y-m-d'); ?>"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="form-group">

<label>Keluhan</label>

<textarea
name="keluhan"
required></textarea>

</div>

<div class="button">

<a
href="dashboard_user.php"
class="btn back">

Kembali

</a>

<button
class="btn"
type="submit">

Buat Janji

</button>

</div>

</form>

</div>

</div>

<script>

const semuaDokter = <?= json_encode($dokterData); ?>;

const spesialis = document.getElementById("spesialisasi");
const dokter = document.getElementById("id_dokter");

spesialis.addEventListener("change", function () {

    dokter.innerHTML = "";

    const optionAwal = document.createElement("option");
    optionAwal.value = "";
    optionAwal.textContent = "-- Pilih Dokter --";
    dokter.appendChild(optionAwal);

    semuaDokter.forEach(function(item){

        if(item.spesialisasi === spesialis.value){

            const option = document.createElement("option");
            option.value = item.id_dokter;
            option.textContent = item.nama_dokter;

            dokter.appendChild(option);

        }

    });

});

</script>

</body>

</html>