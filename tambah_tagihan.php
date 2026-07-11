<?php
include 'auth_admin.php';
include 'config.php';

$janji = $conn->query("
SELECT
    j.id_janji_temu,
    p.nama_pasien,
    d.nama_dokter,
    j.tanggal_janji
FROM janji_temu j
JOIN pasien p ON j.id_pasien = p.id_pasien
JOIN dokter d ON j.id_dokter = d.id_dokter
WHERE j.id_janji_temu NOT IN (
    SELECT id_janji_temu FROM tagihan
)
ORDER BY j.id_janji_temu ASC
");

if(isset($_POST['simpan'])){
$total_biaya = $_POST['total_biaya'];

    $query = $conn->prepare("
    INSERT INTO tagihan
    (
        id_janji_temu,
        total_biaya,
        status_pembayaran
    )
    VALUES
    (
        ?,
        ?,
        ?
    )
    ");

    $query->execute([
        $_POST['id_janji_temu'],
        $_POST['total_biaya'],
        $_POST['status_pembayaran']
    ]);
echo "
<script>
alert('Tagihan berhasil ditambahkan');
window.location='tagihan.php';
</script>
";
exit;
    header("Location: tagihan.php");
    exit;

}   
 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Tagihan</title>

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
select{
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
}

.button a:hover,
.button button:hover{
    background:#0f766e;
}

</style>

</head>

<body>

<div class="container">

<h2>Tambah Tagihan</h2>

<form method="POST">

<label>Janji Temu</label>

<select name="id_janji_temu" required>

<option value="">-- Pilih Janji Temu --</option>

<?php while($row = $janji->fetch(PDO::FETCH_ASSOC)){ ?>

<option value="<?= $row['id_janji_temu'] ?>">

<?= $row['nama_pasien'] ?>
-
<?= $row['nama_dokter'] ?>
(
<?= $row['tanggal_janji'] ?>
)

</option>

<?php } ?>

</select>

<label>Total Biaya</label>

<input
    type="number"
    id="total_biaya"
    name="total_biaya"
    min="0"
    step="1000"
    required
>

<label>Status Pembayaran</label>

<select name="status_pembayaran">

<option value="Belum Lunas">
Belum Lunas
</option>

<option value="Lunas">
Lunas
</option>

</select>

<div class="button">

<a href="tagihan.php">
Kembali
</a>

<button type="submit" name="simpan">
Simpan
</button>

</div>

</form>

</div>
<script>

document.querySelector("form").addEventListener("submit", function(e){

    const biaya =
    document.getElementById("total_biaya").value;

    if(parseFloat(biaya) < 0){

        alert("Total biaya tidak boleh bernilai negatif.");

        e.preventDefault();

    }

});

</script>
</body>
</html>