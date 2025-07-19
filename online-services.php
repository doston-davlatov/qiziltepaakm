<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Onlayn xizmatlar</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Qiziltepa Akademik Kutubxonasining raqamli xizmatlari va onlayn imkoniyatlari
            </p>
        </div>

        <!-- Main Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Electronic Catalog -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-search text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Elektron katalog</h3>
                <p class="text-gray-600 mb-4">
                    Kutubxona fondidagi barcha kitoblarni onlayn qidirish va bron qilish imkoniyati
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>50,000+ kitob ma'lumoti</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Kengaytirilgan qidiruv</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Onlayn bron qilish</li>
                </ul>
                <a href="catalog.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Katalogni ochish
                </a>
            </div>

            <!-- Digital Library -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-laptop text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Raqamli kutubxona</h3>
                <p class="text-gray-600 mb-4">
                    Elektron kitoblar, jurnallar va boshqa raqamli resurslar to'plami
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>5,000+ elektron kitob</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>PDF, EPUB formatlar</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>24/7 kirish imkoniyati</li>
                </ul>
                <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                    Raqamli kutubxona
                </button>
            </div>

            <!-- Online Registration -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-plus text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Onlayn ro'yxatdan o'tish</h3>
                <p class="text-gray-600 mb-4">
                    Kutubxona a'zosi bo'lish uchun onlayn ariza berish imkoniyati
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Tez va oson jarayon</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Elektron tasdiqlash</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Darhol kirish huquqi</li>
                </ul>
                <a href="register.php" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-300">
                    Ro'yxatdan o'tish
                </a>
            </div>

            <!-- Virtual Reference -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-question-circle text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Virtual ma'lumotnoma</h3>
                <p class="text-gray-600 mb-4">
                    Onlayn savol-javob xizmati va ma'lumot qidiruv yordami
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Mutaxassis maslahati</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Bibliografik yordam</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>24 soat ichida javob</li>
                </ul>
                <a href="contact.php" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition duration-300">
                    Savol berish
                </a>
            </div>

            <!-- Online Renewal -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-redo text-2xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Onlayn uzaytirish</h3>
                <p class="text-gray-600 mb-4">
                    Olingan kitoblar muddatini onlayn uzaytirish imkoniyati
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Avtomatik uzaytirish</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>SMS eslatma</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Jarima hisobi</li>
                </ul>
                <a href="profile.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">
                    Profilga kirish
                </a>
            </div>

            <!-- Event Registration -->
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-calendar-check text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Tadbirlarga yozilish</h3>
                <p class="text-gray-600 mb-4">
                    Kutubxona tadbirlariga onlayn ro'yxatdan o'tish imkoniyati
                </p>
                <ul class="text-sm text-gray-600 space-y-2 mb-6">
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Onlayn ro'yxatdan o'tish</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Tadbir eslatmalari</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i>Sertifikat olish</li>
                </ul>
                <a href="events.php" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300">
                    Tadbirlar ro'yxati
                </a>
            </div>
        </div>

        <!-- Digital Resources -->
        <div class="bg-gray-50 p-8 rounded-lg mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Raqamli resurslar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book-open text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">E-kitoblar</h3>
                    <p class="text-2xl font-bold text-blue-600 mb-1">5,000+</p>
                    <p class="text-gray-600 text-sm">Elektron kitoblar</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-newspaper text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">E-jurnallar</h3>
                    <p class="text-2xl font-bold text-green-600 mb-1">150+</p>
                    <p class="text-gray-600 text-sm">Elektron jurnallar</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-database text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Ma'lumotlar bazasi</h3>
                    <p class="text-2xl font-bold text-purple-600 mb-1">20+</p>
                    <p class="text-gray-600 text-sm">Maxsus bazalar</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-video text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Video darslar</h3>
                    <p class="text-2xl font-bold text-yellow-600 mb-1">500+</p>
                    <p class="text-gray-600 text-sm">Ta'lim videolari</p>
                </div>
            </div>
        </div>

        <!-- Access Information -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Kirish ma'lumotlari</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Bepul xizmatlar:</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <span>Elektron katalog qidiruvi</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <span>Asosiy ma'lumotlar bazasi</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <span>Onlayn ro'yxatdan o'tish</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <span>Tadbirlarga yozilish</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">A'zolik talab qiladigan:</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-user-check text-blue-600 mr-3"></i>
                            <span>To'liq elektron kitoblar</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-user-check text-blue-600 mr-3"></i>
                            <span>Maxsus ma'lumotlar bazasi</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-user-check text-blue-600 mr-3"></i>
                            <span>Kitoblarni bron qilish</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-user-check text-blue-600 mr-3"></i>
                            <span>Shaxsiy kabinet</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-4">
                    Barcha onlayn xizmatlardan foydalanish uchun ro'yxatdan o'ting
                </p>
                <a href="register.php" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Ro'yxatdan o'tish
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>