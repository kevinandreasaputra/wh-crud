<?php
include_once 'config/Database.php';
include_once 'classes/Product.php';

$database = new Database();
$conn = $database->getConnection();

$product = new Product($conn);

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $stmt = $product->search($search);
} else {
    $stmt = $product->read();
}
$num = $stmt->rowCount();

?>

<?php include 'includes/header.php'; ?>

<div class="bg-white shadow rounded-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Inventaris</h2>

        <form action="index.php" method="get" class="flex-grow max-w-lg mx-auto">
            <div class="flex">
                <input type="text" name="search" placeholder="Cari barang..." value="<?php echo isset($search) ? $search : ''; ?>" class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-r border border-l-0 border-gray-300" type="submit">
                    Cari
                </button>
            </div>
        </form>

        <a href="create.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Barang
        </a>
    </div>

    <?php if ($num > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <?php extract($row); ?>

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo $name; ?></div>
                                <div class="text-sm text-gray-500"><?php echo substr($description, 0, 50) . '...'; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo $quantity; ?> Pcs</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp <?php echo number_format($price, 2, ',', '.'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="edit.php?id=<?php echo $id; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <a href="delete.php?id=<?php echo $id; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <p class="text-yellow-700">Belum ada barang di gudang. Silakan tambah barang baru.</p>
        </div>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>