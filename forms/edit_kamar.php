<?php
require_once '../config/db.php';

// Cek apakah ada parameter 'id' yang dikirim
if (!isset($_GET['id'])) {
    header('Location: ../index.php?error=missing_id');
    exit;
}

$id_kamar = $_GET['id'];
$query = "SELECT * FROM kamar WHERE ID_Kamar = :id_kamar";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_kamar' => $id_kamar]);
    $kamar = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kamar) {
        header('Location: ../index.php?error=not_found');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipe = $_POST['tipe'];
    $fasilitas = $_POST['fasilitas'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $lantai = $_POST['lantai'];
    $kapasitas = $_POST['kapasitas'];

    $updateQuery = "UPDATE kamar 
                    SET Tipe_Kamar = :tipe, Fasilitas = :fasilitas, Harga_Bulanan = :harga, 
                        Status_Kamar = :status, Lantai = :lantai, Kapasitas = :kapasitas 
                    WHERE ID_Kamar = :id_kamar";

    try {
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            'tipe' => $tipe,
            'fasilitas' => $fasilitas,
            'harga' => $harga,
            'status' => $status,
            'lantai' => $lantai,
            'kapasitas' => $kapasitas,
            'id_kamar' => $id_kamar // Parameter ditambahkan di sini
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
    <title>Edit Kamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Edit Data Kamar</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Kamar</label>
                            <input type="text" value="<?= htmlspecialchars($kamar['Nomor_Kamar']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" disabled>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tipe Kamar</label>
                            <select name="tipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Standard" <?= $kamar['Tipe_Kamar'] === 'Standard' ? 'selected' : '' ?>>Standard</option>
                                <option value="Deluxe" <?= $kamar['Tipe_Kamar'] === 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
                                <option value="Suite" <?= $kamar['Tipe_Kamar'] === 'Suite' ? 'selected' : '' ?>>Suite</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Fasilitas</label>
                            <textarea name="fasilitas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required><?= htmlspecialchars($kamar['Fasilitas']) ?></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Harga Bulanan</label>
                            <input type="number" name="harga" value="<?= htmlspecialchars($kamar['Harga_Bulanan']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Tersedia" <?= $kamar['Status_Kamar'] === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="Terisi" <?= $kamar['Status_Kamar'] === 'Terisi' ? 'selected' : '' ?>>Terisi</option>
                                <option value="Maintenance" <?= $kamar['Status_Kamar'] === 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Lantai</label>
                            <input type="number" name="lantai" value="<?= htmlspecialchars($kamar['Lantai']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Kapasitas</label>
                            <input type="number" name="kapasitas" value="<?= htmlspecialchars($kamar['Kapasitas']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <a href="../index.php" class="text-gray-500 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2   ">
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