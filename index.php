<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: block;
            text-decoration: none;
            color: #000;
            padding: 10px;
            border: 1px solid #ccc;
            background: #e9e9e9;
            text-align: center;
        }

        a:hover {
            background: #dcdcdc;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Menu Utama</h2>

        <ul>
            <li><a href="tampilUser.php">Data Siswa</a></li>
            <li><a href="tampilBuku.php">Data Buku</a></li>
            <li><a href="tampilMenuBuku.php">Tampil buku</a></li>
        </ul>
    </div>

</body>
</html>