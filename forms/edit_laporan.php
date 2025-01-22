<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_laporan = $_GET['id'];
$query = "SELECT * FROM laporan WHERE ID_Laporan = :id_laporan";

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
    $id_admin = $_POST['ID_Admin'];
    $jenis_laporan = $_POST['Jenis_Laporan'];
    $periode = $_POST['Periode'];
    $tanggal_dibuat = $_POST['Tanggal_Dibuat'];
    $status_laporan = $_POST['Status_Laporan'];
    $keterangan = $_POST['Keterangan'];

    $updateQuery = "UPDATE laporan 
                    SET ID_Admin = :ID_Admin, 
                        Jenis_Laporan = :Jenis_Laporan, 
                        Periode = :Periode,
                        Tanggal_Dibuat = :Tanggal_Dibuat,
                        Status_Laporan = :Status_Laporan,
                        Keterangan = :Keterangan
                    WHERE id_laporan = :id_laporan";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'ID_Admin' => $id_admin,
            'Jenis_Laporan' => $jenis_laporan,
            'Periode' => $periode,
            'Tanggal_Dibuat' => $tanggal_dibuat,
            'Status_Laporan' => $status_laporan,
            'Keterangan' => $keterangan,
            'id_laporan' => $id_laporan
        ]);
        header('Location: ../laporan.php?edited=1');
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
                            <input type="number" name="ID_Admin" value="<?= htmlspecialchars($laporan['ID_Admin']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Laporan</label>
                            <input type="text" name="Jenis_Laporan" value="<?= htmlspecialchars($laporan['Jenis_Laporan']) ?>" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Periode</label>
                            <input type="text" name="Periode" value="<?= htmlspecialchars($laporan['Periode']) ?>" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Dibuat</label>
                            <input type="date" name="Tanggal_Dibuat" value="<?= htmlspecialchars($laporan['Tanggal_Dibuat']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Laporan</label>
                            <select name="Status_Laporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="pending" <?= $laporan['Status_Laporan'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= $laporan['Status_Laporan'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?= $laporan['Status_Laporan'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                            <textarea name="Keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required><?= htmlspecialchars($laporan['Keterangan']) ?></textarea>
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