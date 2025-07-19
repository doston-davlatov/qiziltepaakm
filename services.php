<?php
require_once './includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo translate('services'); ?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kutubxonamiz zamonaviy va sifatli xizmatlar bilan sizning barcha ehtiyojlaringizni qondiradi
            </p>
        </div>

        <!-- Main Services -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="images/electronic-catalog.jpg" 
                         alt="Elektron katalog" 
                         class="w-full h-48 object-cover">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Elektron katalog</h2>
                        <p class="text-gray-600 mb-6">
                            Kutubxonamizning elektron katalogi orqali minglab kitoblar va materiallar 
                            orasidan kerakli ma'lumotlarni osongina topishingiz mumkin. Qidiruv tizimi 
                            nomi, muallifi, janri va boshqa parametrlar bo'yicha ishlaydi.
                        </p>
                        <div class="flex flex-wrap gap-4 mb-6">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-search mr-2"></i>Kengaytirilgan qidiruv
                            </span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-filter mr-2"></i>Filtrlar
                            </span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-bookmark mr-2"></i>Saqlash imkoniyati
                            </span>
                        </div>
                        <a href="catalog.php" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Katalogni ochish
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-laptop text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Raqamli resurslari</h3>
                    <p class="text-gray-600 mb-4">
                        Elektron kitoblar, jurnallar va ma'lumotnomalar
                    </p>
                    <a href="#" class="text-green-600 hover:text-green-800 font-medium">
                        Batafsil <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">O'qish zallari</h3>
                    <p class="text-gray-600 mb-4">
                        Qulay va zamonaviy o'qish xonalari
                    </p>
                    <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                        Batafsil <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- All Services -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Barcha xizmatlar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-book-open text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Kitob ijara berish</h3>
                    <p class="text-gray-600 mb-4">
                        Kutubxonamizdan kitoblarni uy sharoitida o'qish uchun olishingiz mumkin. 
                        Ijara muddati 30 kungacha.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Ijara muddati: 30 kun</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Uzaytirish imkoniyati</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Onlayn rezervatsiya</li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-desktop text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Kompyuter xizmatlari</h3>
                    <p class="text-gray-600 mb-4">
                        Internet, Microsoft Office, tadqiqot ishlari uchun kompyuter xizmatlaridan 
                        foydalanish imkoniyati.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Internet kirish</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Office dasturlari</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Chop etish xizmati</li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-graduation-cap text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Ilmiy tadqiqot yordami</h3>
                    <p class="text-gray-600 mb-4">
                        Ilmiy ishlar, dissertatsiyalar va tadqiqotlar uchun maxsus yordam 
                        va maslahat xizmatlari.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Ma'lumot qidiruv</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Bibliografiya tuzish</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Mutaxassis maslahati</li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-copy text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Nusxalash va skanerlash</h3>
                    <p class="text-gray-600 mb-4">
                        Zarur sahifalar va materiallarni nusxalash hamda elektron formatga 
                        o'tkazish xizmatlari.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Rang va oq-qora chop</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Skanerlash xizmati</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>PDF formatga o'tkazish</li>
                    </ul>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chalkboard-teacher text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">O'quv kurslari</h3>
                    <p class="text-gray-600 mb-4">
                        Kutubxona xizmatlaridan foydalanish, ma'lumot qidiruv va kompyuter 
                        savodxonligi kurslari.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Kutubxona o'quv kursi</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Ma'lumot qidiruv</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Kompyuter kurslari</li>
                    </ul>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Tadbirlar va seminarlar</h3>
                    <p class="text-gray-600 mb-4">
                        Ilmiy konferensiyalar, kitob taqdimotlari, yozuvchilar bilan 
                        uchrashuv tadbirlari.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Ilmiy konferensiyalar</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Kitob taqdimotlari</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Madaniy tadbirlar</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Special Services -->
        <div class="bg-gray-50 p-8 rounded-lg mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Maxsus xizmatlar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-wheelchair text-blue-600 mr-3"></i>
                        Nogironlar uchun xizmatlar
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Harakat qobiliyati cheklangan shaxslar uchun maxsus jihozlangan joy va yordam.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Nogironlar aravchasi kirish</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Maxsus jihozlangan stol</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Yordamchi xodimlar</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-child text-green-600 mr-3"></i>
                        Bolalar bo'limi
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Bolalar uchun maxsus tashkil etilgan bo'lim va o'yin-kulgi bilan o'rgatish.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Bolalar kitoblar</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>O'yin xonasi</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Erta rivojlantirish</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Service Hours -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Xizmat vaqtlari</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Ish kunlari</h3>
                    <p class="text-gray-600">Dushanba - Juma</p>
                    <p class="text-lg font-semibold text-blue-600">09:00 - 18:00</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-day text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Shanba</h3>
                    <p class="text-gray-600">Qisqartirilgan kun</p>
                    <p class="text-lg font-semibold text-green-600">09:00 - 13:00</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bed text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Yakshanba</h3>
                    <p class="text-gray-600">Dam olish kuni</p>
                    <p class="text-lg font-semibold text-red-600">Yopiq</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>