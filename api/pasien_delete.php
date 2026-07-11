<?php

include "../config.php";

header("Content-Type: application/json");

try{

    if(!isset($_POST['id_pasien'])){

        throw new Exception("ID pasien tidak ditemukan.");

    }

    $id = $_POST['id_pasien'];

    $query = $conn->prepare("
        DELETE FROM pasien
        WHERE id_pasien=?
    ");

    $query->execute([$id]);

    echo json_encode([
        "success"=>true,
        "message"=>"Data pasien berhasil dihapus"
    ]);

}catch(Exception $e){

    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
    ]);

}

?>