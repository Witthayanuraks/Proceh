<?php
include 'config.php';

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_pemesanan'])) {
        $stmt = $pdo->prepare("INSERT INTO jadwal_pemesanan (id_layanan, nama_pelanggan, email_pelanggan, tanggal_pemesanan, tanggal_berangkat, jumlah_penumpang, permintaan_khusus, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['id_layanan'],
            $_POST['nama_pelanggan'],
            $_POST['email_pelanggan'],
            $_POST['tanggal_pemesanan'],
            $_POST['tanggal_berangkat'],
            $_POST['jumlah_penumpang'],
            $_POST['permintaan_khusus'],
            $_POST['status']
        ]);
        $sukses = "Pemesanan berhasil ditambahkan!";
    } elseif (isset($_POST['perbarui_pemesanan'])) {
        $stmt = $pdo->prepare("UPDATE jadwal_pemesanan SET id_layanan = ?, nama_pelanggan = ?, email_pelanggan = ?, tanggal_pemesanan = ?, tanggal_berangkat = ?, jumlah_penumpang = ?, permintaan_khusus = ?, status = ? WHERE id_pemesanan = ?");
        $stmt->execute([
            $_POST['id_layanan'],
            $_POST['nama_pelanggan'],
            $_POST['email_pelanggan'],
            $_POST['tanggal_pemesanan'],
            $_POST['tanggal_berangkat'],
            $_POST['jumlah_penumpang'],
            $_POST['permintaan_khusus'],
            $_POST['status'],
            $_POST['id_pemesanan']
        ]);
        $sukses = "Pemesanan berhasil diperbarui!";
    }
}

// Hapus pemesanan
if (isset($_GET['hapus_pemesanan'])) {
    $stmt = $pdo->prepare("DELETE FROM jadwal_pemesanan WHERE id_pemesanan = ?");
    $stmt->execute([$_GET['hapus_pemesanan']]);
    $sukses = "Pemesanan berhasil dihapus!";
}

// Ambil semua pemesanan dengan nama layanan
$pemesanan = $pdo->query("
    SELECT p.*, l.nama_layanan 
    FROM jadwal_pemesanan p
    LEFT JOIN layanan_perjalanan l ON p.id_layanan = l.id_layanan
    ORDER BY p.tanggal_pemesanan DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua layanan untuk dropdown
$layanan = $pdo->query("SELECT * FROM layanan_perjalanan")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Manajemen Pemesanan | Info-IN</title>
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
               Info-IN.aja | Pemesanan
            </h1>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="layanan.php" class="font-medium px-3 py-2 rounded hover:bg-blue-700 transition-colors">Layanan</a></li>
                    <li><a href="pemesanan.php" class="font-medium px-3 py-2 rounded bg-blue-700 hover:bg-blue-700 transition-colors">Pemesanan</a></li>
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
                            <?= isset($_GET['edit']) ? 'Edit Pemesanan' : 'Tambah Pemesanan Baru' ?>
                        </h2>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="id_pemesanan" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
                            
                            <div>
                                <label for="id_layanan" class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                                <select id="id_layanan" name="id_layanan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">Pilih Layanan</option>
                                    <?php foreach ($layanan as $item): ?>
                                        <option value="<?= $item['id_layanan'] ?>" 
                                            <?= (isset($_GET['edit']) && $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['id_layanan'] == $item['id_layanan']) ? 'selected' : '' ?>>
                                            <?= $item['nama_layanan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required
                                           value="<?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['nama_pelanggan'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label for="email_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" id="email_pelanggan" name="email_pelanggan" required
                                           value="<?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['email_pelanggan'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="tanggal_pemesanan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pemesanan</label>
                                    <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" required
                                           value="<?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['tanggal_pemesanan'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label for="tanggal_berangkat" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat</label>
                                    <input type="date" id="tanggal_berangkat" name="tanggal_berangkat" required
                                           value="<?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['tanggal_berangkat'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="jumlah_penumpang" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Penumpang</label>
                                    <input type="number" id="jumlah_penumpang" name="jumlah_penumpang" min="1" required
                                           value="<?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['jumlah_penumpang'] : '' ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option value="menunggu" <?= (isset($_GET['edit']) && $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['status'] == 'menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="dikonfirmasi" <?= (isset($_GET['edit']) && $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['status'] == 'dikonfirmasi') ? 'selected' : '' ?>>Dikonfirmasi</option>
                                        <option value="dibatalkan" <?= (isset($_GET['edit']) && $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['status'] == 'dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="permintaan_khusus" class="block text-sm font-medium text-gray-700 mb-1">Permintaan Khusus</label>
                                <textarea id="permintaan_khusus" name="permintaan_khusus" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"><?= isset($_GET['edit']) ? $pemesanan[array_search($_GET['edit'], array_column($pemesanan, 'id_pemesanan'))]['permintaan_khusus'] : '' ?></textarea>
                            </div>
                            
                            <div class="flex space-x-3 pt-2">
                                <?php if (isset($_GET['edit'])): ?>
                                    <button type="submit" name="perbarui_pemesanan" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Perbarui Pemesanan
                                    </button>
                                    <a href="pemesanan.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Batal
                                    </a>
                                <?php else: ?>
                                    <button type="submit" name="tambah_pemesanan" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow">
                                        Tambah Pemesanan
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
                            <h2 class="text-xl font-semibold text-gray-800">Daftar Pemesanan</h2>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                <?= count($pemesanan) ?> Pemesanan
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($pemesanan as $item): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $item['id_pemesanan'] ?></td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900"><?= $item['nama_layanan'] ?></div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-semibold text-gray-900"><?= $item['nama_pelanggan'] ?></div>
                                                <div class="text-sm text-gray-500"><?= $item['email_pelanggan'] ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?= date('d M Y', strtotime($item['tanggal_berangkat'])) ?></div>
                                                <div class="text-xs text-gray-500"><?= date('d M Y', strtotime($item['tanggal_pemesanan'])) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                $statusClass = '';
                                                if ($item['status'] == 'dikonfirmasi') $statusClass = 'status-dikonfirmasi';
                                                elseif ($item['status'] == 'dibatalkan') $statusClass = 'status-dibatalkan';
                                                else $statusClass = 'status-menunggu';
                                                ?>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full <?= $statusClass ?>">
                                                    <?= ucfirst($item['status']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="pemesanan.php?edit=<?= $item['id_pemesanan'] ?>" class="text-blue-600 hover:text-blue-900 px-3 py-1 rounded-md hover:bg-blue-50 transition-colors">
                                                        Edit
                                                    </a>
                                                    <a href="pemesanan.php?hapus_pemesanan=<?= $item['id_pemesanan'] ?>" onclick="return confirm('Yakin ingin menghapus pemesanan ini?')" class="text-red-600 hover:text-red-900 px-3 py-1 rounded-md hover:bg-red-50 transition-colors">
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
        // Animasi untuk alert
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