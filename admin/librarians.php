<?php
require_once 'header.php';
require_once '../includes/db_connect.php';

// Check if user is admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'];
    
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        $action = $_POST['action'];
        
        if ($action === 'add' || $action === 'edit') {
            $full_name = sanitizeInput($_POST['full_name']);
            $position = sanitizeInput($_POST['position']);
            $department = sanitizeInput($_POST['department']);
            $phone = sanitizeInput($_POST['phone']);
            $email = sanitizeInput($_POST['email']);
            $bio = sanitizeInput($_POST['bio']);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            // Handle image upload
            $image_path = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_path = uploadsFile($_FILES['image'], '../uploads/librarians/');
                if (!$image_path) {
                    $error = 'Rasm yuklashda xatolik.';
                }
            }
            
            if (!$error) {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO librarians (full_name, position, department, phone, email, image_path, bio, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$full_name, $position, $department, $phone, $email, $image_path, $bio, $is_active]);
                    $success = 'Kutubxonachi muvaffaqiyatli qo\'shildi.';
                } else {
                    $librarian_id = $_POST['librarian_id'];
                    $update_query = "UPDATE librarians SET full_name=?, position=?, department=?, phone=?, email=?, bio=?, is_active=?, updated_at=NOW()";
                    $params = [$full_name, $position, $department, $phone, $email, $bio, $is_active];
                    
                    if ($image_path) {
                        $update_query .= ", image_path=?";
                        $params[] = $image_path;
                    }
                    
                    $update_query .= " WHERE id=?";
                    $params[] = $librarian_id;
                    
                    $stmt = $pdo->prepare($update_query);
                    $stmt->execute($params);
                    $success = 'Kutubxonachi ma\'lumotlari yangilandi.';
                }
            }
        } elseif ($action === 'delete') {
            $librarian_id = $_POST['librarian_id'];
            $stmt = $pdo->prepare("DELETE FROM librarians WHERE id = ?");
            $stmt->execute([$librarian_id]);
            $success = 'Kutubxonachi o\'chirildi.';
        }
    }
}

// Get librarians
$stmt = $pdo->prepare("SELECT * FROM librarians ORDER BY full_name");
$stmt->execute();
$librarians = $stmt->fetchAll();

// Get librarian for editing
$edit_librarian = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM librarians WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_librarian = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kutubxonachilar boshqaruvi</h1>
            <p class="text-gray-600">Kutubxonachilarni qo'shish, tahrirlash va o'chirish</p>
        </div>

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

        <!-- Add/Edit Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <?php echo $edit_librarian ? 'Kutubxonachini tahrirlash' : 'Yangi kutubxonachi qo\'shish'; ?>
            </h2>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_librarian ? 'edit' : 'add'; ?>">
                <?php if ($edit_librarian): ?>
                    <input type="hidden" name="librarian_id" value="<?php echo $edit_librarian['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To'liq ismi *</label>
                        <input type="text" 
                               name="full_name" 
                               value="<?php echo $edit_librarian ? htmlspecialchars($edit_librarian['full_name']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lavozimi *</label>
                        <input type="text" 
                               name="position" 
                               value="<?php echo $edit_librarian ? htmlspecialchars($edit_librarian['position']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bo'lim</label>
                        <input type="text" 
                               name="department" 
                               value="<?php echo $edit_librarian ? htmlspecialchars($edit_librarian['department']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                        <input type="tel" 
                               name="phone" 
                               value="<?php echo $edit_librarian ? htmlspecialchars($edit_librarian['phone']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="<?php echo $edit_librarian ? htmlspecialchars($edit_librarian['email']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Holati</label>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   <?php echo ($edit_librarian && $edit_librarian['is_active']) || !$edit_librarian ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Faol</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rasm</label>
                    <input type="file" 
                           name="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($edit_librarian && $edit_librarian['image_path']): ?>
                        <p class="text-sm text-gray-500 mt-1">Hozirgi rasm: <?php echo htmlspecialchars($edit_librarian['image_path']); ?></p>
                        <img src="../<?php echo htmlspecialchars($edit_librarian['image_path']); ?>" alt="Kutubxonachi rasmi" class="h-32 mt-2">
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Qisqacha ma'lumot</label>
                    <textarea name="bio" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_librarian ? htmlspecialchars($edit_librarian['bio']) : ''; ?></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <?php if ($edit_librarian): ?>
                        <a href="librarians.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Bekor qilish
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <?php echo $edit_librarian ? 'Yangilash' : 'Qo\'shish'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Librarians List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Kutubxonachilar ro'yxati</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rasm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ismi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lavozimi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bo'lim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Holati</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($librarians as $librarian): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($librarian['image_path']): ?>
                                        <img src="../<?php echo htmlspecialchars($librarian['image_path']); ?>" alt="<?php echo htmlspecialchars($librarian['full_name']); ?>" class="h-12 w-12 rounded-full object-cover">
                                    <?php else: ?>
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($librarian['full_name']); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($librarian['email']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($librarian['position']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($librarian['department']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($librarian['is_active']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Faol
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Faol emas
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="?edit=<?php echo $librarian['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                        Tahrirlash
                                    </a>
                                    <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="librarian_id" value="<?php echo $librarian['id']; ?>">
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
    </div>
</main>

<?php require_once 'footer.php'; ?>