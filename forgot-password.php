<?php
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $csrf_token = $_POST['csrf_token'];
    
    // Verify CSRF token
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi. Iltimos, qayta urinib ko\'ring.';
    } else {
        // Validate email
        if (empty($email) || !validateEmail($email)) {
            $error = 'Noto\'g\'ri email format.';
        } else {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id, first_name, last_name FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Generate reset token
                $reset_token = bin2hex(random_bytes(32));
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Save reset token to database
                $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at, created_at) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at), created_at = NOW()");
                $stmt->execute([$user['id'], $reset_token, $expires_at]);
                
                // In a real application, you would send an email here
                // For demo purposes, we'll just show a success message
                $success = 'Parolni tiklash havolasi email manzilingizga yuborildi. Iltimos, email qutingizni tekshiring.';
                
                logActivity('Password reset requested', $user['id'], "Email: $email");
            } else {
                // Don't reveal if email exists or not for security
                $success = 'Agar bu email manzil tizimda mavjud bo\'lsa, parolni tiklash havolasi yuboriladi.';
            }
        }
    }
}
?>

<main class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Parolni tiklash</h2>
            <p class="text-gray-600">Email manzilingizni kiriting</p>
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
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email manzil
                    </label>
                    <div class="mt-1">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="example@email.com">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane mr-2"></i>Tiklash havolasini yuborish
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Parolingizni esladingizmi? 
                    <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">
                        Kirish
                    </a>
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>