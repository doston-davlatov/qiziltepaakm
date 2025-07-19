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

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Moved other styles to styles.css for maintainability */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu.show {
            max-height: 1000px;
            transition: max-height 0.5s ease-in;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php" aria-label="<?php echo htmlspecialchars(translate('library_name')); ?>">
                <img src="images/logo_2.png" alt="<?php echo htmlspecialchars(translate('library_name')); ?> Logo" class="h-12 me-2">
                <span class="fs-5 fw-bold text-dark"><?php echo htmlspecialchars(translate('library_name')); ?></span>
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars fs-4"></i>
            </button>

            <!-- Desktop menu -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <!-- Home -->
                    <li class="nav-item">
                        <a href="index.php" class="nav-link nav-link-custom px-3 <?php echo $currentPage === 'index' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'index' ? 'page' : ''; ?>">
                            <?php echo htmlspecialchars(translate('home')); ?>
                        </a>
                    </li>

                    <!-- Catalog -->
                    <li class="nav-item">
                        <a href="catalog.php" class="nav-link nav-link-custom px-3 <?php echo $currentPage === 'books' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'books' ? 'page' : ''; ?>">
                            <?php echo htmlspecialchars(translate('catalog')); ?>
                        </a>
                    </li>

                    <!-- News -->
                    <li class="nav-item">
                        <a href="news.php" class="nav-link nav-link-custom px-3 <?php echo $currentPage === 'news' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'news' ? 'page' : ''; ?>">
                            <?php echo htmlspecialchars(translate('news')); ?>
                        </a>
                    </li>

                    <!-- Events -->
                    <li class="nav-item">
                        <a href="events.php" class="nav-link nav-link-custom px-3 <?php echo $currentPage === 'events' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'events' ? 'page' : ''; ?>">
                            <?php echo htmlspecialchars(translate('events')); ?>
                        </a>
                    </li>

                    <!-- Services Dropdown -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link nav-link-custom px-3 dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars(translate('services')); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom border-0 shadow mt-0 w-100" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item py-2" href="services.php"><?php echo htmlspecialchars(translate('all_services')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="virtual-tour.php"><?php echo htmlspecialchars(translate('virtual_tour')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="online-services.php"><?php echo htmlspecialchars(translate('online_services')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="rules.php"><?php echo htmlspecialchars(translate('rules')); ?></a></li>
                        </ul>
                    </li>

                    <!-- About Dropdown -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link nav-link-custom px-3 dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars(translate('about')); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom border-0 shadow mt-0 w-100" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item py-2" href="about.php"><?php echo htmlspecialchars(translate('about_library')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="history.php"><?php echo htmlspecialchars(translate('history')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="management.php"><?php echo htmlspecialchars(translate('management')); ?></a></li>
                            <li><a class="dropdown-item py-2" href="structure.php"><?php echo htmlspecialchars(translate('structure')); ?></a></li>
                        </ul>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link nav-link-custom px-3 <?php echo $currentPage === 'contact' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'contact' ? 'page' : ''; ?>">
                            <?php echo htmlspecialchars(translate('contact')); ?>
                        </a>
                    </li>
                </ul>

                <!-- Right side: Language and User menu -->
                <div class="d-flex align-items-center ms-auto">
                    <!-- Language Selector -->
                    <div class="me-3">
                        <select onchange="changeLanguage(this.value)" class="form-select form-select-sm" aria-label="Select language">
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
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom border-0 shadow" aria-labelledby="userDropdown">
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

    <!-- Mobile Menu -->
    <div class="mobile-menu bg-white shadow-sm" id="mobileMenu">
        <div class="container py-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'index' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'index' ? 'page' : ''; ?>">
                        <?php echo htmlspecialchars(translate('home')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="catalog.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'books' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'books' ? 'page' : ''; ?>">
                        <?php echo htmlspecialchars(translate('catalog')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="news.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'news' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'news' ? 'page' : ''; ?>">
                        <?php echo htmlspecialchars(translate('news')); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="events.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'events' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'events' ? 'page' : ''; ?>">
                        <?php echo htmlspecialchars(translate('events')); ?>
                    </a>
                </li>
                <!-- Services Dropdown -->
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#mobileServices" role="button" aria-expanded="false" aria-controls="mobileServices">
                        <?php echo htmlspecialchars(translate('services')); ?>
                        <i class="fas fa-chevron-down fs-6"></i>
                    </a>
                    <div class="collapse ps-3" id="mobileServices">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="services.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('all_services')); ?></a></li>
                            <li class="nav-item"><a href="virtual-tour.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('virtual_tour')); ?></a></li>
                            <li class="nav-item"><a href="online-services.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('online_services')); ?></a></li>
                            <li class="nav-item"><a href="rules.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('rules')); ?></a></li>
                        </ul>
                    </div>
                </li>
                <!-- About Dropdown -->
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#mobileAbout" role="button" aria-expanded="false" aria-controls="mobileAbout">
                        <?php echo htmlspecialchars(translate('about')); ?>
                        <i class="fas fa-chevron-down fs-6"></i>
                    </a>
                    <div class="collapse ps-3" id="mobileAbout">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="about.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('about_library')); ?></a></li>
                            <li class="nav-item"><a href="history.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('history')); ?></a></li>
                            <li class="nav-item"><a href="management.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('management')); ?></a></li>
                            <li class="nav-item"><a href="structure.php" class="nav-link px-3 py-2"><?php echo htmlspecialchars(translate('structure')); ?></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link px-3 py-2 <?php echo $currentPage === 'contact' ? 'active' : ''; ?>" aria-current="<?php echo $currentPage === 'contact' ? 'page' : ''; ?>">
                        <?php echo htmlspecialchars(translate('contact')); ?>
                    </a>
                </li>
            </ul>
            <div class="d-flex justify-content-between align-items-center mt-3 px-3 py-2 border-top">
                <select onchange="changeLanguage(this.value)" class="form-select form-select-sm w-auto" aria-label="Select language for mobile">
                    <option value="uz" <?php echo $currentLang === 'uz' ? 'selected' : ''; ?>>O'zbekcha</option>
                    <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                    <option value="ru" <?php echo $currentLang === 'ru' ? 'selected' : ''; ?>>Русский</option>
                </select>
                <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                    <a href="profile.php" class="btn btn-outline-secondary btn-sm ms-2">
                        <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars(translate('profile')); ?>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm ms-2"><?php echo htmlspecialchars(translate('login')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" integrity="sha384-yA3Ax2C+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1B5Yk+1" crossorigin="anonymous"></script>
    <script>
        // Language change function
        function changeLanguage(lang) {
            if (lang && ['uz', 'en', 'ru'].includes(lang)) {
                window.location.href = window.location.pathname + '?lang=' + encodeURIComponent(lang);
            }
        }

        // Mobile menu toggle
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('show');
        });
    </script>
</body>
</html>