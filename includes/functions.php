<?php
session_start();

// Generate CSRF token
function generateCsrfToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Sanitize input
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Validate email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hash password
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Redirect function
function redirect($location)
{
    header("Location: $location");
    exit();
}

// Get current language
function getCurrentLanguage()
{
    return $_SESSION['language'] ?? DEFAULT_LANGUAGE;
}

// Set language
function setLanguage($lang)
{
    if (in_array($lang, AVAILABLE_LANGUAGES)) {
        $_SESSION['language'] = $lang;
    }
}

// Translation function
function translate($key, $lang = null)
{
    if ($lang === null) {
        $lang = getCurrentLanguage();
    }

    $translations = [
        'uz' => [
            'home' => 'Bosh sahifa',
            'services' => 'Xizmatlar',
            'catalog' => 'Katalog',
            'news' => 'Yangiliklar',
            'events' => 'Tadbirlar',
            'about' => 'Kutubxona haqida',
            'contact' => 'Aloqa',
            'login' => 'Kirish',
            'register' => 'Ro\'yxatdan o\'tish',
            'logout' => 'Chiqish',
            'profile' => 'Profil',
            'search' => 'Qidiruv',
            'welcome' => 'Xush kelibsiz',
            'library_name' => 'Qiziltepa AKM',
            'admin_panel' => 'Admin panel',
            'books' => 'Kitoblar',
            'authors' => 'Mualliflar',
            'genres' => 'Janrlar',
            'users' => 'Foydalanuvchilar',
            'dashboard' => 'Boshqaruv paneli',
            'all_services' => 'Xizmatlar',
            'virtual_tour' => 'Virtual sayohat',
            'online_services' => 'Onlayn xizmatlar',
            'rules' => 'Kutubxona qoidalari',
            'about_library' => 'Kutubxona haqida',
            'history' => 'Kutubxona tarixi',
            'management' => 'Boshqaruv',
            'structure' => 'Tuzilma',
            'about_1' => '- zamonaviy kutubxona xizmatlari va ilmiy tadqiqotlar markazi',
            'about_2' => 'Yaqinlashgan tadbirlar',
            'about_3' => 'Bizning tariximiz',
            'about_4' => ' 1995 yilda tashkil etilgan bo\'lib, Navoiy viloyatining eng yirik va zamonaviy kutubxonalaridan biri hisoblanadi.',
            'about_5' => ' Kutubxonamiz o\'z faoliyatini boshlagan kundan beri ilm-fan va madaniyatni rivojlantirishda muhim rol o\'ynab kelmoqda. Bizning maqsadimiz - O\'zbekiston xalqining boy adabiy va ilmiy merosini saqlab qolish hamda zamonaviy axborot texnologiyalari orqali keng jamoatchilikka yetkazishdir.',
            'about_6' => ' Bugungi kunda kutubxonamiz zamonaviy texnologiyalar bilan jihozlangan bo\'lib, elektron katalog, raqamli kutubxona, onlayn xizmatlar va boshqa ko\'plab imkoniyatlarni taklif etadi.',
            'about_7' => ' Bizning missiyamiz',
            'about_8' => ' Zamonaviy kutubxona xizmatlari orqali jamiyatga ilm-fan va madaniyat sohasida xizmat ko\'rsatish, talim-tarbiya jarayonini qo\'llab-quvvatlash va ilmiy tadqiqotlarni rag\'batlantirish.',
            'about_9' => ' Bizning vizyonimiz',
            'about_10' => ' Navoiy viloyatining ilm-fan va madaniyat markazi sifatida tanilgan, zamonaviy kutubxona xizmatlari va axborot texnologiyalarini joriy etgan, keng jamoatchilikka xizmat ko\'rsatuvchi kutubxona bo\'lish.',
            'about_11' => ' Bizning xizmatlarimiz',
            'about_12' => ' Elektron kitoblar',
            'about_13' => ' Kutubxonadagi barcha kitoblar va materiallarni onlayn qidirish imkoniyati',
            'about_14' => ' Raqamli kutubxona',
            'about_15' => ' Elektron kitoblar, jurnallar va boshqa raqamli resurslar',
            'about_16' => ' Ilmiy tadqiqot',
            'about_17' => ' Tadqiqotchilar uchun maxsus xizmatlar va ma\'lumotnomalar',
            'about_18' => ' Tadbirlar',
            'about_19' => ' Konferensiyalar, seminarlar va madaniy tadbirlar tashkil etish',
            'about_20' => ' O\'qitish',
            'about_21' => ' Kutubxona xizmatlari va axborot texnologiyalari bo\'yicha treninglar',
            'about_22' => ' Nusxalash',
            'about_23' => ' Zarur materiallarni nusxalash va chop etish xizmatlari',
            'about_24' => ' Bizning jamoa',
            'about_25' => ' Bizga murojaat qiling',
            'about_26' => ' Manzil',
            'about_27' => ' Qiziltepa shahar',
            'about_28' => ' Telefon',
            'about_29' => ' Email',
            'about_30' => ' Ish vaqti',
            'about_31' => ' Dush-Juma: 08:00-18:00',

            'h_1' => ' Kutubxona tarixi',
            'h_2' => ' Qiziltepa Axborot Kutubxona Markazning boy tarihi va rivojlanish yo\'li',
            'h3' => ' 2019 yil',
            'h4' => ' Kutubxona tashkil etilishi',
            'h5' => ' “O‘zbekiston Respublikasi aholisiga axborot-kutubxona xizmati ko‘rsatishni yanada takomillashtirish to‘g‘risida”gi PQ-4354-sonli qaror asosida 2020 yil yanvar oyidan faoliyatini boshlagan.',
            'h6' => ' 2020 yil',
            'h7' => ' Pandemiya va onlayn xizmatlar',
            'h8' => ' COVID-19 pandemiyasi davrida to\'liq onlayn xizmatlar ishga tushirildi va masofaviy ta\'lim qo\'llab-quvvatlandi.',
            'h9' => ' 2024 yil',
            'h10' => ' Zamonaviy kutubxona',
            'h_11' => ' Bugungi kunda kutubxonamiz 50,000+ kitob fondi, zamonaviy texnologiyalar va professional xizmatlar bilan ishlaydi.',
            'h12' => ' 2024 yil',
            'h13' => ' Modernizatsiya',
            'h14' => ' To\'liq  modernizatsiya amalga oshirildi. Zamonaviy jihozlar o\'rnatildi va Wi-Fi tarmog\'i yaratildi.',
            'h15' => ' 2025 yil',
            'h16' => ' Raqamli kutubxona',
            'h17' => ' Elektron kitoblar, jurnallar va boshqa raqamli resurslar bilan to\'ldirildi.',
            'h18' => ' 2025 yil',
            'h19' => ' Ilmiy tadqiqot',
            'h20' => ' Tadqiqotchilar uchun maxsus xizmatlar va ma\'lumotnomalar taqdim etildi.',
            'h21' => ' 2025 yil',
            'h22' => ' Web-site',
            'h23' => ' Qiziltepa tuman Axborot Kutubxona Markazning Websayti yaratildi',
            'h24' => ' Bugungi kunda',
            'h25' => ' Yillik tajriba',

            'm1' => ' Boshqaruv',
            'm2' => ' Qiziltepa Axborot Kutubxona Markazi rahbariyati va boshqaruv tizimi',
            'm3' => ' Boshqaruv jamoasi',
            'm4' => ' Bo\'limlar',
            'm5' => ' Fond to\'plash bo\'limi',
            'm6' => ' Yangi kitoblar va materiallarni sotib olish, fond rivojlantirish va nashriyotlar bilan aloqa o\'rnatish.',
            'm7' => ' • Yangi nashrlarni kuzatish',
            'm8' => ' • Nashriyotlar bilan shartnomalar',
            'm9' => ' • Fond tahlili va rejalashtirish',
            'm10' => ' Kataloglash bo\'limi',
            'm11' => ' Kitoblarni kataloglash, tasnif qilish va elektron katalogni yuritish bo\'yicha ishlar.',
            'm12' => ' • Kitoblarni kataloglash',
            'm13' => ' • Elektron katalogni yangilash',
            'm14' => ' • Kitoblarni tasniflash',
            'm15' => ' O\'quvchilar xizmati bo\'limi',
            'm16' => ' Foydalanuvchilarga xizmat ko\'rsatish, kitob berish va ma\'lumot-bibliografik yordam.',
            'm17' => ' • Kitob berish',
            'm18' => ' • Foydalanuvchilarga maslahatlar',
            'm19' => ' • Ma\'lumot-bibliografik yordam',
            'm20' => ' Raqamli xizmatlar bo\'limi',
            'm21' => ' Elektron resurslar, raqamli kutubxona va IT xizmatlarini boshqarish va rivojlantirish.',
            'm22' => ' • Elektron kitoblar boshqaruvi',
            'm23' => ' • Veb-sayt va onlayn xizmatlar',
            'm24' => ' • Texnik yordam va ta\'lim',
            'm25' => ' Tashkiliy tuzilma',
            'm26' => ' Direktor',
            'm27' => ' Direktor o\'rinbosari',
            'm28' => ' Bosh kutubxonachi',
            'm29' => ' IT bo\'limi boshlig\'i',
            'm30' => ' Fond to\'plash bo\'limi',
            'm31' => ' Kataloglash bo\'limi',
            'm32' => ' O\'quvchilar xizmati',
            'm33' => ' Raqamli xizmatlar',

            's' => ' Kutubxona tuzilmasi',
            's1' => ' Qiziltepa Akademik Kutubxonasining ichki tuzilmasi va bo\'limlar',
            's2' => ' Bino rejasi',
            's3' => ' 1-qavat',
            's4' => ' Kirish zali',
            's5' => ' Qabul va ro\'yxatdan o\'tish',
            's6' => ' Ma\'lumot xizmati',
            's7' => ' Foydalanuvchilarga yordam',
            's8' => ' Periodika zali',
            's9' => ' Gazeta va jurnallar',
            's10' => ' Bolalar bo\'limi',
            's11' => ' 14 yoshgacha bolalar uchun',
            's12' => ' 2-qavat',
            's13' => ' Asosiy fond',
            's14' => ' Badiy va ilmiy adabiyot',
            's15' => ' O\'qish zali',
            's16' => ' 100 o\'rinli asosiy zal',
            's17' => ' Kompyuter zali',
            's18' => ' 20 ta ish joyi',
            's19' => ' Boshqaruv',
            's20' => ' Direktor va xodimlar xonalari',
            's21' => ' Fondlar tuzilmasi',
            's22' => ' Badiy adabiyot',
            's23' => ' O\'zbek va jahon adabiyoti asarlari',
            's24' => ' 15,000+',
            's25' => ' kitob',
            's26' => ' Ilmiy adabiyot',
            's27' => ' Turli sohalardagi ilmiy kitoblar',
            's28' => ' 20,000+',
            's29' => ' O\'quv adabiyoti',
            's30' => ' Darsliklar va o\'quv qo\'llanmalar',
            's31' => ' Periodika',
            's32' => ' Gazeta va jurnallar',
            's33' => ' nom',
            's34' => ' Elektron resurslar',
            's35' => ' Raqamli kitoblar va ma\'lumotlar',
            's36' => ' fayl',
            's37' => ' Bolalar fondi',
            's38' => ' Bolalar uchun kitoblar',
            's39' => ' Xizmatlar joylashuvi',
            's40' => ' 1-qavat xizmatlari',
            's41' => ' Foydalanuvchilarni ro\'yxatga olish',
            's42' => ' Ma\'lumot-bibliografik xizmat',
            's43' => ' Periodika bilan tanishish',
            's44' => ' Bolalar uchun maxsus xizmatlar',
            's45' => ' 2-qavat xizmatlari',
            's46' => ' Kitoblar bilan ishlash',
            's47' => ' O\'qish zallari',
            's48' => ' Kompyuter va internet',
            's49' => ' Elektron katalog',

            'i1' => ' Qiziltepa tuman Axborot Kutubxona Markaziga',
            'i2' => ' Xush kelibsiz',
            'i3' => ' Zamonaviy kutubxona xizmatlari va elektron resurslar bilan tanishing',
            'i4' => ' Kitob, muallif yoki ISBN qidirish...',
            'i5' => ' Qidirish',
            'i6' => ' Katalogga o\'tish',
            'i7' => ' A\'zo bo\'lish',
            'i8' => ' Bizning xizmatlarimiz',
            'i9' => ' Kutubxonamiz zamonaviy xizmatlar va elektron resurslar bilan ta\'minlangan',
            'i10' => ' Elektron katalog',
            'i11' => ' Minglab kitoblar va materiallar onlayn katalogida',
            'ib' => ' Batafsil',
            'i12' => ' Elektron resurslar',
            'i13' => ' Onlayn kitoblar, jurnallar va ma\'lumotnomalar',
            'i14' => ' Tadbirlar',
            'i15' => ' Ilmiy konferensiyalar, seminalar va boshqa tadbirlar',
            'i16' => ' O\'qish zallari',
            'i17' => ' Zamonaviy va qulay o\'qish xonalari',
            'i18' => ' Wi-Fi internet',
            'i19' => ' Bepul yuqori tezlikli internet ulanishi',
            'i20' => ' Audio kitoblar',
            'i21' => ' Ovozli kitoblar va audio materiallar',
            'i22' => ' Tavsiya etilgan kitoblar',
            'i23' => ' Eng mashhur va foydali kitoblar to\'plami',
            'i24' => ' Barcha kitoblar',
            'i25' => ' So\'nggi yangiliklar',
            'i26' => ' Kutubxona hayoti va tadbirlardan eng yangi xabarlar',
            'i27' => ' Batafsil o\'qish',
            'i28' => ' Barcha yangiliklar',
            'i29' => ' Yaqinlashib kelayotgan tadbirlar',
            'i30' => ' Ilmiy konferensiyalar, seminalar va boshqa tadbirlarga qo\'shiling',
            'i31' => ' Barcha tadbirlar',
            'i32' => ' Raqamlarda kutubxona',
            'i33' => ' Kitoblar',
            'i34' => ' Foydalanuvchilar',
            'i35' => ' Tadbirlar',
            'i36' => ' Mualliflar',

            

        ],
        'en' => [
            'home' => 'Home',
            'services' => 'Services',
            'catalog' => 'Catalog',
            'news' => 'News',
            'events' => 'Events',
            'about' => 'About',
            'contact' => 'Contact',
            'login' => 'Login',
            'register' => 'Register',
            'logout' => 'Logout',
            'profile' => 'Profile',
            'search' => 'Search',
            'welcome' => 'Welcome',
            'library_name' => 'Navoiy Academic Library',
            'admin_panel' => 'Admin Panel',
            'books' => 'Books',
            'authors' => 'Authors',
            'genres' => 'Genres',
            'users' => 'Users',
            'dashboard' => 'Dashboard'
        ],
        'ru' => [
            'home' => 'Главная',
            'services' => 'Услуги',
            'catalog' => 'Каталог',
            'news' => 'Новости',
            'events' => 'События',
            'about' => 'О нас',
            'contact' => 'Контакты',
            'login' => 'Вход',
            'register' => 'Регистрация',
            'logout' => 'Выход',
            'profile' => 'Профиль',
            'search' => 'Поиск',
            'welcome' => 'Добро пожаловать',
            'library_name' => 'Навоийская Академическая Библиотека',
            'admin_panel' => 'Панель администратора',
            'books' => 'Книги',
            'authors' => 'Авторы',
            'genres' => 'Жанры',
            'users' => 'Пользователи',
            'dashboard' => 'Панель управления'
        ]
    ];

    return $translations[$lang][$key] ?? $key;
}

// Upload file function
function uploadFile($file, $directory, $allowedTypes = null)
{
    if ($allowedTypes === null) {
        $allowedTypes = ALLOWED_IMAGE_TYPES;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check file size
    if ($fileSize > MAX_FILE_SIZE) {
        return false;
    }

    // Check file type
    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    // Generate unique filename
    $newFileName = uniqid() . '.' . $fileType;
    $destination = $directory . $newFileName;

    // Create directory if it doesn't exist
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($fileTmpName, $destination)) {
        return $newFileName;
    }

    return false;
}

// Pagination function
function paginate($currentPage, $totalItems, $itemsPerPage = 10)
{
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;

    return [
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'items_per_page' => $itemsPerPage,
        'offset' => $offset,
        'total_items' => $totalItems
    ];
}

// Format date
function formatDate($date, $format = 'Y-m-d H:i:s')
{
    return date($format, strtotime($date));
}

// Get user IP
function getUserIP()
{
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

function uploadsFile($file, $target_dir, $allowed_types = ['jpg', 'jpeg', 'png', 'gif'])
{
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    }

    // Check file size (5MB max)
    if ($file["size"] > 5000000) {
        return false;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, $allowed_types)) {
        return false;
    }

    // Try to upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false;
    }
}

// Log activity
function logActivity($action, $userId = null, $details = null)
{
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO activity_log (user_id, action, details, ip_address, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $userId ?? ($_SESSION['user_id'] ?? null),
        $action,
        $details,
        getUserIP()
    ]);
}
?>