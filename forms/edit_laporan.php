<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_laporan = $_GET['id'];
$query = "SELECT * FROM laporan WHERE id_laporan = :id_laporan";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_laporan' => $id_laporan]);
    $laporan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$laporan) {
        header('Location: ../index.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_admin = $_POST['id_admin'];
    $jenis_laporan = $_POST['jenis_laporan'];
    $periode = $_POST['periode'];
    $tanggal_dibuat = $_POST['tanggal_dibuat'];
    $status_laporan = $_POST['status_laporan'];
    $keterangan = $_POST['keterangan'];

    $updateQuery = "UPDATE laporan 
                    SET id_admin = :id_admin, 
                        jenis_laporan = :jenis_laporan, 
                        periode = :periode,
                        tanggal_dibuat = :tanggal_dibuat,
                        status_laporan = :status_laporan,
                        keterangan = :keterangan
                    WHERE id_laporan = :id_laporan";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'id_admin' => $id_admin,
            'jenis_laporan' => $jenis_laporan,
            'periode' => $periode,
            'tanggal_dibuat' => $tanggal_dibuat,
            'status_laporan' => $status_laporan,
            'keterangan' => $keterangan,
            'id_laporan' => $id_laporan
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
    <title>Edit Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Edit Laporan</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">ID Admin</label>
                            <input type="number" name="id_admin" value="<?= htmlspecialchars($laporan['id_admin']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Laporan</label>
                            <input type="text" name="jenis_laporan" value="<?= htmlspecialchars($laporan['jenis_laporan']) ?>" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Periode</label>
                            <input type="text" name="periode" value="<?= htmlspecialchars($laporan['periode']) ?>" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Dibuat</label>
                            <input type="date" name="tanggal_dibuat" value="<?= htmlspecialchars($laporan['tanggal_dibuat']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Laporan</label>
                            <select name="status_laporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="pending" <?= $laporan['status_laporan'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= $laporan['status_laporan'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?= $laporan['status_laporan'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                            <textarea name="keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required><?= htmlspecialchars($laporan['keterangan']) ?></textarea>
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