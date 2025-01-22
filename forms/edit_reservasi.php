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
        header('Location: ../index.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewa = $_POST['id_penyewa'];
    $id_kamar = $_POST['id_kamar'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $durasi_sewa = $_POST['durasi_sewa'];
    $status_reservasi = $_POST['status_reservasi'];

    $updateQuery = "UPDATE reservasi 
                    SET id_penyewa = :id_penyewa, id_kamar = :id_kamar, 
                        tanggal_reservasi = :tanggal_reservasi, tanggal_mulai = :tanggal_mulai, 
                        durasi_sewa = :durasi_sewa, status_reservasi = :status_reservasi 
                    WHERE id_reservasi = :id_reservasi";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'id_penyewa' => $id_penyewa,
            'id_kamar' => $id_kamar,
            'tanggal_reservasi' => $tanggal_reservasi,
            'tanggal_mulai' => $tanggal_mulai,
            'durasi_sewa' => $durasi_sewa,
            'status_reservasi' => $status_reservasi,
            'id_reservasi' => $id_reservasi
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
                            <input type="number" name="id_penyewa" value="<?= htmlspecialchars($reservasi['id_penyewa']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">ID Kamar</label>
                            <input type="number" name="id_kamar" value="<?= htmlspecialchars($reservasi['id_kamar']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" value="<?= htmlspecialchars($reservasi['tanggal_reservasi']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($reservasi['tanggal_mulai']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Durasi Sewa (Bulan)</label>
                            <input type="number" name="durasi_sewa" value="<?= htmlspecialchars($reservasi['durasi_sewa']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Reservasi</label>
                            <select name="status_reservasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Pending" <?= $reservasi['status_reservasi'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= $reservasi['status_reservasi'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Cancelled" <?= $reservasi['status_reservasi'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
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