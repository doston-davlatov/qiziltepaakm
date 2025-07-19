<?php
require_once 'header.php';

// Check if user is admin
if (!isAdmin()) {
    redirect('../login.php');
}

$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $csrf_token = $_POST['csrf_token'];
    
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        if ($action === 'add' || $action === 'edit') {
            $name = sanitizeInput($_POST['name']);
            $address = sanitizeInput($_POST['address']);
            $phone = sanitizeInput($_POST['phone']);
            $email = sanitizeInput($_POST['email']);
            $website = sanitizeInput($_POST['website']);
            
            if (empty($name)) {
                $error = 'Nashriyot nomi majburiy.';
            } else {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO publishers (name, address, phone, email, website, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$name, $address, $phone, $email, $website]);
                    $success = 'Nashriyot muvaffaqiyatli qo\'shildi.';
                    logActivity('Publisher added: ' . $name);
                } else {
                    $publisher_id = $_POST['publisher_id'];
                    $stmt = $pdo->prepare("UPDATE publishers SET name=?, address=?, phone=?, email=?, website=?, updated_at=NOW() WHERE id=?");
                    $stmt->execute([$name, $address, $phone, $email, $website, $publisher_id]);
                    $success = 'Nashriyot muvaffaqiyatli yangilandi.';
                    logActivity('Publisher updated: ' . $name);
                }
            }
        } elseif ($action === 'delete') {
            $publisher_id = $_POST['publisher_id'];
            
            // Check if publisher has books
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM books WHERE publisher_id = ?");
            $stmt->execute([$publisher_id]);
            $book_count = $stmt->fetchColumn();
            
            if ($book_count > 0) {
                $error = 'Bu nashriyotning kitoblari mavjud. Avval kitoblarni boshqa nashriyotga o\'tkazing.';
            } else {
                $stmt = $pdo->prepare("DELETE FROM publishers WHERE id = ?");
                $stmt->execute([$publisher_id]);
                $success = 'Nashriyot o\'chirildi.';
                logActivity('Publisher deleted', null, "Publisher ID: $publisher_id");
            }
        }
    }
}

// Get publishers with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 15;
$offset = ($page - 1) * $per_page;

$search = $_GET['search'] ?? '';
$where_clause = '';
$params = [];

if (!empty($search)) {
    $where_clause = 'WHERE name LIKE ? OR address LIKE ? OR email LIKE ?';
    $search_param = "%{$search}%";
    $params = [$search_param, $search_param, $search_param];
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM publishers $where_clause");
$stmt->execute($params);
$total_publishers = $stmt->fetchColumn();
$total_pages = ceil($total_publishers / $per_page);

$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare("SELECT p.*, COUNT(b.id) as book_count FROM publishers p 
                       LEFT JOIN books b ON p.id = b.publisher_id 
                       $where_clause 
                       GROUP BY p.id 
                       ORDER BY p.created_at DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute($params);
$publishers = $stmt->fetchAll();

// Get publisher for editing
$edit_publisher = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM publishers WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_publisher = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Nashriyotlar boshqaruvi</h1>
            <p class="text-gray-600">Nashriyotlarni qo'shish, tahrirlash va boshqarish</p>
        </div>

        <!-- Messages -->
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-triangle mr-2"></i><?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i><?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Nashriyot nomi, manzil yoki email bo'yicha qidirish..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Qidirish
                </button>
            </form>
        </div>

        <!-- Add/Edit Publisher Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <?php echo $edit_publisher ? 'Nashriyotni tahrirlash' : 'Yangi nashriyot qo\'shish'; ?>
            </h2>
            
            <form method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_publisher ? 'edit' : 'add'; ?>">
                <?php if ($edit_publisher): ?>
                    <input type="hidden" name="publisher_id" value="<?php echo $edit_publisher['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nashriyot nomi *</label>
                        <input type="text" 
                               name="name" 
                               value="<?php echo $edit_publisher ? htmlspecialchars($edit_publisher['name']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="<?php echo $edit_publisher ? htmlspecialchars($edit_publisher['email']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                        <input type="tel" 
                               name="phone" 
                               value="<?php echo $edit_publisher ? htmlspecialchars($edit_publisher['phone']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Veb-sayt</label>
                        <input type="url" 
                               name="website" 
                               value="<?php echo $edit_publisher ? htmlspecialchars($edit_publisher['website']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Manzil</label>
                    <textarea name="address" 
                              rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_publisher ? htmlspecialchars($edit_publisher['address']) : ''; ?></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <?php if ($edit_publisher): ?>
                        <a href="publishers.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Bekor qilish
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <?php echo $edit_publisher ? 'Yangilash' : 'Qo\'shish'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Publishers List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Nashriyotlar ro'yxati</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nashriyot</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aloqa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kitoblar soni</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($publishers as $publisher): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-building text-indigo-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($publisher['name']); ?></div>
                                            <div class="text-sm text-gray-500">
                                                <?php if ($publisher['address']): ?>
                                                    <?php echo htmlspecialchars(substr($publisher['address'], 0, 50)) . '...'; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php if ($publisher['email']): ?>
                                            <div><i class="fas fa-envelope mr-1"></i><?php echo htmlspecialchars($publisher['email']); ?></div>
                                        <?php endif; ?>
                                        <?php if ($publisher['phone']): ?>
                                            <div><i class="fas fa-phone mr-1"></i><?php echo htmlspecialchars($publisher['phone']); ?></div>
                                        <?php endif; ?>
                                        <?php if ($publisher['website']): ?>
                                            <div><i class="fas fa-globe mr-1"></i><a href="<?php echo htmlspecialchars($publisher['website']); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">Sayt</a></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?php echo $publisher['book_count']; ?> ta kitob
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="?edit=<?php echo $publisher['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                        Tahrirlash
                                    </a>
                                    <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="publisher_id" value="<?php echo $publisher['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            O'chirish
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="mt-6 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Oldingi
                        </a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 py-2 text-sm <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border border-gray-300 rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Keyingi<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'footer.php'; ?>