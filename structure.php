<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= translate('s')?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto"><?= translate('s1')?></p>
        </div>

        <!-- Building Layout -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center"><?= translate('s2')?></h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4"><?= translate('s3')?></h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-door-open text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s4')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s5')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s6')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s7')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-newspaper text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s8')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s9')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                            <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-child text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s10')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s11')?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4"><?= translate('s12')?></h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-red-50 rounded-lg">
                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-book text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s13')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s14')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-indigo-50 rounded-lg">
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s15')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s16')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-pink-50 rounded-lg">
                            <div class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-laptop text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s17')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s18')?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-cogs text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold"><?= translate('s19')?></h4>
                                <p class="text-sm text-gray-600"><?= translate('s20')?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collections -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('s21')?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s22')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s23')?></p>
                    <div class="text-2xl font-bold text-blue-600">15,000+</div>
                    <div class="text-sm text-gray-500"><?= translate('s25')?></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-flask text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s26')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s27')?></p>
                    <div class="text-2xl font-bold text-green-600">20,000+</div>
                    <div class="text-sm text-gray-500"><?= translate('s25')?></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s29')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s30')?></p>
                    <div class="text-2xl font-bold text-purple-600">8,000+</div>
                    <div class="text-sm text-gray-500"><?= translate('s25')?></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-newspaper text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s31')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s32')?></p>
                    <div class="text-2xl font-bold text-yellow-600">150+</div>
                    <div class="text-sm text-gray-500"><?= translate('s33')?></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-laptop text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s34')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s35')?></p>
                    <div class="text-2xl font-bold text-red-600">5,000+</div>
                    <div class="text-sm text-gray-500"><?= translate('s36')?></div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-child text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-3"><?= translate('s37')?></h3>
                    <p class="text-gray-600 mb-3"><?= translate('s38')?></p>
                    <div class="text-2xl font-bold text-indigo-600">3,000+</div>
                    <div class="text-sm text-gray-500"><?= translate('s25')?></div>
                </div>
            </div>
        </div>

        <!-- Services by Floor -->
        <div class="bg-gray-50 p-8 rounded-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('s39')?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-blue-600"><?= translate('s40')?></h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s41')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s42')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s43')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s44')?></span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-purple-600"><?= translate('s45')?></h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s46')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s47')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s48')?></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span><?= translate('s49')?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>