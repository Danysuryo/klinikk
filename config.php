<?php

$host = "ep-ancient-fog-aoi3gsv7-pooler.c-2.ap-southeast-1.aws.neon.tech";
$port = "5432";
$dbname = "neondb";
$username = "neondb_owner";
$password = "npg_3gvpI7VtELkC";

try {

    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Koneksi gagal: " . $e->getMessage());

}