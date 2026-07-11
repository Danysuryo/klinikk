<?php
session_start();

include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->prepare("
    SELECT *
    FROM users
    WHERE username = ?
");

$query->execute([$username]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if($user){

    if(password_verify($password, $user['password'])){

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == 'admin'){

            header("Location: index.php");
            exit;

        }else{

            header("Location: dashboard_user.php");
            exit;

        }

    }

}

echo "
<script>

alert('Username atau Password salah.');

window.location='login.php';

</script>
";
?>