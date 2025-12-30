<?php
include_once 'config/Database.php';
include_once 'classes/Auth.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new Auth($conn);

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header("Location: index.php");
    } else {
        $error = "Login gagal. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Warehouse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Login Sistem</h2>
        <?php if (isset($error)) echo "<p class='text-red-500 mb-4 text-center'>$error</p>"; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" class="shadow border rounded w-full py-2 px-3" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="shadow border rounded w-full py-2 px-3" required>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full">
                Masuk
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            Belum punya akun? <a href="register.php" class="text-indigo-600">Daftar disini</a>
        </p>
    </div>
</body>

</html>