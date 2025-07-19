<?php
require_once '../includes/header.php';

$error = '';
$success = '';
$valid_token = false;

// Check if token is provided and valid
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verify token
    $stmt = $pdo->prepare("SELECT pr.*, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token = ? AND pr.expires_at > NOW() AND pr.used = 0");
    $stmt->execute([$token]);
    $reset_data = $stmt->fetch();
    
    if ($reset_data) {
        $valid_token = true;
    } else {
        $error = 'Noto\'g\'ri yoki muddati o\'tgan havola.';
    }
} else {
    $error = 'Tiklash havolasi topilmadi.';
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $csrf_token = $_POST['csrf_token'];
    
    // Verify CSRF token
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        // Validate passwords
        if (empty($new_password) || strlen($new_password) < 8) {
            $error = 'Parol kamida 8 belgidan iborat bo\'lishi kerak.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Parollar mos kelmadi.';
        } else {
            // Update password
            $hashed_password = hashPassword($new_password);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
            
            if ($stmt->execute([$hashed_password, $reset_data['user_id']])) {
                // Mark token as used
                $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
                $stmt->execute([$token]);
                
                $success = 'Parolingiz muvaffaqiyatli o\'zgartirildi. Endi yangi parol bilan kirishingiz mumkin.';
                logActivity('Password reset completed', $reset_data['user_id']);
            } else {
                $error = 'Parolni o\'zgartirishda xatolik yuz berdi.';
            }
        }
    }
}
?>

<main class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Yangi parol o'rnatish</h2>
            <p class="text-gray-600">Yangi parolingizni kiriting</p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-triangle mr-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i><?php echo $success; ?>
                    <div class="mt-4">
                        <a href="login.php" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                            Kirish sahifasiga o'tish
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($valid_token && !$success): ?>
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">
                            Yangi parol
                        </label>
                        <div class="mt-1">
                            <input id="new_password" 
                                   name="new_password" 
                                   type="password" 
                                   required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="••••••••">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Kamida 8 belgidan iborat bo'lishi kerak</p>
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                            Parolni tasdiqlang
                        </label>
                        <div class="mt-1">
                            <input id="confirm_password" 
                                   name="confirm_password" 
                                   type="password" 
                                   required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-key mr-2"></i>Parolni o'zgartirish
                        </button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">
                        Kirish sahifasiga qaytish
                    </a>
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>