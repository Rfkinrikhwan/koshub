<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewa = $_POST['id_penyewa'];
    $id_kamar = $_POST['id_kamar'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $durasi_sewa = $_POST['durasi_sewa'];
    $status_reservasi = $_POST['status_reservasi'];

    // Perbaikan nama parameter query SQL
    $query = "INSERT INTO reservasi (ID_Penyewa, ID_Kamar, Tanggal_Reservasi, Tanggal_Mulai, Durasi_Sewa, Status_Reservasi) 
              VALUES (:id_penyewa, :id_kamar, :tanggal_reservasi, :tanggal_mulai, :durasi_sewa, :status_reservasi)";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id_penyewa' => $id_penyewa,
            'id_kamar' => $id_kamar,
            'tanggal_reservasi' => $tanggal_reservasi,
            'tanggal_mulai' => $tanggal_mulai,
            'durasi_sewa' => $durasi_sewa,
            'status_reservasi' => $status_reservasi
        ]);

        // Redirect ke halaman reservasi jika berhasil
        header('Location: ../reservasi.php?success=1');
        exit;
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
    <title>Tambah Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">
    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6">Tambah Reservasi Baru</h2>
                <form action="" method="POST">
                    <div class="grid gap-4 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Penyewa</label>
                            <select name="id_penyewa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="">Pilih Penyewa</option>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM penyewa");
                                $stmt->execute();

                                while ($penyewa = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $penyewa['ID_Penyewa'] . "'>" . $penyewa['Nama_Lengkap'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Kamar</label>
                            <select name="id_kamar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="">Pilih Kamar</option>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM kamar WHERE Status_Kamar = 'Tersedia'");
                                $stmt->execute();

                                while ($kamar = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $kamar['ID_Kamar'] . "'>" . $kamar['Nomor_Kamar'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Durasi Sewa (Bulan)</label>
                            <input type="number" name="durasi_sewa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Status Reservasi</label>
                            <select name="status_reservasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <a href="../reservasi.php" class="text-gray-500 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                            Batal
                        </a>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>