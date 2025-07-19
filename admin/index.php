<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
require_once '../includes/config.php';
require_once 'header.php';


// Get statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM books");
$stmt->execute();
$total_books = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
$stmt->execute();
$total_users = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM events WHERE event_date >= NOW()");
$stmt->execute();
$upcoming_events = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM news WHERE is_published = 1");
$stmt->execute();
$published_news = $stmt->fetchColumn();

// Get recent activities
$stmt = $pdo->prepare("SELECT al.*, u.email as user_email FROM activity_log al 
                       LEFT JOIN users u ON al.user_id = u.id 
                       ORDER BY al.created_at DESC LIMIT 10");
$stmt->execute();
$recent_activities = $stmt->fetchAll();

// Get recent books
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       ORDER BY b.created_at DESC LIMIT 5");
$stmt->execute();
$recent_books = $stmt->fetchAll();
?>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo translate('dashboard'); ?></h1>
            <p class="text-gray-600">Kutubxona boshqaruv paneli</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Jami kitoblar</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($total_books); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Foydalanuvchilar</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($total_users); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Yaqinlashgan tadbirlar</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($upcoming_events); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-newspaper text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Yangiliklar</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo number_format($published_news); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Tezkor amallar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="books.php" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-300">
                    <i class="fas fa-book text-blue-600 mr-3"></i>
                    <span class="text-blue-900 font-medium">Kitoblar boshqaruvi</span>
                </a>
                <a href="users.php" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-300">
                    <i class="fas fa-users text-green-600 mr-3"></i>
                    <span class="text-green-900 font-medium">Foydalanuvchilar</span>
                </a>
                <a href="events.php" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-300">
                    <i class="fas fa-calendar-alt text-purple-600 mr-3"></i>
                    <span class="text-purple-900 font-medium">Tadbirlar</span>
                </a>
                <a href="news.php" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-300">
                    <i class="fas fa-newspaper text-yellow-600 mr-3"></i>
                    <span class="text-yellow-900 font-medium">Yangiliklar</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">So'nggi faollik</h2>
                <div class="space-y-4">
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <i class="fas fa-activity text-gray-500"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($activity['action']); ?></p>
                                <p class="text-xs text-gray-500">
                                    <?php echo $activity['user_email'] ? htmlspecialchars($activity['user_email']) : 'System'; ?> - 
                                    <?php echo formatDate($activity['created_at'], 'd.m.Y H:i'); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Books -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">So'nggi qo'shilgan kitoblar</h2>
                <div class="space-y-4">
                    <?php foreach ($recent_books as $book): ?>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <img src="<?php echo $book['cover_image'] ? '../uploads/books/' . $book['cover_image'] : '../images/default-book.jpg'; ?>" 
                                     alt="<?php echo htmlspecialchars($book['title']); ?>" 
                                     class="w-12 h-16 object-cover rounded">
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($book['title']); ?></p>
                                <p class="text-xs text-gray-500">
                                    <?php echo htmlspecialchars($book['author_name']); ?> - 
                                    <?php echo formatDate($book['created_at'], 'd.m.Y'); ?>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="books.php?edit=<?php echo $book['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    Tahrirlash
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- <?php require_once 'footer.php'; ?> -->