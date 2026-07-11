<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

/* Ambil data janji */
$query = $conn->prepare("
SELECT *
FROM janji_temu
WHERE id_janji_temu = ?
");

$query->execute([$id]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if(!$data){
    die("Data tidak ditemukan.");
}

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

if(isset($_POST['update'])){

    $sql = "
    UPDATE janji_temu
    SET
        id_pasien=?,
        id_dokter=?,
        tanggal_janji=?,
        keluhan=?,
        status=?
    WHERE id_janji_temu=?
    ";

    $update = $conn->prepare($sql);

    $update->execute([
        $_POST['id_pasien'],
        $_POST['id_dokter'],
        $_POST['tanggal_janji'],
        $_POST['keluhan'],
        $_POST['status'],
        $id
    ]);
echo "
<script>
alert('Janji temu berhasil diperbarui');
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
<title>Edit Janji Temu</title>

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

<h2>Edit Janji Temu</h2>

<form method="POST">

<label>Pasien</label>

<select name="id_pasien" required>

<?php while($p = $pasien->fetch(PDO::FETCH_ASSOC)){ ?>

<option
value="<?= $p['id_pasien'] ?>"
<?= ($p['id_pasien'] == $data['id_pasien']) ? 'selected' : '' ?>>

<?= htmlspecialchars($p['nama_pasien']) ?>

</option>

<?php } ?>

</select>

<label>Dokter</label>

<select name="id_dokter" required>

<?php while($d = $dokter->fetch(PDO::FETCH_ASSOC)){ ?>

<option
value="<?= $d['id_dokter'] ?>"
<?= ($d['id_dokter'] == $data['id_dokter']) ? 'selected' : '' ?>>

<?= htmlspecialchars($d['nama_dokter']) ?>

</option>

<?php } ?>

</select>

<label>Tanggal Janji</label>

<input
type="date"
name="tanggal_janji"
value="<?= $data['tanggal_janji'] ?>"
required>

<label>Keluhan</label>

<textarea
name="keluhan"
rows="4"
required><?= htmlspecialchars($data['keluhan']) ?></textarea>

<label>Status</label>

<select name="status">

<option value="Menunggu"
<?= $data['status']=='Menunggu' ? 'selected' : '' ?>>
Menunggu
</option>

<option value="Diproses"
<?= $data['status']=='Diproses' ? 'selected' : '' ?>>
Diproses
</option>

<option value="Selesai"
<?= $data['status']=='Selesai' ? 'selected' : '' ?>>
Selesai
</option>

</select>

<div class="button">

<a href="janji_temu.php">
Batal
</a>

<button
type="submit"
name="update">
Update
</button>

</div>

</form>

</div>

</body>
</html>