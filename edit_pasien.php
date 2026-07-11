    <?php
    include 'auth_admin.php';
    include 'config.php';

   if(!isset($_GET['id'])){
    die("ID pasien tidak ditemukan");
}

$id = $_GET['id'];

$query = $conn->prepare("
    SELECT *
    FROM pasien
    WHERE id_pasien = ?
");

$query->execute([$id]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if(!$data){
    die("Data pasien tidak ditemukan");
}


    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>

    <meta charset="UTF-8">
    <title>Edit Pasien</title>

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
        border-radius:6px;

    }

    textarea{
        resize:vertical;
    }

    .button{

        display:flex;
        justify-content:space-between;
        margin-top:25px;

    }

    .button a,
    .button button{

        text-decoration:none;
        background:#14b8a6;
        color:white;
        padding:10px 20px;
        border:none;
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

    <h2>Edit Data Pasien</h2>

    <form id="formEditPasien">
    <input
    type="hidden"
    id="id_pasien"
    value="<?= $id ?>">

    <label>Nama Pasien</label>
    <input type="text" id="nama_pasien" name="nama_pasien"
    value="<?= $data['nama_pasien']; ?>" required>

    <label>Tempat Lahir</label>
    <input type="text" id="tempat_lahir" name="tempat_lahir"
    value="<?= $data['tempat_lahir']; ?>">

    <label>Tanggal Lahir</label>
    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
    value="<?= $data['tanggal_lahir']; ?>">

    <label>Jenis Kelamin</label>

    <select id="jenis_kelamin" name="jenis_kelamin">

    <option value="Laki-laki"
    <?= $data['jenis_kelamin']=="Laki-laki" ? "selected" : ""; ?>>
    Laki-laki
    </option>

    <option value="Perempuan"
    <?= $data['jenis_kelamin']=="Perempuan" ? "selected" : ""; ?>>
    Perempuan
    </option>

    </select>

    <label>Alamat</label>

    <textarea id="alamat" name="alamat"><?= $data['alamat']; ?></textarea>

    <label>Nomor Telepon</label>

    <input
    type="text"
    id="nomor_telepon"
    name="nomor_telepon"
    value="<?= $data['nomor_telepon']; ?>"
    required>

    <div class="button">



    <a href="pasien.php">Batal</a>

    <button
    type="submit">
    Update
    </button>

    </div>

    </form>

    </div>

    <script>

    console.log("FETCH EDIT PASIEN BERJALAN");
    
    document.getElementById("formEditPasien").addEventListener("submit",function(e){

        e.preventDefault();

        const hp=document.getElementById("nomor_telepon").value;

        if(!/^[0-9]+$/.test(hp)){

            alert("Nomor telepon hanya boleh berisi angka");

            return;

        }

        const formData=new FormData();

        formData.append("id_pasien",
            document.getElementById("id_pasien").value);

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

        fetch("api/pasien_update.php",{

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