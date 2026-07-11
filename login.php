<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistem Informasi Klinik</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{

    background:#eef7f6;

    display:flex;
    justify-content:center;
    align-items:center;

    height:100vh;

}

.container{

    width:400px;

    background:white;

    padding:35px;

    border-radius:15px;

    box-shadow:0 5px 20px rgba(0,0,0,.15);

}

h1{

    text-align:center;

    color:#0f766e;

    margin-bottom:10px;

}

p{

    text-align:center;

    color:#666;

    margin-bottom:25px;

}

label{

    display:block;

    margin-top:15px;

    margin-bottom:5px;

    font-weight:bold;

}

input{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:8px;

}

button{

    width:100%;

    margin-top:25px;

    padding:12px;

    background:#14b8a6;

    color:white;

    border:none;

    border-radius:8px;

    cursor:pointer;

    font-size:16px;

}

button:hover{

    background:#0f766e;

}

.register{

    margin-top:20px;

    text-align:center;

}

.register a{

    text-decoration:none;

    color:#0f766e;

    font-weight:bold;

}

</style>

</head>

<body>

<div class="container">

<h1>Login</h1>

<p>Sistem Informasi Klinik</p>

<form action="proses_login.php" method="POST">

<label>Username</label>

<input
type="text"
name="username"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<button type="submit">

Login

</button>

</form>

<div class="register">

Belum memiliki akun?

<a href="register.php">

Daftar

</a>

</div>

</div>

</body>
</html>