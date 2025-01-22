<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_penyewa = $_GET['id'];
$query = "SELECT * FROM penyewa WHERE id_penyewa = :id_penyewa";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_penyewa' => $id_penyewa]);
    $penyewa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penyewa) {
        header('Location: ../index.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nik = $_POST['nik'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat_asal = $_POST['alamat_asal'];
    $pekerjaan = $_POST['pekerjaan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];

    $updateQuery = "UPDATE penyewa 
                    SET nama_lengkap = :nama_lengkap, nik = :nik, jenis_kelamin = :jenis_kelamin, 
                        no_hp = :no_hp, email = :email, alamat_asal = :alamat_asal, 
                        pekerjaan = :pekerjaan, tanggal_masuk = :tanggal_masuk 
                    WHERE id_penyewa = :id_penyewa";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'nama_lengkap' => $nama_lengkap,
            'nik' => $nik,
            'jenis_kelamin' => $jenis_kelamin,
            'no_hp' => $no_hp,
            'email' => $email,
            'alamat_asal' => $alamat_asal,
            'pekerjaan' => $pekerjaan,
            'tanggal_masuk' => $tanggal_masuk,
            'id_penyewa' => $id_penyewa
        ]);
        header('Location: ../index.php?edited=1');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penyewa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Edit Data Penyewa</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($penyewa['Nama_Lengkap']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
                            <input type="text" name="nik" value="<?= htmlspecialchars($penyewa['nik']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Laki-laki" <?= $penyewa['Jenis_Kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $penyewa['Jenis_Kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                            <input type="text" name="no_hp" value="<?= htmlspecialchars($penyewa['No_Hp']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($penyewa['Email']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Asal</label>
                            <textarea name="alamat_asal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required><?= htmlspecialchars($penyewa['alamat_asal']) ?></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="<?= htmlspecialchars($penyewa['pekerjaan']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" value="<?= htmlspecialchars($penyewa['tanggal_masuk']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <a href="../index.php" class="text-gray-500 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                            Batal
                        </a>
                        <button class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>