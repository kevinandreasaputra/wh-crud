<?php
include_once 'config/Database.php';
include_once 'classes/Product.php';
include_once 'classes/Auth.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new Auth($conn);
session_start();

if (!$auth->isAdmin()) {
    header("Location: index.php");
    exit();
}

$product = new Product($conn);
$id = isset($_GET['id']) ? $_GET['id'] : die('ID tidak valid.');
$product->id = $id;

$product->readOne();

if ($_POST) {
    $product->id = $_POST['id'];
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->quantity = $_POST['quantity'];
    $product->price = $_POST['price'];

    if ($product->update()) {
        header("Location: index.php");
    } else {
        $message = "Gagal mengupdate barang.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Barang</h2>
    <?php if (isset($message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
            <input value="<?php echo $product->name; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" type="text" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description" rows="3"><?php echo $product->description; ?></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                <input value="<?php echo $product->quantity; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="quantity" type="number" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                <input value="<?php echo $product->price; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="price" type="number" required>
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            <a href="index.php" class="text-gray-500 hover:text-gray-800 font-bold">Batal</a>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update Barang
            </button>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>