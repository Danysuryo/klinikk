<?php
include 'auth_admin.php';
include 'config.php';

$id = $_GET['id'];

$data = $conn->prepare("
SELECT *
FROM tagihan
WHERE id_tagihan = ?
");

$data->execute([$id]);

$row = $data->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['update'])){

    $query = $conn->prepare("
    UPDATE tagihan
    SET
        total_biaya = ?,
        status_pembayaran = ?
    WHERE id_tagihan = ?
    ");

    $query->execute([
        $_POST['total_biaya'],
        $_POST['status_pembayaran'],
        $id
    ]);
echo "
<script>
alert('Tagihan berhasil diperbarui');
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
<title>Edit Tagihan</title>

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

<h2>Edit Tagihan</h2>

<form method="POST">

<label>Total Biaya</label>

<input
type="number"
name="total_biaya"
value="<?= $row['total_biaya'] ?>"
required>

<label>Status Pembayaran</label>

<select name="status_pembayaran">

<option value="Belum Lunas"
<?= $row['status_pembayaran'] == 'Belum Lunas' ? 'selected' : '' ?>>
Belum Lunas
</option>

<option value="Lunas"
<?= $row['status_pembayaran'] == 'Lunas' ? 'selected' : '' ?>>
Lunas
</option>

</select>

<div class="button">

<a href="tagihan.php">
Kembali
</a>

<button type="submit" name="update">
Update
</button>

</div>

</form>

</div>

</body>
</html>