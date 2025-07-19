<?php
// require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/config.php';
require_once 'includes/db_connect.php';


$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $csrf_token = $_POST['csrf_token'];
    
    // Verify CSRF token
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi. Iltimos, qayta urinib ko\'ring.';
    } else {
        // Validate inputs
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $error = 'Barcha majburiy maydonlarni to\'ldiring.';
        } elseif (!validateEmail($email)) {
            $error = 'Noto\'g\'ri email format.';
        } elseif (strlen($password) < 8) {
            $error = 'Parol kamida 8 belgidan iborat bo\'lishi kerak.';
        } elseif ($password !== $confirm_password) {
            $error = 'Parollar mos kelmadi.';
        } else {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = 'Bu email manzil allaqachon ro\'yxatdan o\'tgan.';
            } else {
                // Create user
                $hashed_password = hashPassword($password);
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role, is_active, created_at) VALUES (?, ?, ?, ?, ?, 'user', 1, NOW())");
                
                if ($stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password])) {
                    $success = 'Muvaffaqiyatli ro\'yxatdan o\'tdingiz! Endi hisobingizga kirishingiz mumkin.';
                    logActivity('User registered', $pdo->lastInsertId(), "Email: $email");
                    header('Location: profile.php');
                } else {
                    $error = 'Ro\'yxatdan o\'tishda xatolik yuz berdi.';
                }
            }
        }
    }
}
?>
 <!-- Favicon -->
 <link rel="icon" type="image/x-icon" href="images/favicon.ico">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="css/styles.css">

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<main class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2"><?php echo translate('register'); ?></h2>
            <p class="text-gray-600">Yangi hisob yarating</p>
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

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            Ism *
                        </label>
                        <div class="mt-1">
                            <input id="first_name" 
                                   name="first_name" 
                                   type="text" 
                                   required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ismingiz">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Familiya *
                        </label>
                        <div class="mt-1">
                            <input id="last_name" 
                                   name="last_name" 
                                   type="text" 
                                   required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Familiyangiz">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email manzil *
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
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Telefon raqam
                    </label>
                    <div class="mt-1">
                        <input id="phone" 
                               name="phone" 
                               type="tel" 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="+998 90 123 45 67">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Parol *
                    </label>
                    <div class="mt-1">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="••••••••">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Kamida 8 belgidan iborat bo'lishi kerak</p>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        Parolni tasdiqlang *
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

                <div class="flex items-center">
                    <input id="terms" 
                           name="terms" 
                           type="checkbox" 
                           required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        <a href="privacy-policy.php" class="text-blue-600 hover:text-blue-500">Foydalanish shartlari</a>ni qabul qilaman
                    </label>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-user-plus mr-2"></i>Ro'yxatdan o'tish
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Yoki</span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Hisobingiz bormi? 
                        <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">
                            Kirish
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>