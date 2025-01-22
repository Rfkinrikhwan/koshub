<?php
session_start();

// Jika pengguna sudah login, langsung arahkan ke halaman index
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menyiapkan query untuk mencari pengguna berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE Username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Ambil data pengguna
    $user = $stmt->fetch();

    // Periksa apakah pengguna ditemukan dan verifikasi password
    if ($user && password_verify($password, $user['Password'])) {
        // Jika login berhasil, buat session
        $_SESSION['user_id'] = $user['ID_Admin'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['email'] = $user['Email'];
        header('Location: index.php');
        exit();
    } else {
        // Jika login gagal
        $error = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sewa Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Kos <span class="bg-orange-400 px-3 rounded-md text-white">Hub</span></h2>

        <?php if (isset($error)) : ?>
            <div class="bg-red-500 text-white text-center p-2 rounded-lg mb-4">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan username Anda" required />
            </div>

            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan password Anda" required />
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-orange-400 text-white rounded-lg hover:bg-orange-500 font-semibold focus:ring-4 focus:ring-blue-300">
                Login
            </button>
        </form>

        <div class="mt-4 text-center">
            <!-- <p class="text-sm text-gray-600">Belum punya akun? <a href="#" class="text-blue-600 hover:underline">Daftar di sini</a></p> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.bundle.min.js"></script>
</body>

</html>