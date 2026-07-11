<?php
include 'auth_user.php';
include 'config.php';

if(!isset($_GET['id'])){

    header("Location: janji_saya.php");
    exit;

}

$id_janji=$_GET['id'];

/*
=====================================
AMBIL ID PASIEN LOGIN
=====================================
*/

$query=$conn->prepare("
SELECT id_pasien
FROM pasien
WHERE id_user=?
");

$query->execute([
    $_SESSION['id_user']
]);

$pasien=$query->fetch(PDO::FETCH_ASSOC);

if(!$pasien){

    die("Data pasien tidak ditemukan.");

}

/*
=====================================
PASTIKAN JANJI MILIK USER
=====================================
*/

$query=$conn->prepare("
SELECT *
FROM janji_temu
WHERE
id_janji_temu=?
AND
id_pasien=?
");

$query->execute([
    $id_janji,
    $pasien['id_pasien']
]);

$cek=$query->fetch(PDO::FETCH_ASSOC);

if(!$cek){

    die("Akses ditolak.");

}

/*
=====================================
HANYA STATUS MENUNGGU
=====================================
*/

if($cek['status']!="Menunggu"){

    echo "
    <script>

    alert('Janji tidak dapat dibatalkan.');

    window.location='janji_saya.php';

    </script>
    ";

    exit;

}

/*
=====================================
UPDATE STATUS
=====================================
*/

$query=$conn->prepare("
UPDATE janji_temu
SET status='Dibatalkan'
WHERE id_janji_temu=?
");

$query->execute([
    $id_janji
]);

echo "
<script>

alert('Janji berhasil dibatalkan.');

window.location='janji_saya.php';

</script>
";
?>