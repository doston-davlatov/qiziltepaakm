<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
require_once '../includes/config.php';

// Handle language change
if (isset($_GET['lang']) && in_array($_GET['lang'], AVAILABLE_LANGUAGES)) {
    setLanguage($_GET['lang']);
}

$currentLang = getCurrentLanguage();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('library_name'); ?></title>
    <meta name="description" content="<?php echo translate('library_name'); ?> - Zamonaviy kutubxona xizmatlari">
    <meta name="keywords" content="kutubxona, kitoblar, elektron katalog, tadbirlar, yangiliklar">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="../images/logo_2.png" alt="Library Logo" class="h-10 w-10 mr-3">
                    <span class="text-xl font-bold text-gradient"><?php echo translate('library_name'); ?></span>
                </div>

                <!-- Desktop Navigation -->
<div class="hidden md:flex space-x-6">
    <!-- Home Link -->
    <a href="index.php" class="nav-link <?php echo $currentPage === 'index' ? 'active' : ''; ?> text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
        <?php echo translate('home'); ?>
    </a>
    
    <!-- Services Dropdown -->
    <div class="relative group">
        <button class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium flex items-center transition-colors duration-200">
            <?php echo translate('services'); ?> 
            <i class="fas fa-chevron-down ml-1 text-xs transform group-hover:rotate-180 transition-transform duration-200"></i>
        </button>
        <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-left border border-gray-100">
            <div class="py-1">
                <a href="books.php" class="nav-link <?php echo $currentPage === 'catalog' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('books'); ?>
                </a>
                <a href="news.php" class="nav-link <?php echo $currentPage === 'news' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('news'); ?>
                </a>
                <a href="events.php" class="nav-link <?php echo $currentPage === 'events' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('events'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Library Resources -->
    <div class="relative group">
        <button class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium flex items-center transition-colors duration-200">
            <?php echo translate('resources'); ?>
            <i class="fas fa-chevron-down ml-1 text-xs transform group-hover:rotate-180 transition-transform duration-200"></i>
        </button>
        <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-left border border-gray-100">
            <div class="py-1">
                <a href="authors.php" class="nav-link <?php echo $currentPage === 'authors' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('authors'); ?>
                </a>
                <a href="genres.php" class="nav-link <?php echo $currentPage === 'genres' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('genres'); ?>
                </a>
                <a href="publishers.php" class="nav-link <?php echo $currentPage === 'publishers' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('publisher'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- User Management -->
    <div class="relative group">
        <button class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium flex items-center transition-colors duration-200">
            <?php echo translate('management'); ?>
            <i class="fas fa-chevron-down ml-1 text-xs transform group-hover:rotate-180 transition-transform duration-200"></i>
        </button>
        <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-left border border-gray-100">
            <div class="py-1">
                <a href="users.php" class="nav-link <?php echo $currentPage === 'users' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('users'); ?>
                </a>
                <a href="librarians.php" class="nav-link <?php echo $currentPage === 'librarians' ? 'active' : ''; ?> block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                    <?php echo translate('librarians'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

                    <!-- Right side: Language selector and user menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Language Selector -->
                        <div class="relative">
                            <select onchange="changeLanguage(this.value)"
                                class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="uz" <?php echo $currentLang === 'uz' ? 'selected' : ''; ?>>O'zbekcha
                                </option>
                                <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                                <option value="ru" <?php echo $currentLang === 'ru' ? 'selected' : ''; ?>>Русский</option>
                            </select>
                        </div>

                        <!-- User Menu -->
                        <?php if (isLoggedIn()): ?>
                            <div class="relative">
                                <button type="button"
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="user-menu-button">
                                    <i class="fas fa-user-circle text-2xl text-gray-600"></i>
                                </button>
                                <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                    id="user-menu">
                                    <a href="../profile.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i><?php echo translate('profile'); ?>
                                    </a>
                                    <?php if (isAdmin()): ?>
                                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cogs mr-2"></i><?php echo translate('admin_panel'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="../logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i><?php echo translate('logout'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="login.php"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-300">
                                <?php echo translate('login'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button"
                            class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                            id="mobile-menu-button">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                    <a href="index.php" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('home'); ?>
                    </a>
                    <a href="services.php"
                        class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('services'); ?>
                    </a>
                    <a href="catalog.php"
                        class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('catalog'); ?>
                    </a>
                    <a href="news.php" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('news'); ?>
                    </a>
                    <a href="events.php"
                        class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('events'); ?>
                    </a>
                    <a href="about.php" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('about'); ?>
                    </a>
                    <a href="contact.php"
                        class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                        <?php echo translate('contact'); ?>
                    </a>

                    <?php if (isLoggedIn()): ?>
                        <a href="profile.php"
                            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                            <?php echo translate('profile'); ?>
                        </a>
                        <?php if (isAdmin()): ?>
                            <a href="index.php" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                                <?php echo translate('admin_panel'); ?>
                            </a>
                        <?php endif; ?>
                        <a href="logout.php"
                            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600">
                            <?php echo translate('logout'); ?>
                        </a>
                    <?php else: ?>
                        <a href="login.php"
                            class="block px-3 py-2 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            <?php echo translate('login'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
    </nav>

    <script>
        // Language change function
        function changeLanguage(lang) {
            window.location.href = window.location.pathname + '?lang=' + lang;
        }

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function () {
                userMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function (event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>