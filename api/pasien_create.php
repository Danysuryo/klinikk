<?php

include "../config.php";

header('Content-Type: application/json');

try{

    $nama = $_POST['nama_pasien'];
    $tempat = $_POST['tempat_lahir'];
    $tanggal = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['nomor_telepon'];

    $query = $conn->prepare("
        INSERT INTO pasien
        (
            nama_pasien,
            tempat_lahir,
            tanggal_lahir,
            jenis_kelamin,
            alamat,
            nomor_telepon
        )
        VALUES (?,?,?,?,?,?)
    ");

    $query->execute([
        $nama,
        $tempat,
        $tanggal,
        $jk,
        $alamat,
        $telepon
    ]);

    echo json_encode([
        "success"=>true,
        "message"=>"Data pasien berhasil disimpan"
    ]);

}catch(Exception $e){

    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
    ]);

}