<?php

include "../config.php";

header("Content-Type: application/json");

try{

    $id = $_POST['id_pasien'];
    $nama = $_POST['nama_pasien'];
    $tempat = $_POST['tempat_lahir'];
    $tanggal = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['nomor_telepon'];

    $query = $conn->prepare("
        UPDATE pasien
        SET
            nama_pasien=?,
            tempat_lahir=?,
            tanggal_lahir=?,
            jenis_kelamin=?,
            alamat=?,
            nomor_telepon=?
        WHERE id_pasien=?
    ");

    $query->execute([
        $nama,
        $tempat,
        $tanggal,
        $jk,
        $alamat,
        $telepon,
        $id
    ]);

    echo json_encode([
        "success"=>true,
        "message"=>"Data pasien berhasil diperbarui"
    ]);

}catch(Exception $e){

    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
    ]);

}