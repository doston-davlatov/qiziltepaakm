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
            $title = sanitizeInput($_POST['title']);
            $content = sanitizeInput($_POST['content']);
            $is_published = isset($_POST['is_published']) ? 1 : 0;
            
            // Handle image upload
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = uploadFile($_FILES['image'], '../Uploads/news/');
                if (!$image) {
                    $error = 'Rasm yuklashda xatolik.';
                }
            }
            
            if (!$error && (empty($title) || empty($content))) {
                $error = 'Sarlavha va kontent majburiy.';
            }
            
            if (!$error) {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO news (title, content, image, author_id, is_published, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$title, $content, $image, $_SESSION['user_id'], $is_published]);
                    $success = 'Yangilik muvaffaqiyatli qo\'shildi.';
                    logActivity('News added: ' . $title);
                } else {
                    $news_id = $_POST['news_id'];
                    $update_query = "UPDATE news SET title=?, content=?, is_published=?, updated_at=NOW()";
                    $params = [$title, $content, $is_published];
                    
                    if ($image) {
                        $update_query .= ", image=?";
                        $params[] = $image;
                    }
                    
                    $update_query .= " WHERE id=?";
                    $params[] = $news_id;
                    
                    $stmt = $pdo->prepare($update_query);
                    $stmt->execute($params);
                    $success = 'Yangilik muvaffaqiyatli yangilandi.';
                    logActivity('News updated: ' . $title);
                }
            }
        } elseif ($action === 'delete') {
            $news_id = $_POST['news_id'];
            $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
            $stmt->execute([$news_id]);
            $success = 'Yangilik o\'chirildi.';
            logActivity('News deleted', null, "News ID: $news_id");
        } elseif ($action === 'bulk_delete') {
            if (!empty($_POST['selected_news'])) {
                $placeholders = implode(',', array_fill(0, count($_POST['selected_news']), '?'));
                $stmt = $pdo->prepare("DELETE FROM news WHERE id IN ($placeholders)");
                $stmt->execute($_POST['selected_news']);
                $success = 'Tanlangan yangiliklar o\'chirildi.';
                logActivity('Bulk news deleted', null, "News IDs: " . implode(', ', $_POST['selected_news']));
            } else {
                $error = 'Hech qanday yangilik tanlanmadi.';
            }
        }
    }
}

// Get news with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 10;
$offset = ($page - 1) * $per_page;

$search = $_GET['search'] ?? '';
$status_filter = $_GET['status'] ?? '';

$where_conditions = [];
$params = [];

if (!empty($search)) {
    $where_conditions[] = "(n.title LIKE ? OR n.content LIKE ?)";
    $search_param = "%{$search}%";
    $params[] = $search_param;
    $params[] = $search_param;
}

if ($status_filter !== '') {
    $where_conditions[] = "n.is_published = ?";
    $params[] = $status_filter;
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM news n $where_clause");
$stmt->execute($params);
$total_news = $stmt->fetchColumn();
$total_pages = ceil($total_news / $per_page);

$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       $where_clause 
                       ORDER BY n.created_at DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute($params);
$news = $stmt->fetchAll();

// Get news for editing
$edit_news = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_news = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Yangiliklar boshqaruvi</h1>
            <p class="text-gray-600">Yangiliklar qo'shish, tahrirlash va nashr qilish</p>
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

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Yangilik sarlavhasi yoki kontenti bo'yicha qidirish..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Barcha statuslar</option>
                        <option value="1" <?php echo $status_filter === '1' ? 'selected' : ''; ?>>Nashr qilingan</option>
                        <option value="0" <?php echo $status_filter === '0' ? 'selected' : ''; ?>>Qoralama</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Qidirish
                </button>
            </form>
        </div>

        <!-- Add/Edit News Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <?php echo $edit_news ? 'Yangilikni tahrirlash' : 'Yangi yangilik qo\'shish'; ?>
            </h2>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_news ? 'edit' : 'add'; ?>">
                <?php if ($edit_news): ?>
                    <input type="hidden" name="news_id" value="<?php echo $edit_news['id']; ?>">
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sarlavha *</label>
                    <input type="text" 
                           name="title" 
                           value="<?php echo $edit_news ? htmlspecialchars($edit_news['title']) : ''; ?>" 
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontent *</label>
                    <textarea name="content" 
                              rows="8" 
                              required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_news ? htmlspecialchars($edit_news['content']) : ''; ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rasm</label>
                    <input type="file" 
                           name="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($edit_news && $edit_news['image']): ?>
                        <p class="text-sm text-gray-500 mt-1">Hozirgi rasm: <?php echo htmlspecialchars($edit_news['image']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           value="1" 
                           <?php echo ($edit_news && $edit_news['is_published']) || !$edit_news ? 'checked' : ''; ?>
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Nashr qilish</span>
                </div>

                <div class="flex justify-end space-x-4">
                    <?php if ($edit_news): ?>
                        <a href="news.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Bekor qilish
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <?php echo $edit_news ? 'Yangilash' : 'Qo\'shish'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- News List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Yangiliklar ro'yxati</h2>
            </div>
            
            <form method="POST" id="bulkDeleteForm" onsubmit="return confirm('Tanlangan yangiliklarni o\'chirishni xohlaysizmi?')">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="bulk_delete">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <button type="button" id="selectAll" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Barchasini tanlash
                        </button>
                        <button type="button" id="deselectAll" class="text-blue-600 hover:text-blue-900 text-sm font-medium ml-4 hidden">
                            Tanlovni bekor qilish
                        </button>
                    </div>
                    <button type="submit" id="bulkDeleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 hidden">
                        Tanlanganlarni o'chirish
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAllCheckbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Yangilik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Muallif</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($news as $item): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_news[]" value="<?php echo $item['id']; ?>" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded news-checkbox">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-16">
                                                <img src="<?php echo $item['image'] ? '../Uploads/news/' . $item['image'] : '../images/default-news.jpg'; ?>" 
                                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                                     class="h-12 w-16 object-cover rounded">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                    <?php echo htmlspecialchars($item['title']); ?>
                                                </div>
                                                <div class="text-sm text-gray-500 line-clamp-1">
                                                    <?php echo htmlspecialchars(substr(strip_tags($item['content']), 0, 60)) . '...'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($item['is_published']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Nashr qilingan
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Qoralama
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo formatDate($item['created_at'], 'd.m.Y H:i'); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="?edit=<?php echo $item['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                            Tahrirlash
                                        </a>
                                        <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="news_id" value="<?php echo $item['id']; ?>">
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
            </form>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="mt-6 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Oldingi
                        </a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                           class="px-3 py-2 text-sm <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border border-gray-300 rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Keyingi<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Select All and Deselect All functionality
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.news-checkbox').forEach(checkbox => checkbox.checked = true);
        document.getElementById('selectAll').classList.add('hidden');
        document.getElementById('deselectAll').classList.remove('hidden');
        document.getElementById('bulkDeleteBtn').classList.remove('hidden');
    });

    document.getElementById('deselectAll').addEventListener('click', function() {
        document.querySelectorAll('.news-checkbox').forEach(checkbox => checkbox.checked = false);
        document.getElementById('selectAll').classList.remove('hidden');
        document.getElementById('deselectAll').classList.add('hidden');
        document.getElementById('bulkDeleteBtn').classList.add('hidden');
    });

    // Toggle bulk delete button visibility based on checkbox selection
    document.querySelectorAll('.news-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const anyChecked = Array.from(document.querySelectorAll('.news-checkbox')).some(cb => cb.checked);
            document.getElementById('bulkDeleteBtn').classList.toggle('hidden', !anyChecked);
        });
    });

    // Select all checkbox in header
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        document.querySelectorAll('.news-checkbox').forEach(checkbox => checkbox.checked = this.checked);
        document.getElementById('selectAll').classList.toggle('hidden', this.checked);
        document.getElementById('deselectAll').classList.toggle('hidden', !this.checked);
        document.getElementById('bulkDeleteBtn').classList.toggle('hidden', !this.checked);
    });
</script>

<?php require_once 'footer.php'; ?>