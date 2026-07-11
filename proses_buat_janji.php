<?php
include 'auth_user.php';
include 'config.php';

try{

    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $tanggal_janji = $_POST['tanggal_janji'];
    $keluhan = trim($_POST['keluhan']);

    /*
    ==========================
    VALIDASI
    ==========================
    */

    if(
        empty($id_pasien) ||
        empty($id_dokter) ||
        empty($tanggal_janji) ||
        empty($keluhan)
    ){

        throw new Exception("Semua data harus diisi.");

    }

    /*
    ==========================
    TANGGAL TIDAK BOLEH
    KURANG DARI HARI INI
    ==========================
    */

    if($tanggal_janji < date("Y-m-d")){

        throw new Exception("Tanggal janji tidak boleh kurang dari hari ini.");

    }

    /*
    ==========================
    INSERT JANJI
    ==========================
    */

    $query = $conn->prepare("
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
    ");

    $query->execute([

        $id_pasien,
        $id_dokter,
        $tanggal_janji,
        $keluhan,
        "Menunggu"

    ]);

    echo "
    <script>

    alert('Janji berhasil dibuat.');

    window.location='janji_saya.php';

    </script>
    ";

}catch(Exception $e){

    echo "
    <script>

    alert('".$e->getMessage()."');

    history.back();

    </script>
    ";

}
?>