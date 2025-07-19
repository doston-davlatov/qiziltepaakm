<?php
require_once 'functions.php';
require_once 'db_connect.php';
require_once 'config.php';

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
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

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

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
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

        .nav-link-custom {
            position: relative;
            transition: all 0.3s ease;
            color: #6c757d;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #0d6efd;
        }

        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .nav-link-custom:hover::after,
        .nav-link-custom.active::after {
            width: 100%;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../images/logo_2.png" alt="Library Logo" class="h-12 me-3">
                <span class="fs-5 fw-bold text-dark"><?php echo translate('library_name'); ?></span>
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Main menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link nav-link-custom <?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                            <?php echo translate('home'); ?>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="catalog.php" class="nav-link nav-link-custom <?php echo $currentPage === 'books' ? 'active' : ''; ?>">
                            <?php echo translate('catalog'); ?>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="news.php" class="nav-link nav-link-custom <?php echo $currentPage === 'news' ? 'active' : ''; ?>">
                            <?php echo translate('news'); ?>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="events.php" class="nav-link nav-link-custom <?php echo $currentPage === 'events' ? 'active' : ''; ?>">
                            <?php echo translate('events'); ?>
                        </a>
                    </li>
                    
                    <!-- Services dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?php echo translate('services'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="services.php"><?php echo translate('all_services'); ?></a></li>
                            <li><a class="dropdown-item" href="virtual-tour.php"><?php echo translate('virtual_tour'); ?></a></li>
                            <li><a class="dropdown-item" href="online-services.php"><?php echo translate('online_services'); ?></a></li>
                            <li><a class="dropdown-item" href="rules.php"><?php echo translate('rules'); ?></a></li>
                        </ul>
                    </li>
                    
                    <!-- About dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?php echo translate('about'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="about.php"><?php echo translate('about_library'); ?></a></li>
                            <li><a class="dropdown-item" href="history.php"><?php echo translate('history'); ?></a></li>
                            <li><a class="dropdown-item" href="management.php"><?php echo translate('management'); ?></a></li>
                            <li><a class="dropdown-item" href="structure.php"><?php echo translate('structure'); ?></a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link nav-link-custom <?php echo $currentPage === 'contact' ? 'active' : ''; ?>">
                            <?php echo translate('contact'); ?>
                        </a>
                    </li>
                </ul>

                <!-- Right side elements -->
                <div class="d-flex align-items-center">
                    <!-- Language selector -->
                    <select onchange="changeLanguage(this.value)" class="form-select form-select-sm me-3" style="width: auto;">
                        <option value="uz" <?php echo $currentLang === 'uz' ? 'selected' : ''; ?>>O'zbekcha</option>
                        <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                        <option value="ru" <?php echo $currentLang === 'ru' ? 'selected' : ''; ?>>Русский</option>
                    </select>

                    <!-- User menu -->
                    <?php if (isLoggedIn()): ?>
                        <div class="dropdown">
                            <a class="btn btn-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fs-4 text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i><?php echo translate('profile'); ?></a></li>
                                <?php if (isAdmin()): ?>
                                    <li><a class="dropdown-item" href="admin/"><i class="fas fa-cogs me-2"></i><?php echo translate('admin_panel'); ?></a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i><?php echo translate('logout'); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary ms-2">
                            <?php echo translate('login'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <script>
        // Language change function
        function changeLanguage(lang) {
            window.location.href = window.location.pathname + '?lang=' + lang;
        }
    </script>
</body>
</html>