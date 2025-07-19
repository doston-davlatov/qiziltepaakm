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
            $description = sanitizeInput($_POST['description']);
            
            if (empty($name)) {
                $error = 'Janr nomi majburiy.';
            } else {
                if ($action === 'add') {
                    // Check if genre already exists
                    $stmt = $pdo->prepare("SELECT id FROM genres WHERE name = ?");
                    $stmt->execute([$name]);
                    if ($stmt->fetch()) {
                        $error = 'Bu janr allaqachon mavjud.';
                    } else {
                        $stmt = $pdo->prepare("INSERT INTO genres (name, description, created_at) VALUES (?, ?, NOW())");
                        $stmt->execute([$name, $description]);
                        $success = 'Janr muvaffaqiyatli qo\'shildi.';
                        logActivity('Genre added: ' . $name);
                    }
                } else {
                    $genre_id = $_POST['genre_id'];
                    $stmt = $pdo->prepare("UPDATE genres SET name=?, description=?, updated_at=NOW() WHERE id=?");
                    $stmt->execute([$name, $description, $genre_id]);
                    $success = 'Janr muvaffaqiyatli yangilandi.';
                    logActivity('Genre updated: ' . $name);
                }
            }
        } elseif ($action === 'delete') {
            $genre_id = $_POST['genre_id'];
            
            // Check if genre has books
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM books WHERE genre_id = ?");
            $stmt->execute([$genre_id]);
            $book_count = $stmt->fetchColumn();
            
            if ($book_count > 0) {
                $error = 'Bu janrda kitoblar mavjud. Avval kitoblarni boshqa janrga o\'tkazing.';
            } else {
                $stmt = $pdo->prepare("DELETE FROM genres WHERE id = ?");
                $stmt->execute([$genre_id]);
                $success = 'Janr o\'chirildi.';
                logActivity('Genre deleted', null, "Genre ID: $genre_id");
            }
        }
    }
}

// Get genres with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 20;
$offset = ($page - 1) * $per_page;

$search = $_GET['search'] ?? '';
$where_clause = '';
$params = [];

if (!empty($search)) {
    $where_clause = 'WHERE name LIKE ? OR description LIKE ?';
    $search_param = "%{$search}%";
    $params = [$search_param, $search_param];
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM genres $where_clause");
$stmt->execute($params);
$total_genres = $stmt->fetchColumn();
$total_pages = ceil($total_genres / $per_page);

$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare("SELECT g.*, COUNT(b.id) as book_count FROM genres g 
                       LEFT JOIN books b ON g.id = b.genre_id 
                       $where_clause 
                       GROUP BY g.id 
                       ORDER BY g.name ASC 
                       LIMIT ? OFFSET ?");
$stmt->execute($params);
$genres = $stmt->fetchAll();

// Get genre for editing
$edit_genre = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM genres WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_genre = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Janrlar boshqaruvi</h1>
            <p class="text-gray-600">Kitob janrlarini qo'shish, tahrirlash va boshqarish</p>
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
                           placeholder="Janr nomi yoki tavsifi bo'yicha qidirish..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Qidirish
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add/Edit Genre Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <?php echo $edit_genre ? 'Janrni tahrirlash' : 'Yangi janr qo\'shish'; ?>
                    </h2>
                    
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <input type="hidden" name="action" value="<?php echo $edit_genre ? 'edit' : 'add'; ?>">
                        <?php if ($edit_genre): ?>
                            <input type="hidden" name="genre_id" value="<?php echo $edit_genre['id']; ?>">
                        <?php endif; ?>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Janr nomi *</label>
                            <input type="text" 
                                   name="name" 
                                   value="<?php echo $edit_genre ? htmlspecialchars($edit_genre['name']) : ''; ?>" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Masalan: Badiy adabiyot">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tavsif</label>
                            <textarea name="description" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Janr haqida qisqacha ma'lumot..."><?php echo $edit_genre ? htmlspecialchars($edit_genre['description']) : ''; ?></textarea>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <?php if ($edit_genre): ?>
                                <a href="genres.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                    Bekor qilish
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                <?php echo $edit_genre ? 'Yangilash' : 'Qo\'shish'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Genres List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Janrlar ro'yxati</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Janr</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kitoblar soni</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($genres as $genre): ?>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                        <i class="fas fa-tags text-green-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($genre['name']); ?></div>
                                                    <div class="text-sm text-gray-500">
                                                        <?php if ($genre['description']): ?>
                                                            <?php echo htmlspecialchars(substr($genre['description'], 0, 60)) . '...'; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <?php echo $genre['book_count']; ?> ta kitob
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="?edit=<?php echo $genre['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                                Tahrirlash
                                            </a>
                                            <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="genre_id" value="<?php echo $genre['id']; ?>">
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
        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>