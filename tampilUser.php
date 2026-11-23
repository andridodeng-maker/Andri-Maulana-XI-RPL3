<?php
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM perpistakan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">

<div class="max-w-4xl mx-auto bg-white p-5 rounded-lg shadow">

    <h2 class="text-2xl font-bold text-blue-600 text-center mb-5">
        Data Siswa
    </h2>

    <a href="index.php" class="bg-blue-500 text-white px-3 py-2 rounded">
        Menu Utama
    </a>

    <a href="tambahSiswa.php" class="bg-green-500 text-white px-3 py-2 rounded">
        + Tambah Siswa
    </a>

    <div class="overflow-x-auto mt-5">
        <table class="w-full text-center border-collapse">
            <tr class="bg-blue-500 text-white">
                <th class="p-2">id_anggota</th>
                <th class="p-2">nama_anggota</th>
                <th class="p-2">username</th>
                <th class="p-2">password</th>
                <th class="p-2">kelas</th>
            </tr>

            <?php
            $no = 1;
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2"><?= $no++ ?></td>
                <td class="p-2"><?= htmlspecialchars($row['nama anggota']) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['kelas']) ?></td>
                <td class="p-2">
                    <a class="bg-green-500 text-white px-2 py-1 rounded"
                       href="editSiswa.php?id=<?= (int)$row['id_siswa'] ?>">Edit</a>

                    <a class="bg-red-500 text-white px-2 py-1 rounded"
                       href="hapusSiswa.php?id=<?= (int)$row['id_siswa'] ?>"
                       onclick="return confirm('Yakin ingin menghapus siswa ini?')">Hapus</a>
                </td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="5" class="p-4">Belum ada data siswa.</td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>
</body>
</html>