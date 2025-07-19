<?php
require_once './includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    redirect('login.php');
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf_token = $_POST['csrf_token'];
    
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        if ($action === 'update_profile') {
            $first_name = sanitizeInput($_POST['first_name']);
            $last_name = sanitizeInput($_POST['last_name']);
            $phone = sanitizeInput($_POST['phone']);
            $address = sanitizeInput($_POST['address']);
            
            if (empty($first_name) || empty($last_name)) {
                $error = 'Ism va familiya majburiy.';
            } else {
                $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, address = ?, updated_at = NOW() WHERE id = ?");
                if ($stmt->execute([$first_name, $last_name, $phone, $address, $user_id])) {
                    $success = 'Profil muvaffaqiyatli yangilandi.';
                    logActivity('Profile updated', $user_id);
                    // Refresh user data
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->execute([$user_id]);
                    $user = $stmt->fetch();
                } else {
                    $error = 'Profil yangilashda xatolik.';
                }
            }
        } elseif ($action === 'change_password') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if (empty($current_password) || empty($new_password)) {
                $error = 'Barcha parol maydonlarini to\'ldiring.';
            } elseif (!verifyPassword($current_password, $user['password'])) {
                $error = 'Joriy parol noto\'g\'ri.';
            } elseif (strlen($new_password) < 8) {
                $error = 'Yangi parol kamida 8 belgidan iborat bo\'lishi kerak.';
            } elseif ($new_password !== $confirm_password) {
                $error = 'Yangi parollar mos kelmadi.';
            } else {
                $hashed_password = hashPassword($new_password);
                $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
                if ($stmt->execute([$hashed_password, $user_id])) {
                    $success = 'Parol muvaffaqiyatli o\'zgartirildi.';
                    logActivity('Password changed', $user_id);
                } else {
                    $error = 'Parol o\'zgartirishda xatolik.';
                }
            }
        }
    }
}

// Get user's borrowed books
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name, br.borrow_date, br.due_date, br.status 
                       FROM borrowings br 
                       JOIN books b ON br.book_id = b.id 
                       JOIN authors a ON b.author_id = a.id 
                       WHERE br.user_id = ? 
                       ORDER BY br.borrow_date DESC 
                       LIMIT 10");
$stmt->execute([$user_id]);
$borrowed_books = $stmt->fetchAll();

// Get user's activity log
$stmt = $pdo->prepare("SELECT * FROM activity_log WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$activities = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo translate('profile'); ?></h1>
            <p class="text-gray-600">Shaxsiy ma'lumotlaringizni boshqaring</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Update Profile Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Shaxsiy ma'lumotlar</h2>
                    
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <input type="hidden" name="action" value="update_profile">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ism *</label>
                                <input type="text" 
                                       name="first_name" 
                                       value="<?php echo htmlspecialchars($user['first_name']); ?>" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Familiya *</label>
                                <input type="text" 
                                       name="last_name" 
                                       value="<?php echo htmlspecialchars($user['last_name']); ?>" 
                                       required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" 
                                   disabled 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                            <p class="text-sm text-gray-500 mt-1">Email manzilni o'zgartirib bo'lmaydi</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone']); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manzil</label>
                            <textarea name="address" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-save mr-2"></i>Saqlash
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Parolni o'zgartirish</h2>
                    
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <input type="hidden" name="action" value="change_password">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Joriy parol *</label>
                            <input type="password" 
                                   name="current_password" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Yangi parol *</label>
                            <input type="password" 
                                   name="new_password" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Kamida 8 belgidan iborat bo'lishi kerak</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Yangi parolni tasdiqlang *</label>
                            <input type="password" 
                                   name="confirm_password" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-300">
                                <i class="fas fa-key mr-2"></i>Parolni o'zgartirish
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Profile Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-3xl text-blue-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                        </h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Rol:</span>
                                <span class="font-medium"><?php echo ucfirst($user['role']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Ro'yxatdan o'tgan:</span>
                                <span class="font-medium"><?php echo formatDate($user['created_at'], 'd.m.Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistika</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Olingan kitoblar:</span>
                            <span class="font-semibold text-blue-600"><?php echo count($borrowed_books); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Qaytarilgan:</span>
                            <span class="font-semibold text-green-600">
                                <?php echo count(array_filter($borrowed_books, function($b) { return $b['status'] === 'returned'; })); ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Qo'lda:</span>
                            <span class="font-semibold text-orange-600">
                                <?php echo count(array_filter($borrowed_books, function($b) { return $b['status'] === 'borrowed'; })); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tezkor amallar</h3>
                    <div class="space-y-2">
                        <a href="catalog.php" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-search mr-2"></i>Kitob qidirish
                        </a>
                        <a href="events.php" class="flex items-center text-green-600 hover:text-green-800">
                            <i class="fas fa-calendar mr-2"></i>Tadbirlar
                        </a>
                        <a href="news.php" class="flex items-center text-purple-600 hover:text-purple-800">
                            <i class="fas fa-newspaper mr-2"></i>Yangiliklar
                        </a>
                        <a href="contact.php" class="flex items-center text-gray-600 hover:text-gray-800">
                            <i class="fas fa-envelope mr-2"></i>Bog'lanish
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowed Books -->
        <?php if (!empty($borrowed_books)): ?>
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Olingan kitoblar</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kitob</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Muallif</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Olingan sana</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qaytarish sanasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($borrowed_books as $book): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($book['title']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo htmlspecialchars($book['author_name']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo formatDate($book['borrow_date'], 'd.m.Y'); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo formatDate($book['due_date'], 'd.m.Y'); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($book['status'] === 'returned'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Qaytarilgan
                                            </span>
                                        <?php elseif ($book['status'] === 'borrowed'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Qo'lda
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Kechikkan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>