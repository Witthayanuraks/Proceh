<?php
include 'config.php';

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_layanan'])) {
        $stmt = $pdo->prepare("INSERT INTO layanan_perjalanan (nama_layanan, deskripsi, harga, durasi) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nama_layanan'],
            $_POST['deskripsi'],
            $_POST['harga'],
            $_POST['durasi']
        ]);
        $sukses = "Layanan berhasil ditambahkan!";
    } elseif (isset($_POST['perbarui_layanan'])) {
        $stmt = $pdo->prepare("UPDATE layanan_perjalanan SET nama_layanan = ?, deskripsi = ?, harga = ?, durasi = ? WHERE id_layanan = ?");
        $stmt->execute([
            $_POST['nama_layanan'],
            $_POST['deskripsi'],
            $_POST['harga'],
            $_POST['durasi'],
            $_POST['id_layanan']
        ]);
        $sukses = "Layanan berhasil diperbarui!";
    }
}

// Hapus layanan
if (isset($_GET['hapus_layanan'])) {
    $stmt = $pdo->prepare("DELETE FROM layanan_perjalanan WHERE id_layanan = ?");
    $stmt->execute([$_GET['hapus_layanan']]);
    $sukses = "Layanan berhasil dihapus!";
}

// Ambil semua layanan
$layanan = $pdo->query("SELECT * FROM layanan_perjalanan")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Info-IN</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .status-menunggu { background-color: #fff3cd; color: #856404; }
        .status-dikonfirmasi { background-color: #d4edda; color: #155724; }
        .status-dibatalkan { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent hover:scale-105 transition-transform">
                Info-IN.aja | Pelayanan 
            </h1>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="layanan.php" class="font-medium px-3 py-2 rounded hover:bg-blue-700 transition-colors <?= basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'bg-blue-700' : '' ?>">Layanan</a></li>
                    <li><a href="pemesanan.php" class="font-medium px-3 py-2 rounded hover:bg-blue-700 transition-colors <?= basename($_SERVER['PHP_SELF']) == 'pemesanan.php' ? 'bg-blue-700' : '' ?>">Pemesanan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <?php if (isset($sukses)): ?>
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow animate-fade-in">
                <?= $sukses ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            <?= isset($_GET['edit']) ? 'Edit Layanan' : 'Tambah Layanan Baru' ?>
                        </h2>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="id_layanan" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
                            
                            <div>
                                <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan</label>
                                <input type="text" id="nama_layanan" name="nama_layanan" 
                                       value="<?= isset($_GET['edit']) ? $layanan[array_search($_GET['edit'], array_column($layanan, 'id_layanan'))]['nama_layanan'] : '' ?>" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"><?= isset($_GET['edit']) ? $layanan[array_search($_GET['edit'], array_column($layanan, 'id_layanan'))]['deskripsi'] : '' ?></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                    <input type="number" id="harga" name="harga" step="0.01" 
                                           value="<?= isset($_GET['edit']) ? $layanan[array_search($_GET['edit'], array_column($layanan, 'id_layanan'))]['harga'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label for="durasi" class="block text-sm font-medium text-gray-700 mb-1">Durasi</label>
                                    <input type="text" id="durasi" name="durasi" 
                                           value="<?= isset($_GET['edit']) ? $layanan[array_search($_GET['edit'], array_column($layanan, 'id_layanan'))]['durasi'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                            </div>
                            
                            <div class="flex space-x-3 pt-2">
                                <?php if (isset($_GET['edit'])): ?>
                                    <button type="submit" name="perbarui_layanan" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Perbarui Layanan
                                    </button>
                                    <a href="layanan.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Batal
                                    </a>
                                <?php else: ?>
                                    <button type="submit" name="tambah_layanan" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Tambah Layanan
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Table Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">Daftar Layanan Tersedia</h2>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                <?= count($layanan) ?> Layanan
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Layanan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($layanan as $item): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $item['id_layanan'] ?></td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900"><?= $item['nama_layanan'] ?></div>
                                                <div class="text-sm text-gray-500"><?= substr($item['deskripsi'], 0, 50) ?>...</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                                Rp<?= number_format($item['harga'], 0, ',', '.') ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $item['durasi'] ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="layanan.php?edit=<?= $item['id_layanan'] ?>" class="text-blue-600 hover:text-blue-900 px-3 py-1 rounded-md hover:bg-blue-50 transition-colors">
                                                        Edit
                                                    </a>
                                                    <a href="layanan.php?hapus_layanan=<?= $item['id_layanan'] ?>" onclick="return confirm('Yakin ingin menghapus layanan ini?')" class="text-red-600 hover:text-red-900 px-3 py-1 rounded-md hover:bg-red-50 transition-colors">
                                                        Hapus
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
            </div>
        </div>
    </main>

<footer class="bg-indigo-100/60 dark:bg-indigo-900/60 backdrop-blur-md border-t border-indigo-200/30 dark:border-indigo-700/30 text-indigo-900 dark:text-indigo-100 py-5">
    <div class="container mx-auto px-4 text-center text-sm">
        <p>&copy; <?= date('Y') ?> Powered by RhazeDev</p>
        <p>Latest Login as ADMINISTRATOR</p>
    </div>
</footer>

    <script>
        // alert info
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.animate-fade-in');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '1';
                    alert.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>