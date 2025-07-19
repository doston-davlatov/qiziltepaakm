<?php
require_once '../includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">O'qish zallari</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Qiziltepa Akademik Kutubxonasining zamonaviy va qulay o'qish zallari
            </p>
        </div>

        <!-- Main Reading Hall -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <img src="../images/reading-halls/main-hall.jpg" 
                 alt="Asosiy o'qish zali" 
                 class="w-full h-64 md:h-96 object-cover">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Asosiy o'qish zali</h2>
                <p class="text-gray-600 mb-6">
                    100 o'rinli asosiy o'qish zali zamonaviy mebel va professional yoritish 
                    tizimi bilan jihozlangan. Tinch va qulay muhit ta'minlangan.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chair text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">100 o'rin</h3>
                        <p class="text-gray-600 text-sm">Ergonomik stol va stullar</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">LED yoritish</h3>
                        <p class="text-gray-600 text-sm">Ko'zni charchatmaydigan</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-snowflake text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold mb-2">Konditsioner</h3>
                        <p class="text-gray-600 text-sm">Optimal harorat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reading Halls Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Computer Hall -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="../images/reading-halls/computer-hall.jpg" 
                     alt="Kompyuter zali" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3">Kompyuter zali</h3>
                    <p class="text-gray-600 mb-4">
                        20 ta zamonaviy kompyuter bilan jihozlangan zal. Internet va 
                        barcha kerakli dasturlar mavjud.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-desktop text-blue-600 mr-2"></i>
                            <span>20 ta kompyuter</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-wifi text-blue-600 mr-2"></i>
                            <span>Yuqori tezlikli internet</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-print text-blue-600 mr-2"></i>
                            <span>Printer va skaner</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Group Study Room -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="../images/reading-halls/group-study.jpg" 
                     alt="Guruh o'qish xonasi" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3">Guruh o'qish xonasi</h3>
                    <p class="text-gray-600 mb-4">
                        Guruh bo'lib ishlash va muhokama qilish uchun maxsus 
                        tashkil etilgan xona.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-users text-green-600 mr-2"></i>
                            <span>8-10 kishi uchun</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-tv text-green-600 mr-2"></i>
                            <span>Proyektor va ekran</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-check text-green-600 mr-2"></i>
                            <span>Oldindan bron qilish</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Silent Study Area -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="../images/reading-halls/silent-area.jpg" 
                     alt="Jim o'qish zonasi" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3">Jim o'qish zonasi</h3>
                    <p class="text-gray-600 mb-4">
                        To'liq jimlik talab qilinadigan individual o'qish uchun 
                        maxsus zona.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-volume-mute text-purple-600 mr-2"></i>
                            <span>To'liq jimlik</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-user text-purple-600 mr-2"></i>
                            <span>Individual o'rinlar</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-book-reader text-purple-600 mr-2"></i>
                            <span>Chuqur o'qish uchun</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Children's Reading Area -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="../images/reading-halls/children-area.jpg" 
                     alt="Bolalar o'qish zonasi" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3">Bolalar o'qish zonasi</h3>
                    <p class="text-gray-600 mb-4">
                        14 yoshgacha bolalar uchun rang-barang va qiziqarli 
                        muhit yaratilgan.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-child text-yellow-600 mr-2"></i>
                            <span>14 yoshgacha</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-gamepad text-yellow-600 mr-2"></i>
                            <span>O'yin zonasi</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-palette text-yellow-600 mr-2"></i>
                            <span>Rang-barang dizayn</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facilities and Rules -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Facilities -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Imkoniyatlar</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-wifi text-blue-600 mr-4 text-xl"></i>
                        <div>
                            <h3 class="font-semibold">Bepul Wi-Fi</h3>
                            <p class="text-gray-600 text-sm">Barcha zallarda yuqori tezlikli internet</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-plug text-green-600 mr-4 text-xl"></i>
                        <div>
                            <h3 class="font-semibold">Elektr rozetkalar</h3>
                            <p class="text-gray-600 text-sm">Laptop va telefonlarni quvvatlash uchun</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-coffee text-yellow-600 mr-4 text-xl"></i>
                        <div>
                            <h3 class="font-semibold">Kafeteriya</h3>
                            <p class="text-gray-600 text-sm">Yengil taomlar va ichimliklar</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-restroom text-purple-600 mr-4 text-xl"></i>
                        <div>
                            <h3 class="font-semibold">Hojatxona</h3>
                            <p class="text-gray-600 text-sm">Zamonaviy va toza</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rules -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">O'qish qoidalari</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-volume-mute text-red-600 mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Tinchlik saqlash</h3>
                            <p class="text-gray-600 text-sm">Shovqin qilish va baland gapirish taqiq</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-mobile-alt text-red-600 mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Telefon rejimi</h3>
                            <p class="text-gray-600 text-sm">Jim rejimda saqlash yoki o'chirish</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-utensils text-red-600 mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Ovqat taqiqi</h3>
                            <p class="text-gray-600 text-sm">O'qish zallarida ovqat iste'mol qilish taqiq</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-book text-green-600 mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-semibold">Kitoblarni saqlash</h3>
                            <p class="text-gray-600 text-sm">Kitoblarni ehtiyotkorlik bilan saqlang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Information -->
        <div class="bg-blue-50 p-8 rounded-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">O'rin bron qilish</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Onlayn bron</h3>
                    <p class="text-gray-600 text-sm">Veb-sayt orqali o'rin bron qiling</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Telefon orqali</h3>
                    <p class="text-gray-600 text-sm">+998 79 123 45 67</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Ish vaqti</h3>
                    <p class="text-gray-600 text-sm">08:00 - 18:00</p>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <?php if (isLoggedIn()): ?>
                    <button class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-calendar-check mr-2"></i>O'rin bron qilish
                    </button>
                <?php else: ?>
                    <a href="login.php" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300 inline-block">
                        <i class="fas fa-sign-in-alt mr-2"></i>Bron qilish uchun kiring
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>