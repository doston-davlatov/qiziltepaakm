<?php
require_once 'functions.php';
require_once 'db_connect.php';
require_once 'config.php';

// Handle language change with validation
if (isset($_GET['lang']) && in_array($_GET['lang'], AVAILABLE_LANGUAGES)) {
    if (function_exists('setLanguage')) {
        setLanguage(filter_var($_GET['lang'], FILTER_SANITIZE_STRING));
    }
}

// Get current language with fallback
$currentLang = function_exists('getCurrentLanguage') ? getCurrentLanguage() : 'en';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($currentLang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(translate('library_name')); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars(translate('library_name')); ?> - Zamonaviy kutubxona xizmatlari">
    <meta name="keywords" content="kutubxona, kitoblar, elektron katalog, tadbirlar, yangiliklar">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-Xt7vB86jU2Dl3T5pddP1zDa0Z8r2j2l6+HLt2iWnqB6Q1I2q6i6i6i6i6i6i6i6i" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWixL2g8pk3bK2fP1Tq3jA5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z" crossorigin="anonymous">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" integrity="sha384-yA3Ax2C+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (optional, only if needed) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/notifications.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Viewport height fix for mobile */
        :root {
            --vh: 1vh;
        }

        .min-h-screen {
            min-height: 100vh;
            min-height: calc(var(--vh, 1vh) * 100);
        }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-light overflow-x-hidden">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-modern">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php" aria-label="<?php echo htmlspecialchars(translate('library_name')); ?>">
                <img src="images/logo_2.png" alt="<?php echo htmlspecialchars(translate('library_name')); ?> Logo" 
                     style="height: 3rem;" class="me-2">
                <span class="fs-5 fw-bold text-dark"><?php echo htmlspecialchars(translate('library_name')); ?></span>
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler border-0 mobile-menu-toggle d-lg-none" type="button" aria-label="Toggle navigation">
                <i class="fas fa-bars fs-4"></i>
            </button>

            <!-- Desktop menu -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 hidden-mobile">
                    <!-- Home -->
                    <li class="nav-item">
                        <a href="index.php" class="nav-link px-3 <?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(translate('home')); ?>
                        </a>
                    </li>

                    <!-- Catalog -->
                    <li class="nav-item">
                        <a href="catalog.php" class="nav-link px-3 <?php echo $currentPage === 'catalog' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(translate('catalog')); ?>
                        </a>
                    </li>

                    <!-- News -->
                    <li class="nav-item">
                        <a href="news.php" class="nav-link px-3 <?php echo $currentPage === 'news' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(translate('news')); ?>
                        </a>
                    </li>

                    <!-- Events -->
                    <li class="nav-item">
                        <a href="events.php" class="nav-link px-3 <?php echo $currentPage === 'events' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(translate('events')); ?>
                        </a>
                    </li>

                    <!-- Services Dropdown -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link px-3 dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars(translate('services')); ?>
                        </a>
                        <ul class="dropdown-menu border-0 shadow mt-0" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item py-2" href="services.php"><?php echo htmlspecialchars(translate('all_services')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="virtual-tour.php"><?php echo htmlspecialchars(translate('virtual_tour')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="online-services.php"><?php echo htmlspecialchars(translate('online_services')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="rules.php"><?php echo htmlspecialchars(translate('rules')); ?></a></li>
                        </ul>
                    </li>

                    <!-- About Dropdown -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link px-3 dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars(translate('about')); ?>
                        </a>
                        <ul class="dropdown-menu border-0 shadow mt-0" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item py-2" href="about.php"><?php echo htmlspecialchars(translate('about_library')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="history.php"><?php echo htmlspecialchars(translate('history')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="management.php"><?php echo htmlspecialchars(translate('management')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="structure.php"><?php echo htmlspecialchars(translate('structure')); ?></a></li>
                        </ul>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link px-3 <?php echo $currentPage === 'contact' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(translate('contact')); ?>
                        </a>
                    </li>
                </ul>

                <!-- Right side: Language and User menu -->
                <div class="d-flex align-items-center ms-auto">
                    <!-- Language Selector -->
                    <div class="me-3">
                        <select onchange="changeLanguage(this.value)" class="form-select form-select-sm language-selector">
                            <option value="uz" <?php echo $currentLang === 'uz' ? 'selected' : ''; ?>>O'zbekcha</option>
                            <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                            <option value="ru" <?php echo $currentLang === 'ru' ? 'selected' : ''; ?>>Русский</option>
                        </select>
                    </div>

                    <!-- User Menu -->
                    <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                                <i class="fas fa-user-circle fs-4 text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item py-2" href="profile.php"><i class="fas fa-user me-2"></i><?php echo htmlspecialchars(translate('profile')); ?></a></li>
                                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                                    <li><a class="dropdown-item py-2" href="admin/"><i class="fas fa-cogs me-2"></i><?php echo htmlspecialchars(translate('admin_panel')); ?></a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i><?php echo htmlspecialchars(translate('logout')); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-sm ms-2"><?php echo htmlspecialchars(translate('login')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay"></div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu visible-mobile">
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="fw-bold"><?php echo htmlspecialchars(translate('library_name')); ?></span>
                <button class="btn btn-link mobile-menu-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <ul class="nav flex-column space-y-modern">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(translate('home')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="catalog.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'catalog' ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(translate('catalog')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="news.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'news' ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(translate('news')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="events.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'events' ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(translate('events')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="services.php" class="nav-link px-3 py-2">
                        <?php echo htmlspecialchars(translate('services')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link px-3 py-2">
                        <?php echo htmlspecialchars(translate('about')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'contact' ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(translate('contact')); ?>
                    </a>
                </li>
            </ul>
            
            <div class="mt-4 pt-4 border-top">
                <select onchange="changeLanguage(this.value)" class="form-select form-select-sm mb-3 language-selector">
                    <option value="uz" <?php echo $currentLang === 'uz' ? 'selected' : ''; ?>>O'zbekcha</option>
                    <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                    <option value="ru" <?php echo $currentLang === 'ru' ? 'selected' : ''; ?>>Русский</option>
                </select>
                
                <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                    <a href="profile.php" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars(translate('profile')); ?>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm w-100"><?php echo htmlspecialchars(translate('login')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <script>
        // Language change function
        function changeLanguage(lang) {
            if (lang && ['uz', 'en', 'ru'].includes(lang)) {
                window.location.href = window.location.pathname + '?lang=' + encodeURIComponent(lang);
            }
        }

        // Fix viewport height for mobile
        function setViewportHeight() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
        
        setViewportHeight();
        window.addEventListener('resize', setViewportHeight);
        
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.querySelector('.mobile-menu');
            const mobileOverlay = document.querySelector('.mobile-overlay');
            const mobileClose = document.querySelector('.mobile-menu-close');
            
            function toggleMobileMenu() {
                mobileMenu.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            }
            
            mobileToggle?.addEventListener('click', toggleMobileMenu);
            mobileClose?.addEventListener('click', toggleMobileMenu);
            mobileOverlay?.addEventListener('click', toggleMobileMenu);
        });
    </script>