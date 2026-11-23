<?php
include 'koneksi.php';

$pesan = "";

// Simpan data buku
if (isset($_POST['simpan'])) {
    $id_siswa = isset($_POST['id_siswa'])
        ? (int) $_POST['id_siswa'] : 0;

    $tanggal = $_POST['tanggal'] ?? '';
    $status = $_POST['status_terima'] ?? '';

    if (
        $id_siswa > 0 &&
        $tanggal != "" &&
        in_array($status, ['diterima', 'tidak diterima'], true)
    ) {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO tb_mbg
            (id_buku, tanggal, status_terima)
            VALUES (?, ?, ?)"
        );

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "iss",
                $id_siswa,
                $tanggal,
                $status
            );

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: tampilMBG.php");
                exit;
            } else {
            }

            mysqli_stmt_close($stmt);
        } else {
            $pesan = "Gagal menyiapkan query penyimpanan.";
        }
    } else {
        $pesan = "Semua kolom wajib diisi!";
    }
}

// Ambil daftar siswa
$siswa = mysqli_query(
    $koneksi,
    "SELECT * FROM perpistakan ORDER BY nama"
);

if (!$siswa) {
    die("Gagal mengambil data siswa: " .
        mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Buku</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 px-4 py-8 font-sans text-slate-800">

    <div class="mx-auto max-w-lg rounded-2xl bg-white p-6 shadow-lg sm:p-8">

        <!-- Judul -->
        <div class="mb-6 text-center">
            <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-2xl">
                🍱
            </div>

            <h2 class="text-2xl font-bold text-emerald-700">
                Tambah Buku
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Isi data peminjaman buku
            </p>
        </div>

        <!-- Pesan kesalahan -->
        <?php if ($pesan != ""): ?>
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="post" class="space-y-5">

            <!-- Pilih siswa -->
            <div>
                <label for="id_siswa"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Pilih Siswa
                </label>

                <select
                    name="id_siswa"
                    id="id_siswa"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                >
                    <option value="">-- Pilih Siswa --</option>

                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                        <option value="<?= (int)$s['id_siswa'] ?>"
                            <?= (isset($_POST['id_siswa']) &&
                                (int)$_POST['id_siswa'] === (int)$s['id_siswa'])
                                ? 'selected' : '' ?>>
                            <?= htmlspecialchars(
                                $s['nama'] . " - " . $s['kelas']
                            ) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label for="tanggal"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Tanggal Penerimaan
                </label>

                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    value="<?= htmlspecialchars($_POST['tanggal'] ?? '') ?>"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                >
            </div>

            <!-- Status -->
            <div>
                <label for="status_terima"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Status Penerimaan
                </label>

                <select
                    name="status_terima"
                    id="status_terima"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                >
                    <option value="">-- Pilih Status --</option>

                    <option value="diterima"
                        <?= (($_POST['status_terima'] ?? '') === 'diterima')
                            ? 'selected' : '' ?>>
                        Diterima
                    </option>

                    <option value="tidak diterima"
                        <?= (($_POST['status_terima'] ?? '') === 'tidak diterima')
                            ? 'selected' : '' ?>>
                        Tidak diterima
                    </option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="flex flex-col gap-3 pt-2 sm:flex-row">

                <button
                    type="submit"
                    name="simpan"
                    class="w-full rounded-lg bg-emerald-600 px-5 py-3 font-semibold text-white shadow transition hover:bg-emerald-700 active:scale-95"
                >
                    Simpan Data
                </button>

                <a
                    href="tampilBuku.php"
                    class="w-full rounded-lg border border-slate-300 px-5 py-3 text-center font-semibold text-slate-600 transition hover:bg-slate-100"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</body>
</html>