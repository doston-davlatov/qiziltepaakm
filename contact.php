<?php
require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);
    $csrf_token = $_POST['csrf_token'];
    
    // Verify CSRF token
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi. Iltimos, qayta urinib ko\'ring.';
    } else {
        // Validate inputs
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $error = 'Barcha majburiy maydonlarni to\'ldiring.';
        } elseif (!validateEmail($email)) {
            $error = 'Noto\'g\'ri email format.';
        } else {
            // Here you would typically send an email or save to database
            // For now, we'll just show a success message
            $success = 'Xabaringiz muvaffaqiyatli yuborildi. Tez orada siz bilan bog\'lanamiz.';
            
            // Log the contact form submission
            logActivity('Contact form submitted', null, "Name: $name, Email: $email, Subject: $subject");
        }
    }
}
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo translate('contact'); ?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Bizga murojaat qiling. Sizning savollaringiz va takliflaringiz biz uchun muhim
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Xabar yuborish</h2>
                
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Ism familiya *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Ismingizni kiriting">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email manzil *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="email@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telefon raqam
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="+998 90 123 45 67">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Mavzu *
                        </label>
                        <select id="subject" 
                                name="subject" 
                                required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Mavzuni tanlang</option>
                            <option value="general">Umumiy savol</option>
                            <option value="book_request">Kitob so'rovi</option>
                            <option value="technical_support">Texnik yordam</option>
                            <option value="partnership">Hamkorlik</option>
                            <option value="feedback">Fikr-mulohaza</option>
                            <option value="other">Boshqa</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Xabar *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Xabaringizni yozing..."></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>Xabar yuborish
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Aloqa ma'lumotlari</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Manzil</h3>
                                <p class="text-gray-600">Navoiy shahar, Mustaqillik ko'chasi, 123-uy</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Telefon</h3>
                                <p class="text-gray-600">+998 79 123 45 67</p>
                                <p class="text-gray-600">+998 79 123 45 68</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">info@library.uz</p>
                                <p class="text-gray-600">director@library.uz</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Ish vaqti</h3>
                                <p class="text-gray-600">Dushanba - Juma: 08:00 - 18:00</p>
                                <p class="text-gray-600">Shanba: 09:00 - 15:00</p>
                                <p class="text-gray-600">Yakshanba: Dam olish kuni</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ijtimoiy tarmoqlar</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="#" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-300">
                            <i class="fab fa-facebook-f text-blue-600 mr-3"></i>
                            <span class="text-blue-900">Facebook</span>
                        </a>

                        <a href="#" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-300">
                            <i class="fab fa-twitter text-blue-600 mr-3"></i>
                            <span class="text-blue-900">Twitter</span>
                        </a>

                        <a href="#" class="flex items-center p-4 bg-pink-50 rounded-lg hover:bg-pink-100 transition duration-300">
                            <i class="fab fa-instagram text-pink-600 mr-3"></i>
                            <span class="text-pink-900">Instagram</span>
                        </a>

                        <a href="#" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition duration-300">
                            <i class="fab fa-youtube text-red-600 mr-3"></i>
                            <span class="text-red-900">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Tezkor havolalar</h2>
                    
                    <div class="space-y-3">
                        <a href="faq.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300">
                            <i class="fas fa-question-circle mr-3"></i>
                            Ko'p so'raladigan savollar
                        </a>

                        <a href="services.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300">
                            <i class="fas fa-cogs mr-3"></i>
                            Bizning xizmatlarimiz
                        </a>

                        <a href="catalog.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300">
                            <i class="fas fa-search mr-3"></i>
                            Katalogda qidirish
                        </a>

                        <a href="events.php" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Tadbirlar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Bizning joylashuvimiz</h2>
            <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marker-alt text-4xl text-gray-500 mb-2"></i>
                    <p class="text-gray-600">Xarita bu yerda ko'rsatiladi</p>
                    <p class="text-sm text-gray-500">Google Maps yoki OpenStreetMap integratsiyasi</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>