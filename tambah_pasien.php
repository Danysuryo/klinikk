<?php
include 'auth_admin.php';
include 'config.php';


?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Tambah Pasien</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#eef7f6;
}

.container{

    width:600px;
    margin:40px auto;

    background:white;

    padding:30px;

    border-radius:12px;

    box-shadow:0 5px 15px rgba(0,0,0,.1);

}

h2{

    color:#0f766e;

    margin-bottom:25px;

    text-align:center;

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

    border-radius:6px;

}

textarea{

    resize:vertical;

}

.button{

    margin-top:25px;

    display:flex;

    justify-content:space-between;

}

.button a,
.button button{

    text-decoration:none;

    background:#14b8a6;

    color:white;

    border:none;

    padding:10px 20px;

    border-radius:8px;

    cursor:pointer;

}

.button a:hover,
.button button:hover{

    background:#0f766e;

}

</style>

</head>

<body>

<div class="container">

<h2>Tambah Data Pasien</h2>

<form id="formPasien">

<label>Nama Pasien</label>
<input type="text" id="nama_pasien" name="nama_pasien" required>

<label>Tempat Lahir</label>
<input type="text" id="tempat_lahir" name="tempat_lahir">

<label>Tanggal Lahir</label>
<input type="date" id="tanggal_lahir" name="tanggal_lahir">

<label>Jenis Kelamin</label>

<select id="jenis_kelamin" name="jenis_kelamin">

<option>Laki-laki</option>

<option>Perempuan</option>

</select>

<label>Alamat</label>
<textarea
id="alamat"
name="alamat">
</textarea>

<label>Nomor Telepon</label>
<input
    type="text"
    name="nomor_telepon"
    id="nomor_telepon"
    required
>

<div class="button">

<a href="pasien.php">Kembali</a>

<button type="submit">
    
Simpan
</button>


</div>

</form>

</div>
<script>


<script>

document.querySelector("form").addEventListener("submit", function(e){

    const hp =
    document.getElementById("nomor_telepon").value;

    if(!/^[0-9]+$/.test(hp)){

        alert("Nomor telepon hanya boleh berisi angka");

        e.preventDefault();

    }

});

<script>

document.getElementById("formPasien")
.addEventListener("submit", function(e){

    e.preventDefault();

    const formData = new FormData();

    formData.append(
        "nama_pasien",
        document.getElementById("nama_pasien").value
    );

    formData.append(
        "tempat_lahir",
        document.getElementById("tempat_lahir").value
    );

    formData.append(
        "tanggal_lahir",
        document.getElementById("tanggal_lahir").value
    );

    formData.append(
        "jenis_kelamin",
        document.getElementById("jenis_kelamin").value
    );

    formData.append(
        "nomor_telepon",
        document.getElementById("nomor_telepon").value
    );

    fetch("api/pasien_create.php",{

        method:"POST",

        body:formData

    })

    .then(response=>response.json())

    .then(data=>{

        if(data.success){

            alert(data.message);

            window.location="pasien.php";

        }else{

            alert(data.message);

        }

    })

    .catch(error=>{

        alert("Terjadi kesalahan.");

        console.log(error);

    });

});

</script>
</script>

<script>

document.getElementById("formPasien").addEventListener("submit",function(e){

    e.preventDefault();

    const hp=document.getElementById("nomor_telepon").value;

    if(!/^[0-9]+$/.test(hp)){

        alert("Nomor telepon hanya boleh berisi angka");

        return;

    }

    const formData=new FormData();

    formData.append("nama_pasien",
        document.getElementById("nama_pasien").value);

    formData.append("tempat_lahir",
        document.getElementById("tempat_lahir").value);

    formData.append("tanggal_lahir",
        document.getElementById("tanggal_lahir").value);

    formData.append("jenis_kelamin",
        document.getElementById("jenis_kelamin").value);

    formData.append("alamat",
        document.getElementById("alamat").value);

    formData.append("nomor_telepon",
        document.getElementById("nomor_telepon").value);

    fetch("api/pasien_create.php",{

        method:"POST",

        body:formData

    })

    .then(response=>response.json())

    .then(data=>{

        if(data.success){

            alert(data.message);

            window.location="pasien.php";

        }else{

            alert(data.message);

        }

    })

    .catch(error=>{

        console.log(error);

        alert("Terjadi kesalahan.");

    });

});

</script>

</body>
</html>