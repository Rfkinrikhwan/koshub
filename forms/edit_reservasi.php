<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_reservasi = $_GET['id'];
$query = "SELECT * FROM reservasi WHERE id_reservasi = :id_reservasi";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_reservasi' => $id_reservasi]);
    $reservasi = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservasi) {
        header('Location: ../reservasi.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewa = $_POST['ID_Penyewa'];
    $id_kamar = $_POST['ID_Kamar'];
    $tanggal_reservasi = $_POST['Tanggal_Reservasi'];
    $tanggal_mulai = $_POST['Tanggal_Mulai'];
    $durasi_sewa = $_POST['Durasi_Sewa'];
    $status_reservasi = $_POST['Status_Reservasi'];

    $updateQuery = "UPDATE reservasi 
                    SET ID_Penyewa = :ID_Penyewa, ID_Kamar = :ID_Kamar, 
                        Tanggal_Reservasi = :Tanggal_Reservasi, Tanggal_Mulai = :Tanggal_Mulai, 
                        Durasi_Sewa = :Durasi_Sewa, Status_Reservasi = :Status_Reservasi 
                    WHERE id_reservasi = :id_reservasi";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'ID_Penyewa' => $id_penyewa,
            'ID_Kamar' => $id_kamar,
            'Tanggal_Reservasi' => $tanggal_reservasi,
            'Tanggal_Mulai' => $tanggal_mulai,
            'Durasi_Sewa' => $durasi_sewa,
            'Status_Reservasi' => $status_reservasi,
            'id_reservasi' => $id_reservasi
        ]);
        header('Location: ../reservasi.php?edited=1');
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
    <title>Edit Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Edit Reservasi</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">ID Penyewa</label>
                            <input type="number" name="ID_Penyewa" value="<?= htmlspecialchars($reservasi['ID_Penyewa']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">ID Kamar</label>
                            <input type="number" name="ID_Kamar" value="<?= htmlspecialchars($reservasi['ID_Kamar']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Reservasi</label>
                            <input type="date" name="Tanggal_Reservasi" value="<?= htmlspecialchars($reservasi['Tanggal_Reservasi']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                            <input type="date" name="Tanggal_Mulai" value="<?= htmlspecialchars($reservasi['Tanggal_Mulai']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Durasi Sewa (Bulan)</label>
                            <input type="number" name="Durasi_Sewa" value="<?= htmlspecialchars($reservasi['Durasi_Sewa']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Reservasi</label>
                            <select name="status_reservasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Pending" <?= $reservasi['Status_Reservasi'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= $reservasi['Status_Reservasi'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Cancelled" <?= $reservasi['Status_Reservasi'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
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