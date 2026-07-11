<?php
include 'auth_user.php';
include 'config.php';

try{

    $id_user = $_SESSION['id_user'];

    $nama = $_POST['nama_pasien'];
    $tempat = $_POST['tempat_lahir'];
    $tanggal = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['nomor_telepon'];

    /*
    ==========================
    UPDATE DATA PASIEN
    ==========================
    */

    $query = $conn->prepare("
    UPDATE pasien
    SET
        nama_pasien = ?,
        tempat_lahir = ?,
        tanggal_lahir = ?,
        jenis_kelamin = ?,
        alamat = ?,
        nomor_telepon = ?
    WHERE id_user = ?
    ");

    $query->execute([

        $nama,
        $tempat,
        $tanggal,
        $jk,
        $alamat,
        $telepon,
        $id_user

    ]);

    echo "
    <script>

    alert('Profil berhasil diperbarui.');

    window.location='profil_user.php';

    </script>
    ";

}catch(Exception $e){

    echo "
    <script>

    alert('".$e->getMessage()."');

    window.location='profil_user.php';

    </script>
    ";

}
?>