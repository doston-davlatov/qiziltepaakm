<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Virtual sayohat</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Qiziltepa Akademik Kutubxonasi bilan virtual tanishish
            </p>
        </div>

        <!-- Virtual Tour Navigation -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="showArea('entrance')" class="tour-btn active bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Kirish zali
                </button>
                <button onclick="showArea('reading-hall')" class="tour-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    O'qish zali
                </button>
                <button onclick="showArea('computer-lab')" class="tour-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    Kompyuter zali
                </button>
                <button onclick="showArea('children-section')" class="tour-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    Bolalar bo'limi
                </button>
                <button onclick="showArea('periodicals')" class="tour-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    Periodika zali
                </button>
            </div>
        </div>

        <!-- Tour Areas -->
        <div id="tour-content">
            <!-- Entrance Hall -->
            <div id="entrance" class="tour-area">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <img src="images/virtual-tour/entrance.jpg" 
                         alt="Kirish zali" 
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Kirish zali</h2>
                        <p class="text-gray-600 mb-6">
                            Kutubxonaga kirish zamonaviy va qulay tarzda tashkil etilgan. 
                            Bu yerda foydalanuvchilar ro'yxatdan o'tadilar va kerakli 
                            ma'lumotlarni oladilar.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Xizmatlar:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>
                                        <span>Foydalanuvchilarni ro'yxatga olish</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>
                                        <span>Ma'lumot berish xizmati</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>
                                        <span>Yo'naltirish va yordam</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>
                                        <span>Xavfsizlik nazorati</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Jihozlar:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-desktop text-blue-600 mr-2"></i>
                                        <span>Ro'yxatga olish terminali</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-camera text-blue-600 mr-2"></i>
                                        <span>Xavfsizlik kameralari</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-wifi text-blue-600 mr-2"></i>
                                        <span>Bepul Wi-Fi</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-wheelchair text-blue-600 mr-2"></i>
                                        <span>Nogironlar uchun kirish</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reading Hall -->
            <div id="reading-hall" class="tour-area hidden">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <img src="images/virtual-tour/reading-hall.jpg" 
                         alt="O'qish zali" 
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">O'qish zali</h2>
                        <p class="text-gray-600 mb-6">
                            100 o'rinli asosiy o'qish zali zamonaviy mebel va yaxshi 
                            yoritish bilan jihozlangan. Tinch va qulay muhit ta'minlangan.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-chair text-blue-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold mb-2">100 o'rin</h3>
                                <p class="text-gray-600 text-sm">Qulay stol va stullar</p>
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
                                    <i class="fas fa-volume-mute text-purple-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold mb-2">Tinch muhit</h3>
                                <p class="text-gray-600 text-sm">Shovqinsiz zona</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Computer Lab -->
            <div id="computer-lab" class="tour-area hidden">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <img src="images/virtual-tour/computer-lab.jpg" 
                         alt="Kompyuter zali" 
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Kompyuter zali</h2>
                        <p class="text-gray-600 mb-6">
                            20 ta zamonaviy kompyuter bilan jihozlangan zal. Yuqori 
                            tezlikli internet va barcha kerakli dasturlar o'rnatilgan.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Texnik imkoniyatlar:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-desktop text-blue-600 mr-2"></i>
                                        <span>20 ta zamonaviy kompyuter</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-wifi text-blue-600 mr-2"></i>
                                        <span>Yuqori tezlikli internet</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-print text-blue-600 mr-2"></i>
                                        <span>Printer va skaner</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-headphones text-blue-600 mr-2"></i>
                                        <span>Audio qurilmalar</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Dasturiy ta'minot:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-file-word text-green-600 mr-2"></i>
                                        <span>Microsoft Office</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-globe text-green-600 mr-2"></i>
                                        <span>Internet brauzerlar</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-database text-green-600 mr-2"></i>
                                        <span>Elektron katalog</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-book-reader text-green-600 mr-2"></i>
                                        <span>E-book o'qish dasturlari</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Children Section -->
            <div id="children-section" class="tour-area hidden">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <img src="images/virtual-tour/children-section.jpg" 
                         alt="Bolalar bo'limi" 
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Bolalar bo'limi</h2>
                        <p class="text-gray-600 mb-6">
                            14 yoshgacha bolalar uchun maxsus tashkil etilgan bo'lim. 
                            Rang-barang va qiziqarli muhit yaratilgan.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book-open text-yellow-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold mb-2">3,000+ kitob</h3>
                                <p class="text-gray-600 text-sm">Bolalar uchun kitoblar</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-gamepad text-pink-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold mb-2">O'yin zonasi</h3>
                                <p class="text-gray-600 text-sm">Rivojlantiruvchi o'yinlar</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold mb-2">Ta'lim zonasi</h3>
                                <p class="text-gray-600 text-sm">Darslar va mashg'ulotlar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Periodicals -->
            <div id="periodicals" class="tour-area hidden">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                    <img src="images/virtual-tour/periodicals.jpg" 
                         alt="Periodika zali" 
                         class="w-full h-64 md:h-96 object-cover">
                    <div class="p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Periodika zali</h2>
                        <p class="text-gray-600 mb-6">
                            150+ nom gazeta va jurnallar bilan tanishish imkoniyati. 
                            Mahalliy va xalqaro nashrlar mavjud.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Mahalliy nashrlar:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-newspaper text-blue-600 mr-2"></i>
                                        <span>O'zbekiston ovozi</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-newspaper text-blue-600 mr-2"></i>
                                        <span>Xalq so'zi</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-book text-green-600 mr-2"></i>
                                        <span>Sharq yulduzi</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-book text-green-600 mr-2"></i>
                                        <span>Yoshlik</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-3">Xalqaro nashrlar:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-globe text-purple-600 mr-2"></i>
                                        <span>National Geographic</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-globe text-purple-600 mr-2"></i>
                                        <span>Scientific American</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-globe text-purple-600 mr-2"></i>
                                        <span>Time Magazine</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-globe text-purple-600 mr-2"></i>
                                        <span>The Economist</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 360 Virtual Tour -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-lg text-center">
            <h2 class="text-3xl font-bold mb-4">360° Virtual sayohat</h2>
            <p class="mb-6">To'liq virtual sayohat uchun maxsus dasturdan foydalaning</p>
            <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                <i class="fas fa-vr-cardboard mr-2"></i>360° sayohatni boshlash
            </button>
        </div>
    </div>
</main>

<script>
function showArea(areaId) {
    // Hide all tour areas
    const areas = document.querySelectorAll('.tour-area');
    areas.forEach(area => area.classList.add('hidden'));
    
    // Show selected area
    document.getElementById(areaId).classList.remove('hidden');
    
    // Update button styles
    const buttons = document.querySelectorAll('.tour-btn');
    buttons.forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    
    // Highlight active button
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    event.target.classList.add('bg-blue-600', 'text-white');
}
</script>

<?php require_once 'includes/footer.php'; ?>