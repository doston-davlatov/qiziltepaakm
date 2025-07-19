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
            $description = sanitizeInput($_POST['description']);
            $event_date = $_POST['event_date'];
            $location = sanitizeInput($_POST['location']);
            $capacity = (int)$_POST['capacity'];
            $is_published = isset($_POST['is_published']) ? 1 : 0;
            
            // Handle image upload
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = uploadFile($_FILES['image'], '../Uploads/events/');
                if (!$image) {
                    $error = 'Rasm yuklashda xatolik.';
                }
            }
            
            if (!$error && (empty($title) || empty($event_date) || empty($location))) {
                $error = 'Sarlavha, sana va joy majburiy.';
            }
            
            if (!$error) {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date, location, capacity, image, organizer_id, is_published, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$title, $description, $event_date, $location, $capacity, $image, $_SESSION['user_id'], $is_published]);
                    $success = 'Tadbir muvaffaqiyatli qo\'shildi.';
                    logActivity('Event added: ' . $title);
                } else {
                    $event_id = $_POST['event_id'];
                    $update_query = "UPDATE events SET title=?, description=?, event_date=?, location=?, capacity=?, is_published=?, updated_at=NOW()";
                    $params = [$title, $description, $event_date, $location, $capacity, $is_published];
                    
                    if ($image) {
                        $update_query .= ", image=?";
                        $params[] = $image;
                    }
                    
                    $update_query .= " WHERE id=?";
                    $params[] = $event_id;
                    
                    $stmt = $pdo->prepare($update_query);
                    $stmt->execute($params);
                    $success = 'Tadbir muvaffaqiyatli yangilandi.';
                    logActivity('Event updated: ' . $title);
                }
            }
        } elseif ($action === 'delete') {
            $event_id = $_POST['event_id'];
            $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$event_id]);
            $success = 'Tadbir o\'chirildi.';
            logActivity('Event deleted', null, "Event ID: $event_id");
        } elseif ($action === 'bulk_delete') {
            if (!empty($_POST['selected_events'])) {
                $placeholders = implode(',', array_fill(0, count($_POST['selected_events']), '?'));
                $stmt = $pdo->prepare("DELETE FROM events WHERE id IN ($placeholders)");
                $stmt->execute($_POST['selected_events']);
                $success = 'Tanlangan tadbirlar o\'chirildi.';
                logActivity('Bulk events deleted', null, "Event IDs: " . implode(', ', $_POST['selected_events']));
            } else {
                $error = 'Hech qanday tadbir tanlanmadi.';
            }
        }
    }
}

// Get events with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 10;
$offset = ($page - 1) * $per_page;

$search = $_GET['search'] ?? '';
$status_filter = $_GET['status'] ?? '';
$date_filter = $_GET['date_filter'] ?? '';

$where_conditions = [];
$params = [];

if (!empty($search)) {
    $where_conditions[] = "(e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?)";
    $search_param = "%{$search}%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

if ($status_filter !== '') {
    $where_conditions[] = "e.is_published = ?";
    $params[] = $status_filter;
}

if ($date_filter === 'upcoming') {
    $where_conditions[] = "e.event_date >= NOW()";
} elseif ($date_filter === 'past') {
    $where_conditions[] = "e.event_date < NOW()";
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM events e $where_clause");
$stmt->execute($params);
$total_events = $stmt->fetchColumn();
$total_pages = ceil($total_events / $per_page);

$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       $where_clause 
                       ORDER BY e.event_date DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute($params);
$events = $stmt->fetchAll();

// Get event for editing
$edit_event = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_event = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tadbirlar boshqaruvi</h1>
            <p class="text-gray-600">Tadbirlar qo'shish, tahrirlash va boshqarish</p>
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
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" 
                           name="search" 
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Tadbir nomi, tavsifi yoki joyi..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Barcha statuslar</option>
                        <option value="1" <?php echo $status_filter === '1' ? 'selected' : ''; ?>>Nashr qilingan</option>
                        <option value="0" <?php echo $status_filter === '0' ? 'selected' : ''; ?>>Qoralama</option>
                    </select>
                </div>
                <div>
                    <select name="date_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Barcha tadbirlar</option>
                        <option value="upcoming" <?php echo $date_filter === 'upcoming' ? 'selected' : ''; ?>>Yaqinlashayotgan</option>
                        <option value="past" <?php echo $date_filter === 'past' ? 'selected' : ''; ?>>O'tgan</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Qidirish
                </button>
            </form>
        </div>

        <!-- Add/Edit Event Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <?php echo $edit_event ? 'Tadbirni tahrirlash' : 'Yangi tadbir qo\'shish'; ?>
            </h2>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_event ? 'edit' : 'add'; ?>">
                <?php if ($edit_event): ?>
                    <input type="hidden" name="event_id" value="<?php echo $edit_event['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tadbir nomi *</label>
                        <input type="text" 
                               name="title" 
                               value="<?php echo $edit_event ? htmlspecialchars($edit_event['title']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Joy *</label>
                        <input type="text" 
                               name="location" 
                               value="<?php echo $edit_event ? htmlspecialchars($edit_event['location']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sana va vaqt *</label>
                        <input type="datetime-local" 
                               name="event_date" 
                               value="<?php echo $edit_event ? date('Y-m-d\TH:i', strtotime($edit_event['event_date'])) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sig'im</label>
                        <input type="number" 
                               name="capacity" 
                               value="<?php echo $edit_event ? $edit_event['capacity'] : ''; ?>" 
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tavsif</label>
                    <textarea name="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_event ? htmlspecialchars($edit_event['description']) : ''; ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rasm</label>
                    <input type="file" 
                           name="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($edit_event && $edit_event['image']): ?>
                        <p class="text-sm text-gray-500 mt-1">Hozirgi rasm: <?php echo htmlspecialchars($edit_event['image']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           value="1" 
                           <?php echo ($edit_event && $edit_event['is_published']) || !$edit_event ? 'checked' : ''; ?>
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Nashr qilish</span>
                </div>

                <div class="flex justify-end space-x-4">
                    <?php if ($edit_event): ?>
                        <a href="events.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Bekor qilish
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <?php echo $edit_event ? 'Yangilash' : 'Qo\'shish'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Events List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Tadbirlar ro'yxati</h2>
            </div>
            
            <form method="POST" id="bulkDeleteForm" onsubmit="return confirm('Tanlangan tadbirlarni o\'chirishni xohlaysizmi?')">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tadbir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joy</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ishtirokchilar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_events[]" value="<?php echo $event['id']; ?>" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded event-checkbox">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-16">
                                                <img src="<?php echo $event['image'] ? '../Uploads/events/' . $event['image'] : '../images/default-event.jpg'; ?>" 
                                                     alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                                     class="h-12 w-16 object-cover rounded">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($event['title']); ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo htmlspecialchars($event['first_name'] . ' ' . $event['last_name']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo formatDate($event['event_date'], 'd.m.Y H:i'); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($event['location']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo $event['registered_count']; ?>/<?php echo $event['capacity'] ?: '∞'; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <?php if ($event['is_published']): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Nashr qilingan
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Qoralama
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if (strtotime($event['event_date']) > time()): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Yaqinlashayotgan
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    O'tgan
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="?edit=<?php echo $event['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                            Tahrirlash
                                        </a>
                                        <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
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
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&date_filter=<?php echo urlencode($date_filter); ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Oldingi
                        </a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&date_filter=<?php echo urlencode($date_filter); ?>" 
                           class="px-3 py-2 text-sm <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border border-gray-300 rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&date_filter=<?php echo urlencode($date_filter); ?>" 
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
        document.querySelectorAll('.event-checkbox').forEach(checkbox => checkbox.checked = true);
        document.getElementById('selectAll').classList.add('hidden');
        document.getElementById('deselectAll').classList.remove('hidden');
        document.getElementById('bulkDeleteBtn').classList.remove('hidden');
    });

    document.getElementById('deselectAll').addEventListener('click', function() {
        document.querySelectorAll('.event-checkbox').forEach(checkbox => checkbox.checked = false);
        document.getElementById('selectAll').classList.remove('hidden');
        document.getElementById('deselectAll').classList.add('hidden');
        document.getElementById('bulkDeleteBtn').classList.add('hidden');
    });

    // Toggle bulk delete button visibility based on checkbox selection
    document.querySelectorAll('.event-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const anyChecked = Array.from(document.querySelectorAll('.event-checkbox')).some(cb => cb.checked);
            document.getElementById('bulkDeleteBtn').classList.toggle('hidden', !anyChecked);
        });
    });

    // Select all checkbox in header
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        document.querySelectorAll('.event-checkbox').forEach(checkbox => checkbox.checked = this.checked);
        document.getElementById('selectAll').classList.toggle('hidden', this.checked);
        document.getElementById('deselectAll').classList.toggle('hidden', !this.checked);
        document.getElementById('bulkDeleteBtn').classList.toggle('hidden', !this.checked);
    });
</script>

<?php require_once 'footer.php'; ?>