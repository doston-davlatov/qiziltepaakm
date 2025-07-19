<?php
require_once 'includes/header.php';

// Get news with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 6;
$offset = ($page - 1) * $per_page;

// Get total count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM news WHERE is_published = 1");
$stmt->execute();
$total_news = $stmt->fetchColumn();
$total_pages = ceil($total_news / $per_page);

// Get news
$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name 
                       FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       WHERE n.is_published = 1 
                       ORDER BY n.created_at DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute([$per_page, $offset]);
$news = $stmt->fetchAll();

// Get featured news
$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name 
                       FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       WHERE n.is_published = 1 
                       ORDER BY n.created_at DESC 
                       LIMIT 3");
$stmt->execute();
$featured_news = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo translate('news'); ?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kutubxona hayotidan so'nggi yangiliklar va muhim xabarlar
            </p>
        </div>

        <!-- Featured News -->
        <?php if (!empty($featured_news)): ?>
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Asosiy yangiliklar</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($featured_news as $index => $item): ?>
                    <article class="<?php echo $index === 0 ? 'md:col-span-2' : ''; ?> card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $item['image'] ? 'uploads/news/' . $item['image'] : 'images/default-news.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 class="w-full <?php echo $index === 0 ? 'h-64' : 'h-48'; ?> object-cover">
                            <div class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo formatDate($item['created_at'], 'd.m.Y'); ?>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-3 line-clamp-2">
                                <a href="news-detail.php?id=<?php echo $item['id']; ?>" class="hover:text-blue-600 transition duration-300">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                <?php echo htmlspecialchars(substr(strip_tags($item['content']), 0, 150)) . '...'; ?>
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user mr-2"></i>
                                    <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?>
                                </div>
                                <a href="news-detail.php?id=<?php echo $item['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Batafsil <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- All News -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Barcha yangiliklar</h2>
            
            <?php if (empty($news)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Yangiliklar topilmadi</h3>
                    <p class="text-gray-500">Hozircha yangiliklar mavjud emas</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($news as $item): ?>
                        <article class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="relative">
                                <img src="<?php echo $item['image'] ? 'uploads/news/' . $item['image'] : 'images/default-news.jpg'; ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                     class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                    <?php echo formatDate($item['created_at'], 'd.m'); ?>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-3 line-clamp-2">
                                    <a href="news-detail.php?id=<?php echo $item['id']; ?>" class="hover:text-blue-600 transition duration-300">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    <?php echo htmlspecialchars(substr(strip_tags($item['content']), 0, 120)) . '...'; ?>
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-user mr-2"></i>
                                        <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?>
                                    </div>
                                    <a href="news-detail.php?id=<?php echo $item['id']; ?>" 
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Batafsil
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Oldingi
                        </a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>" 
                           class="px-3 py-2 text-sm <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border border-gray-300 rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" 
                           class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Keyingi<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>