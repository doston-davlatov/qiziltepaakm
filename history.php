<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= translate('h_1') ?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto"><?= translate('h_2') ?></p>
        </div>

        <!-- Timeline -->
        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-px h-full w-0.5 bg-gray-300"></div>

            <!-- Timeline items -->
            <div class="space-y-12">
                <!-- 1995 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8 text-right">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-blue-600 mb-2"><?= translate('h3') ?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h4') ?></h4>
                            <p class="text-gray-600"><?= translate('h5') ?></p>
                        </div>
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-blue-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8"></div>
                </div>

                <!-- 2020 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8"></div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-green-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-green-600 mb-2"><?= translate('h6')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h7')?></h4>
                            <p class="text-gray-600"><?= translate('h8')?></p>
                        </div>
                    </div>
                </div>

                <!-- 2024 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8 text-right">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-purple-600 mb-2"><?= translate('h9')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h10')?></h4>
                            <p class="text-gray-600"><?= translate('h_11')?></p>
                        </div>
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8"></div>
                </div>

                <!-- 2010 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8"></div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-yellow-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-yellow-600 mb-2"><?= translate('h12')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h13')?></h4>
                            <p class="text-gray-600"><?= translate('h14')?></p>
                        </div>
                    </div>
                </div>

                <!-- 2015 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8 text-right">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-red-600 mb-2"><?= translate('h15')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h16')?></h4>
                            <p class="text-gray-600"><?= translate('h17')?></p>
                        </div>
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-red-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8"></div>
                </div>

                <!-- 2020 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8"></div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-indigo-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold text-indigo-600 mb-2"><?= translate('h18')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h19')?></h4>
                            <p class="text-gray-600"><?= translate('h20')?></p>
                        </div>
                    </div>
                </div>

                <!-- 2024 -->
                <div class="relative flex items-center">
                    <div class="flex-1 pr-8 text-right">
                        <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-blue-500">
                            <h3 class="text-xl font-bold text-blue-600 mb-2"><?= translate('h21')?></h3>
                            <h4 class="text-lg font-semibold mb-3"><?= translate('h22')?></h4>
                            <p class="text-gray-600"><?= translate('h23')?></p>
                        </div>
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-blue-600 rounded-full border-4 border-white">
                    </div>
                    <div class="flex-1 pl-8"></div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="mt-16 bg-blue-50 p-8 rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-8"><?= translate('h24')?></h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">50,000+</div>
                    <div class="text-gray-600"><?= translate('books')?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">5,000+</div>
                    <div class="text-gray-600"><?= translate('users')?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">100+</div>
                    <div class="text-gray-600"><?= translate('events')?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600 mb-2">7+</div>
                    <div class="text-gray-600"><?= translate('h25')?></div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>