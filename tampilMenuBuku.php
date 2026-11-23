<?php
include 'koneksi.php';

$sql = "SELECT perpistakan.*, tb_user.nis, tb_siswa.nama, tb_siswa.kelas
        FROM tb_mbg
        JOIN tb_siswa ON tb_mbg.id_siswa = tb_siswa.id_siswa
        ORDER BY tb_mbg.tanggal DESC";

$data = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman buku</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .judul {
            color: #1e40af;
            letter-spacing: 0.3px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-menu {
            color: #334155;
            background: #e2e8f0;
        }

        .btn-menu:hover {
            background: #cbd5e1;
        }

        .btn-tambah {
            color: white;
            background: #2563eb;
        }

        .btn-tambah:hover {
            background: #1d4ed8;
        }

        .btn-cari {
            color: white;
            background: #2563eb;
        }

        .btn-cari:hover {
            background: #1d4ed8;
        }

        .btn-reset {
            color: #334155;
            background: #e2e8f0;
        }

        .btn-reset:hover {
            background: #cbd5e1;
        }

        .btn-edit {
            color: white;
            background: #16a34a;
            padding: 7px 11px;
        }

        .btn-edit:hover {
            background: #15803d;
        }

        .btn-hapus {
            color: white;
            background: #dc2626;
            padding: 7px 11px;
        }

        .btn-hapus:hover {
            background: #b91c1c;
        }

        .filter-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px;
        }

        .filter-input {
            width: 100%;
            max-width: 250px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            background: white;
            border-radius: 8px;
            outline: none;
        }

        .filter-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            text-align: center;
        }

        thead {
            background: #1e40af;
            color: white;
        }

        th {
            padding: 15px 12px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 12px;
            font-size: 13px;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .diterima {
            color: #15803d;
            background: #dcfce7;
        }

        .tidak-diterima {
            color: #b91c1c;
            background: #fee2e2;
        }

        .pesan-filter {
            font-size: 13px;
            color: #475569;
        }

        @media (max-width: 640px) {
            .panel {
                padding: 16px;
            }

            .judul {
                font-size: 23px;
            }

            .btn {
                padding: 10px 12px;
                font-size: 12px;
            }

            .filter-input {
                max-width: none;
            }
        }
    </style>
</head>

<body class="min-h-screen p-4 md:p-8">

<div class="max-w-6xl mx-auto">

    <!-- Header halaman -->
    <div class="mb-6">
        <p class="text-sm font-bold tracking-widest text-blue-600 mb-2">
            SISTEM INFORMASI SISWA
        </p>

        <h1 class="judul text-3xl font-bold">
            Data Penerimaan MBG
        </h1>

        <p class="text-gray-500 text-sm mt-2">
            Kelola data penerimaan Makan Bergizi Gratis siswa.
        </p>
    </div>

    <div class="panel">

        <!-- Tombol navigasi -->
        <div class="flex flex-wrap justify-between items-center gap-3 mb-6">

            <div>
                <h2 class="text-lg font-bold text-slate-700">
                    Daftar Penerima MBG
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi penerimaan MBG siswa.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="index.php" class="btn btn-menu">
                    ← Menu Utama
                </a>

                <a href="tambahMBG.php" class="btn btn-tambah">
                    + Tambah Penerimaan
                </a>
            </div>

        </div>

        <!-- Filter tanggal -->
        <div class="filter-box mb-6">

            <h3 class="text-lg font-bold text-blue-800 mb-2">
                Filter Tanggal Penerimaan
            </h3>

            <p class="text-sm text-slate-600 mb-4">
                Pilih tanggal untuk melihat data penerimaan MBG.
            </p>

            <div class="flex flex-col sm:flex-row flex-wrap gap-2">

                <input
                    type="date"
                    id="filterTanggal"
                    class="filter-input"
                >

                <button
                    type="button"
                    onclick="filterTanggal()"
                    class="btn btn-cari"
                >
                    Cari Data
                </button>

                <button
                    type="button"
                    onclick="resetFilter()"
                    class="btn btn-reset"
                >
                    Tampilkan Semua
                </button>

            </div>

            <p id="pesanFilter" class="pesan-filter mt-4"></p>

        </div>

        <!-- Tabel data -->
        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabelMBG">

                <?php
                $no = 1;

                if ($data && mysqli_num_rows($data) > 0) {
                    while ($row = mysqli_fetch_assoc($data)) {
                ?>

                    <tr
                        class="barisMBG"
                        data-tanggal="<?= htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <td class="nomor"><?= $no++ ?></td>

                        <td class="font-semibold text-slate-700">
                            <?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                <?= htmlspecialchars($row['kelas'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['tanggal'], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?php if ($row['status_terima'] == 'diterima') { ?>

                                <span class="status diterima">
                                    Diterima
                                </span>

                            <?php } else { ?>

                                <span class="status tidak-diterima">
                                    Tidak Diterima
                                </span>

                            <?php } ?>
                        </td>

                        <td class="whitespace-nowrap">
                            <a
                                href="editMBG.php?id=<?= (int)$row['id_mbg'] ?>"
                                class="btn btn-edit"
                            >
                                Edit
                            </a>

                            <a
                                href="hapusMBG.php?id=<?= (int)$row['id_mbg'] ?>"
                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                class="btn btn-hapus"
                            >
                                Hapus
                            </a>
                        </td>
                    </tr>

                <?php
                    }
                } else {
                ?>

                    <tr id="pesanKosong">
                        <td colspan="6" class="py-10 text-gray-500">
                            <div class="text-3xl mb-2">📋</div>
                            <p class="font-semibold">
                                Belum ada data penerimaan MBG.
                            </p>
                            <p class="text-xs mt-1">
                                Silakan tambahkan data terlebih dahulu.
                            </p>
                        </td>
                    </tr>

                <?php } ?>

                    <tr id="tidakDitemukan" class="hidden">
                        <td colspan="6" class="py-10 text-gray-500">
                            <div class="text-3xl mb-2">🔍</div>
                            <p class="font-semibold">
                                Data tidak ditemukan.
                            </p>
                            <p class="text-xs mt-1">
                                Tidak ada penerima MBG pada tanggal tersebut.
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

        <!-- Footer -->
        <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap justify-between gap-2 text-xs text-gray-400">
            <span>Sistem Informasi Siswa</span>
            <span>Data Penerimaan MBG</span>
        </div>

    </div>
</div>

<script>
function filterTanggal() {
    const tanggal = document.getElementById('filterTanggal').value;
    const baris = document.querySelectorAll('.barisMBG');
    const pesan = document.getElementById('pesanFilter');
    const tidakDitemukan = document.getElementById('tidakDitemukan');
    const pesanKosong = document.getElementById('pesanKosong');

    if (tanggal === '') {
        pesan.textContent = 'Silakan pilih tanggal terlebih dahulu.';
        return;
    }

    let jumlah = 0;

    baris.forEach(function(row) {
        if (row.dataset.tanggal === tanggal) {
            row.classList.remove('hidden');
            jumlah++;
            row.querySelector('.nomor').textContent = jumlah;
        } else {
            row.classList.add('hidden');
        }
    });

    if (pesanKosong) {
        pesanKosong.classList.add('hidden');
    }

    if (jumlah === 0) {
        tidakDitemukan.classList.remove('hidden');
        pesan.textContent =
            'Tidak ada data penerimaan MBG pada tanggal ' + tanggal + '.';
    } else {
        tidakDitemukan.classList.add('hidden');
        pesan.textContent =
            'Ditemukan ' + jumlah +
            ' data penerima MBG pada tanggal ' + tanggal + '.';
    }
}

function resetFilter() {
    const baris = document.querySelectorAll('.barisMBG');
    const pesan = document.getElementById('pesanFilter');
    const tidakDitemukan = document.getElementById('tidakDitemukan');
    const pesanKosong = document.getElementById('pesanKosong');

    baris.forEach(function(row, index) {
        row.classList.remove('hidden');
        row.querySelector('.nomor').textContent = index + 1;
    });

    tidakDitemukan.classList.add('hidden');

    if (pesanKosong) {
        pesanKosong.classList.remove('hidden');
    }

    document.getElementById('filterTanggal').value = '';
    pesan.textContent = '';
}
</script>

</body>
</html>