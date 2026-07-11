<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$query = $conn->prepare("SELECT * FROM dokter WHERE id_dokter=?");
$query->execute([$id]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data dokter tidak ditemukan.");
}

if(isset($_POST['update'])){

    $sql = "UPDATE dokter SET
            nama_dokter=?,
            spesialisasi=?,
            nomor_telepon=?
            WHERE id_dokter=?";

    $update = $conn->prepare($sql);

    $update->execute([
        $_POST['nama_dokter'],
        $_POST['spesialisasi'],
        $_POST['nomor_telepon'],
        $id
    ]);
echo "
<script>
alert('Data dokter berhasil diperbarui');
window.location='dokter.php';
</script>
";
exit;
    header("Location: dokter.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Edit Dokter</title>

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
    width:600px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

h2{
    color:#0f766e;
    text-align:center;
    margin-bottom:25px;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
}

input{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
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
    font-size:15px;
}

.button a:hover,
.button button:hover{
    background:#0f766e;
}

</style>

</head>

<body>

<div class="container">

<h2>Edit Data Dokter</h2>

<form method="POST">

<label>Nama Dokter</label>

<input
type="text"
name="nama_dokter"
value="<?= htmlspecialchars($data['nama_dokter']) ?>"
required>

<label>Spesialisasi</label>

<input
type="text"
name="spesialisasi"
value="<?= htmlspecialchars($data['spesialisasi']) ?>"
required>

<label>Nomor Telepon</label>

<input
    type="text"
    name="nomor_telepon"
    id="nomor_telepon"
    required
>

<div class="button">

<a href="dokter.php">
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
<script>

document.querySelector("form").addEventListener("submit", function(e){

    const hp =
    document.getElementById("nomor_telepon").value;

    if(!/^[0-9]+$/.test(hp)){

        alert("Nomor telepon hanya boleh berisi angka");

        e.preventDefault();

    }

});

</script>
</body>
</html>