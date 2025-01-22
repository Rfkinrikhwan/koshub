<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_pembayaran = $_GET['id'];
$query = "SELECT * FROM pembayaran WHERE id_pembayaran = :id_pembayaran";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_pembayaran' => $id_pembayaran]);
    $pembayaran = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pembayaran) {
        header('Location: ../pembayaran.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_reservasi = $_POST['ID_Reservasi'];
    $tanggal_pembayaran = $_POST['Tanggal_Pembayaran'];
    $jumlah_pembayaran = $_POST['Jumlah_Pembayaran'];
    $metode_pembayaran = $_POST['Metode_Pembayaran'];
    $status_pembayaran = $_POST['Status_Pembayaran'];
    $bukti_pembayaran = $_POST['Bukti_Pembayaran'];

    $updateQuery = "UPDATE pembayaran 
                    SET ID_Reservasi = :ID_Reservasi, 
                        Tanggal_Pembayaran = :Tanggal_Pembayaran, 
                        Jumlah_Pembayaran = :Jumlah_Pembayaran, 
                        Metode_Pembayaran = :Metode_Pembayaran, 
                        Status_Pembayaran = :Status_Pembayaran, 
                        Bukti_Pembayaran = :Bukti_Pembayaran
                    WHERE id_pembayaran = :id_pembayaran";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'ID_Reservasi' => $id_reservasi,
            'Tanggal_Pembayaran' => $tanggal_pembayaran,
            'Jumlah_Pembayaran' => $jumlah_pembayaran,
            'Metode_Pembayaran' => $metode_pembayaran,
            'Status_Pembayaran' => $status_pembayaran,
            'Bukti_Pembayaran' => $bukti_pembayaran,
            'id_pembayaran' => $id_pembayaran
        ]);
        header('Location: ../pembayaran.php?edited=1');
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
    <title>Edit Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Edit Data Pembayaran</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">ID Reservasi</label>
                            <input type="number" name="ID_Reservasi" value="<?= htmlspecialchars($pembayaran['ID_Reservasi']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pembayaran</label>
                            <input type="date" name="Tanggal_Pembayaran" value="<?= htmlspecialchars($pembayaran['Tanggal_Pembayaran']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah Pembayaran</label>
                            <input type="number" step="0.01" name="Jumlah_Pembayaran" value="<?= htmlspecialchars($pembayaran['Jumlah_Pembayaran']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Metode Pembayaran</label>
                            <select name="Metode_Pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Transfer" <?= $pembayaran['Metode_Pembayaran'] === 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                                <option value="Tunai" <?= $pembayaran['Metode_Pembayaran'] === 'Tunai' ? 'selected' : '' ?>>Tunai</option>
                                <option value="Kartu Kredit" <?= $pembayaran['Metode_Pembayaran'] === 'Kartu Kredit' ? 'selected' : '' ?>>Kartu Kredit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Pembayaran</label>
                            <select name="Status_Pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Pending" <?= $pembayaran['Status_Pembayaran'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Completed" <?= $pembayaran['Status_Pembayaran'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Failed" <?= $pembayaran['Status_Pembayaran'] === 'Failed' ? 'selected' : '' ?>>Failed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Bukti Pembayaran</label>
                            <textarea name="Bukti_Pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?= htmlspecialchars($pembayaran['Bukti_Pembayaran']) ?></textarea>
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