<?php
include_once 'config/Database.php';
include_once 'classes/Product.php';

$database = new Database();
$conn = $database->getConnection();

$product = new Product($conn);

if ($_POST) {
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->quantity = $_POST['quantity'];
    $product->price = $_POST['price'];

    if ($product->create()) {
        header("Location: index.php");
    } else {
        $message = "Gagal menambah barang.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Barang Baru</h2>
    <?php if (isset($message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama Barang</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" required placeholder="Contoh: Laptop Asus">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Deskripsi</label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3" placeholder="Deskripsi singkat..."></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">Stok</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="quantity" name="quantity" type="number" required placeholder="0">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Harga (Rp)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" type="number" required placeholder="10000">
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            <a href="index.php" class="text-gray-500 hover:text-gray-800 font-bold">Batal</a>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Simpan Barang
            </button>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>