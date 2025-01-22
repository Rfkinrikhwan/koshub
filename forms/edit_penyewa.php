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
    $nama_lengkap = $_POST['Nama_Lengkap'];
    $nik = $_POST['NIK'];
    $jenis_kelamin = $_POST['Jenis_Kelamin'];
    $no_hp = $_POST['No_HP'];
    $email = $_POST['Email'];
    $alamat_asal = $_POST['Alamat_Asal'];
    $pekerjaan = $_POST['Pekerjaan'];
    $tanggal_masuk = $_POST['Tanggal_Masuk'];

    $updateQuery = "UPDATE penyewa 
                    SET Nama_Lengkap = :Nama_Lengkap, NIK = :NIK, Jenis_Kelamin = :Jenis_Kelamin, 
                        No_Hp = :No_Hp, Email = :Email, Alamat_Asal = :Alamat_Asal, 
                        Pekerjaan = :Pekerjaan, Tanggal_Masuk = :Tanggal_Masuk 
                    WHERE id_penyewa = :id_penyewa";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'Nama_Lengkap' => $nama_lengkap,
            'NIK' => $nik,
            'Jenis_Kelamin' => $jenis_kelamin,
            'No_Hp' => $no_hp,
            'Email' => $email,
            'Alamat_Asal' => $alamat_asal,
            'Pekerjaan' => $pekerjaan,
            'Tanggal_Masuk' => $tanggal_masuk,
            'id_penyewa' => $id_penyewa
        ]);
        header('Location: ../penyewa.php?edited=1');
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
                            <input type="text" name="Nama_Lengkap" value="<?= htmlspecialchars($penyewa['Nama_Lengkap']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
                            <input type="number" name="NIK" value="<?= htmlspecialchars($penyewa['NIK']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select name="Jenis_Kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Laki-laki" <?= $penyewa['Jenis_Kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $penyewa['Jenis_Kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">No. HP</label>
                            <input type="number" name="No_HP" value="<?= htmlspecialchars($penyewa['No_HP']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="Email" name="Email" value="<?= htmlspecialchars($penyewa['Email']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Asal</label>
                            <textarea name="Alamat_Asal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required><?= htmlspecialchars($penyewa['Alamat_Asal']) ?></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Pekerjaan</label>
                            <input type="text" name="Pekerjaan" value="<?= htmlspecialchars($penyewa['Pekerjaan']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Masuk</label>
                            <input type="date" name="Tanggal_Masuk" value="<?= htmlspecialchars($penyewa['Tanggal_Masuk']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
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