<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registrasi Pasien</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{

    background:#eef7f6;

    display:flex;
    justify-content:center;
    align-items:center;

    min-height:100vh;

    padding:40px;
}

.container{

    width:550px;

    background:white;

    padding:35px;

    border-radius:15px;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

}

h1{

    text-align:center;

    color:#0f766e;

    margin-bottom:25px;

}

label{

    display:block;

    margin-top:15px;

    margin-bottom:5px;

    font-weight:bold;

}

input,
textarea,
select{

    width:100%;

    padding:10px;

    border:1px solid #ccc;

    border-radius:8px;

}

textarea{

    resize:vertical;

}

button{

    width:100%;

    margin-top:30px;

    padding:12px;

    background:#14b8a6;

    color:white;

    border:none;

    border-radius:8px;

    cursor:pointer;

}

button:hover{

    background:#0f766e;

}

.login{

    text-align:center;

    margin-top:20px;

}

.login a{

    text-decoration:none;

    color:#0f766e;

    font-weight:bold;

}

</style>

</head>

<body>

<div class="container">

<h1>Registrasi Pasien</h1>

<form action="proses_register.php" method="POST">

<label>Nama Lengkap</label>
<input type="text" name="nama" required>

<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>
<input type="password" name="password" required>

<label>Tempat Lahir</label>
<input type="text" name="tempat_lahir" required>

<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" required>

<label>Jenis Kelamin</label>

<select name="jenis_kelamin">

<option value="Laki-laki">Laki-laki</option>
<option value="Perempuan">Perempuan</option>

</select>

<label>Alamat</label>

<textarea
name="alamat"
required></textarea>

<label>Nomor Telepon</label>

<input
type="text"
name="nomor_telepon"
required>

<button type="submit">

Daftar

</button>

</form>

<div class="login">

Sudah memiliki akun?

<a href="login.php">

Login

</a>

</div>

</div>

</body>
</html>