<?php
require_once 'config/auth.php';
require_once 'config/db.php';

// Fetch data kamar
$query = "SELECT * FROM kamar";
$stmt = $pdo->query($query);
$kamars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses delete kamar
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM kamar WHERE ID_Kamar = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    header('Location: index.php?deleted=1');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Kamar - Kos Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">
    <?php include 'components/navbar.php'; ?>
    <?php include 'components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16 mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Data Kamar</h3>
                    <a href="forms/add_kamar.php" class="px-4 py-2 bg-orange-400 text-white rounded-md hover:bg-blue-700 transition duration-150 ease-in-out text-sm font-medium">
                        Tambah Kamar
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (isset($_GET['edited'])): ?>
                <div id="alert-edited" class="p-4 mb-4 text-blue-800 bg-blue-50" role="alert">
                    <span class="font-medium">Sukses!</span> Data kamar berhasil diperbarui.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>


            <?php if (isset($_GET['success'])): ?>
                <div id="alert-success" class="p-4 mb-4 text-green-800 bg-green-50" role="alert">
                    <span class="font-medium">Sukses!</span> Data kamar berhasil ditambahkan.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['deleted'])): ?>
                <div id="alert-deleted" class="p-4 mb-4 text-red-800 bg-red-50" role="alert">
                    <span class="font-medium">Sukses!</span> Data kamar berhasil dihapus.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Kamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lantai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($kamars as $index => $kamar): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo $index + 1; ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($kamar['Nomor_Kamar']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($kamar['Tipe_Kamar']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($kamar['Lantai']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Rp <?php echo number_format($kamar['Harga_Bulanan'], 0, ',', '.'); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php
                                    echo match ($kamar['Status_Kamar']) {
                                        'Tersedia' => 'bg-green-100 text-green-800',
                                        'Terisi' => 'bg-blue-100 text-blue-800',
                                        'Maintenance' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>">
                                        <?php echo htmlspecialchars($kamar['Status_Kamar']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($kamar['Kapasitas']); ?> Orang
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- <button class="text-blue-600 hover:text-blue-900" onclick="showDetail(<?php echo $kamar['ID_Kamar']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button> -->
                                        <a class="text-green-600 hover:text-green-900" href="<?php echo htmlspecialchars('forms/edit_kamar.php?id=' . $kamar['ID_Kamar']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $kamar['ID_Kamar']; ?>" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>