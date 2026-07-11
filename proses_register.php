<?php
include 'config.php';

try{

    $conn->beginTransaction();

    $nama             = $_POST['nama'];
    $username         = $_POST['username'];
    $password         = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $tempat_lahir     = $_POST['tempat_lahir'];
    $tanggal_lahir    = $_POST['tanggal_lahir'];
    $jenis_kelamin    = $_POST['jenis_kelamin'];
    $alamat           = $_POST['alamat'];
    $nomor_telepon    = $_POST['nomor_telepon'];

    /*
    ===========================
    Cek username
    ===========================
    */

    $cek = $conn->prepare("
        SELECT *
        FROM users
        WHERE username = ?
    ");

    $cek->execute([$username]);

    if($cek->rowCount() > 0){

        throw new Exception("Username sudah digunakan.");

    }

    /*
    ===========================
    Insert users
    ===========================
    */

    $query = $conn->prepare("
    INSERT INTO users
    (
        nama,
        username,
        password,
        role
    )
    VALUES
    (
        ?,?,?,?
    )
    RETURNING id_user
");

$query->execute([
    $nama,
    $username,
    $password,
    'user'
]);

$id_user = $query->fetchColumn();
    /*
    ===========================
    Ambil id_user
    ===========================
    */


    /*
    ===========================
    Insert pasien
    ===========================
    */

    $query = $conn->prepare("
        INSERT INTO pasien
        (
            id_user,
            nama_pasien,
            tempat_lahir,
            tanggal_lahir,
            jenis_kelamin,
            alamat,
            nomor_telepon
        )
        VALUES
        (
            ?,?,?,?,?,?,?
        )
    ");

    $query->execute([

        $id_user,
        $nama,
        $tempat_lahir,
        $tanggal_lahir,
        $jenis_kelamin,
        $alamat,
        $nomor_telepon

    ]);

    if(!$id_user){
    throw new Exception("Gagal mendapatkan id_user.");
}

    $conn->commit();

    echo "
    <script>

    alert('Registrasi berhasil');

    window.location='login.php';

    </script>
    ";

}catch(Exception $e){

    $conn->rollBack();

    echo "
    <script>

    alert('".$e->getMessage()."');

    window.location='register.php';

    </script>
    ";

}