<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Sayt xaritasi</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Qiziltepa Akademik Kutubxonasi veb-saytidagi barcha sahifalar ro'yxati
            </p>
        </div>

        <!-- Sitemap Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Main Pages -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-600 mb-4">
                    <i class="fas fa-home mr-2"></i>Asosiy sahifalar
                </h2>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Bosh sahifa</a></li>
                    <li><a href="about.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Kutubxona haqida</a></li>
                    <li><a href="history.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Tarixi</a></li>
                    <li><a href="management.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Boshqaruv</a></li>
                    <li><a href="structure.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Tuzilma</a></li>
                    <li><a href="contact.php" class="text-gray-700 hover:text-blue-600 transition duration-300">Aloqa</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-green-600 mb-4">
                    <i class="fas fa-cogs mr-2"></i>Xizmatlar
                </h2>
                <ul class="space-y-2">
                    <li><a href="services.php" class="text-gray-700 hover:text-green-600 transition duration-300">Xizmatlar</a></li>
                    <li><a href="online-services.php" class="text-gray-700 hover:text-green-600 transition duration-300">Onlayn xizmatlar</a></li>
                    <li><a href="reading-halls.php" class="text-gray-700 hover:text-green-600 transition duration-300">O'qish zallari</a></li>
                    <li><a href="virtual-tour.php" class="text-gray-700 hover:text-green-600 transition duration-300">Virtual sayohat</a></li>
                    <li><a href="rules.php" class="text-gray-700 hover:text-green-600 transition duration-300">Foydalanish qoidalari</a></li>
                </ul>
            </div>

            <!-- Catalog and Resources -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-purple-600 mb-4">
                    <i class="fas fa-book mr-2"></i>Katalog va resurslar
                </h2>
                <ul class="space-y-2">
                    <li><a href="catalog.php" class="text-gray-700 hover:text-purple-600 transition duration-300">Elektron katalog</a></li>
                    <li><a href="search.php" class="text-gray-700 hover:text-purple-600 transition duration-300">Qidiruv</a></li>
                    <li><a href="catalog.php?type=new" class="text-gray-700 hover:text-purple-600 transition duration-300">Yangi kitoblar</a></li>
                    <li><a href="catalog.php?type=popular" class="text-gray-700 hover:text-purple-600 transition duration-300">Mashhur kitoblar</a></li>
                    <li><a href="catalog.php?type=digital" class="text-gray-700 hover:text-purple-600 transition duration-300">Elektron kitoblar</a></li>
                </ul>
            </div>

            <!-- News and Events -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-yellow-600 mb-4">
                    <i class="fas fa-newspaper mr-2"></i>Yangiliklar va tadbirlar
                </h2>
                <ul class="space-y-2">
                    <li><a href="news.php" class="text-gray-700 hover:text-yellow-600 transition duration-300">Yangiliklar</a></li>
                    <li><a href="events.php" class="text-gray-700 hover:text-yellow-600 transition duration-300">Tadbirlar</a></li>
                    <li><a href="events.php?type=upcoming" class="text-gray-700 hover:text-yellow-600 transition duration-300">Yaqinlashayotgan tadbirlar</a></li>
                    <li><a href="events.php?type=past" class="text-gray-700 hover:text-yellow-600 transition duration-300">O'tgan tadbirlar</a></li>
                </ul>
            </div>

            <!-- User Account -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-red-600 mb-4">
                    <i class="fas fa-user mr-2"></i>Foydalanuvchi hisobi
                </h2>
                <ul class="space-y-2">
                    <li><a href="login.php" class="text-gray-700 hover:text-red-600 transition duration-300">Kirish</a></li>
                    <li><a href="register.php" class="text-gray-700 hover:text-red-600 transition duration-300">Ro'yxatdan o'tish</a></li>
                    <li><a href="profile.php" class="text-gray-700 hover:text-red-600 transition duration-300">Shaxsiy kabinet</a></li>
                    <li><a href="forgot-password.php" class="text-gray-700 hover:text-red-600 transition duration-300">Parolni tiklash</a></li>
                </ul>
            </div>

            <!-- Help and Support -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-indigo-600 mb-4">
                    <i class="fas fa-question-circle mr-2"></i>Yordam va qo'llab-quvvatlash
                </h2>
                <ul class="space-y-2">
                    <li><a href="faq.php" class="text-gray-700 hover:text-indigo-600 transition duration-300">Tez-tez so'raladigan savollar</a></li>
                    <li><a href="contact.php" class="text-gray-700 hover:text-indigo-600 transition duration-300">Bog'lanish</a></li>
                    <li><a href="privacy-policy.php" class="text-gray-700 hover:text-indigo-600 transition duration-300">Maxfiylik siyosati</a></li>
                    <li><a href="terms-of-use.php" class="text-gray-700 hover:text-indigo-600 transition duration-300">Foydalanish shartlari</a></li>
                </ul>
            </div>
        </div>

        <!-- Search Box -->
        <div class="mt-12 bg-gray-50 p-8 rounded-lg text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Qidiruv</h2>
            <p class="text-gray-600 mb-6">Kerakli sahifani topa olmadingizmi? Qidiruv orqali toping</p>
            <form action="search.php" method="GET" class="max-w-md mx-auto">
                <div class="flex">
                    <input type="text" 
                           name="q" 
                           placeholder="Qidiruv..." 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-r-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>