<?php
include 'auth_admin.php';
include 'config.php';

/* Ambil data pasien */
$pasien = $conn->query("
SELECT id_pasien,nama_pasien
FROM pasien
ORDER BY nama_pasien
");

/* Ambil data dokter */
$dokter = $conn->query("
SELECT id_dokter,nama_dokter
FROM dokter
ORDER BY nama_dokter
");

if(isset($_POST['simpan'])){

    $sql = "
    INSERT INTO janji_temu
    (
        id_pasien,
        id_dokter,
        tanggal_janji,
        keluhan,
        status
    )
    VALUES
    (
        ?,?,?,?,?
    )
    ";

    $query = $conn->prepare($sql);

    $query->execute([
        $_POST['id_pasien'],
        $_POST['id_dokter'],
        $_POST['tanggal_janji'],
        $_POST['keluhan'],
        $_POST['status']
    ]);
echo "
<script>
alert('Janji temu berhasil ditambahkan');
window.location='janji_temu.php';
</script>
";
exit;
    header("Location: janji_temu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Tambah Janji Temu</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#eef7f6;
}

.container{
    width:700px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#0f766e;
    margin-bottom:25px;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
}

input,
select,
textarea{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

textarea{
    resize:vertical;
}

.button{
    display:flex;
    justify-content:space-between;
    margin-top:25px;
}

.button a,
.button button{
    text-decoration:none;
    background:#14b8a6;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:8px;
    cursor:pointer;
}

.button a:hover,
.button button:hover{
    background:#0f766e;
}

</style>

</head>

<body>

<div class="container">

<h2>Tambah Janji Temu</h2>

<form method="POST">

<label>Pasien</label>

<select name="id_pasien" required>

<option value="">-- Pilih Pasien --</option>

<?php while($p = $pasien->fetch(PDO::FETCH_ASSOC)){ ?>

<option value="<?= $p['id_pasien'] ?>">
    <?= htmlspecialchars($p['nama_pasien']) ?>
</option>

<?php } ?>

</select>

<label>Dokter</label>

<select name="id_dokter" required>

<option value="">-- Pilih Dokter --</option>

<?php while($d = $dokter->fetch(PDO::FETCH_ASSOC)){ ?>

<option value="<?= $d['id_dokter'] ?>">
    <?= htmlspecialchars($d['nama_dokter']) ?>
</option>

<?php } ?>

</select>

<label>Tanggal Janji</label>

<input
type="date"
name="tanggal_janji"
required>

<label>Keluhan</label>

<textarea
name="keluhan"
rows="4"
required></textarea>

<label>Status</label>

<select name="status">

<option value="Menunggu">Menunggu</option>
<option value="Diproses">Diproses</option>
<option value="Selesai">Selesai</option>

</select>

<div class="button">

<a href="janji_temu.php">
Kembali
</a>

<button
type="submit"
name="simpan">
Simpan
</button>

</div>

</form>

</div>

</body>
</html>