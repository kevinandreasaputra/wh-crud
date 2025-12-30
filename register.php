<?php
include_once 'config/Database.php';
include_once 'classes/Auth.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new Auth($conn);

if ($_POST) {
    if ($auth->register($_POST['username'], $_POST['password'], $_POST['role'])) {
        $success = "Pendaftaran berhasil. Silakan Login.";
    } else {
        $error = "Pendaftaran gagal. Username sudah terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register Warehouse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar User Baru</h2>
        <?php if (isset($success)) echo "<p class='text-green-500 mb-4'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" class="shadow border rounded w-full py-2 px-3" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="shadow border rounded w-full py-2 px-3" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select name="role" class="shadow border rounded w-full py-2 px-3">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                Daftar
            </button>
        </form>
        <p class="mt-4 text-center text-sm">Sudah punya akun? <a href="login.php" class="text-blue-500">Login</a></p>
    </div>
</body>

</html>