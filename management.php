<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= translate('m1')?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto"><?= translate('m2')?></p>
        </div>

        <!-- Director -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 mb-6 md:mb-0">
                    <img src="images/lib/director.jpg" 
                         alt="Direktor" 
                         class="w-48 h-48 rounded-full mx-auto object-cover shadow-lg">
                </div>
                <div class="md:w-2/3 md:pl-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Olimova Nazira Karimovna</h2>
                    <p class="text-xl text-blue-600 mb-4">Kutubxona direktori</p>
                    <p class="text-gray-600 mb-4">
                        Kutubxonachilik sohasida 20 yillik tajribaga ega. Toshkent Davlat 
                        Madaniyat Institutini tamomlagan. Kutubxona xizmatlarini modernizatsiya 
                        qilish va raqamli texnologiyalarni joriy etish bo'yicha ko'plab 
                        loyihalarni amalga oshirgan.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>director@qiziltepaakm.uz</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+998 79 123 45 67</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Team -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('m3')?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Deputy Director -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <img src="images/lib/deputy-director.jpg" 
                         alt="Direktor o'rinbosari" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Karimov Bobur Akmalovich</h3>
                    <p class="text-blue-600 mb-3">Direktor o'rinbosari</p>
                    <p class="text-gray-600 text-sm mb-4">
                        Ilmiy ishlar va xalqaro aloqalar bo'yicha mas'ul. 
                        15 yillik kutubxonachilik tajribasi.
                    </p>
                    <div class="text-sm text-gray-500">
                        <p><i class="fas fa-envelope mr-2"></i>deputy@qiziltepaakm.uz</p>
                        <p><i class="fas fa-phone mr-2"></i>+998 79 123 45 68</p>
                    </div>
                </div>

                <!-- Head Librarian -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <img src="images/lib/head-librarian.jpg" 
                         alt="Bosh kutubxonachi" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Tosheva Gulnora Rustamovna</h3>
                    <p class="text-green-600 mb-3">Bosh kutubxonachi</p>
                    <p class="text-gray-600 text-sm mb-4">
                        Kataloglash va fond boshqaruvi bo'yicha mutaxassis. 
                        12 yillik tajriba.
                    </p>
                    <div class="text-sm text-gray-500">
                        <p><i class="fas fa-envelope mr-2"></i>librarian@qiziltepaakm.uz</p>
                        <p><i class="fas fa-phone mr-2"></i>+998 79 123 45 69</p>
                    </div>
                </div>

                <!-- IT Manager -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <img src="images/lib/it-manager.jpg" 
                         alt="IT menejer" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-semibold mb-2">Rahmonov Jasur Olimovich</h3>
                    <p class="text-purple-600 mb-3">IT bo'limi boshlig'i</p>
                    <p class="text-gray-600 text-sm mb-4">
                        Raqamli texnologiyalar va elektron xizmatlar bo'yicha 
                        mas'ul. 8 yillik tajriba.
                    </p>
                    <div class="text-sm text-gray-500">
                        <p><i class="fas fa-envelope mr-2"></i>it@qiziltepaakm.uz</p>
                        <p><i class="fas fa-phone mr-2"></i>+998 79 123 45 70</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('m4')?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Acquisition Department -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold"><?= translate('m5')?></h3>
                    </div>
                    <p class="text-gray-600 mb-4"><?= translate('m6')?></p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><?= translate('m7')?></li>
                        <li><?= translate('m8')?></li>
                        <li><?= translate('m9')?></li>
                    </ul>
                </div>

                <!-- Cataloging Department -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-tags text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold"><?= translate('m10')?></h3>
                    </div>
                    <p class="text-gray-600 mb-4"><?= translate('m11')?></p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><?= translate('m12')?></li>
                        <li><?= translate('m13')?></li>
                        <li><?= translate('m14')?></li>
                    </ul>
                </div>

                <!-- Reader Services -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold"><?= translate('m15')?></h3>
                    </div>
                    <p class="text-gray-600 mb-4"><?= translate('m16')?></p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><?= translate('m17')?></li>
                        <li><?= translate('m18')?></li>
                        <li><?= translate('m19')?></li>
                    </ul>
                </div>

                <!-- Digital Services -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-laptop text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold"><?= translate('m20')?></h3>
                    </div>
                    <p class="text-gray-600 mb-4"><?= translate('m21')?></p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><?= translate('m22')?></li>
                        <li><?= translate('m23')?></li>
                        <li><?= translate('m24')?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Organizational Chart -->
        <div class="bg-gray-50 p-8 rounded-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('m25')?></h2>
            <div class="text-center">
                <div class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg mb-6">
                    <h3 class="font-semibold"><?= translate('m26')?></h3>
                </div>
                
                <div class="flex justify-center space-x-8 mb-6">
                    <div class="bg-green-600 text-white px-4 py-2 rounded-lg">
                        <h4 class="text-sm font-semibold"><?= translate('m27')?></h4>
                    </div>
                    <div class="bg-purple-600 text-white px-4 py-2 rounded-lg">
                        <h4 class="text-sm font-semibold"><?= translate('m28')?></h4>
                    </div>
                    <div class="bg-red-600 text-white px-4 py-2 rounded-lg">
                        <h4 class="text-sm font-semibold"><?= translate('m29')?></h4>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">
                    <?= translate('m30')?>
                    </div>
                    <div class="bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">
                    <?= translate('m31')?>
                    </div>
                    <div class="bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">
                    <?= translate('m32')?>
                    </div>
                    <div class="bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm">
                    <?= translate('m33')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>