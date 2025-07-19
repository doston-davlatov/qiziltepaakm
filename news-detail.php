<?php
require_once 'includes/header.php';

// Get news ID from URL
$news_id = $_GET['id'] ?? 0;

if (!$news_id) {
    redirect('news.php');
}

// Get news details
$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name 
                       FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       WHERE n.id = ? AND n.is_published = 1");
$stmt->execute([$news_id]);
$news = $stmt->fetch();

if (!$news) {
    redirect('news.php');
}

// Get related news
$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name 
                       FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       WHERE n.id != ? AND n.is_published = 1 
                       ORDER BY n.created_at DESC 
                       LIMIT 4");
$stmt->execute([$news_id]);
$related_news = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="../index.php" class="hover:text-blue-600">Bosh sahifa</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="news.php" class="hover:text-blue-600">Yangiliklar</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-900"><?php echo htmlspecialchars(substr($news['title'], 0, 50)) . '...'; ?></li>
            </ol>
        </nav>

        <!-- News Article -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <!-- Featured Image -->
            <?php if ($news['image']): ?>
            <div class="relative">
                <img src="../uploads/news/<?php echo $news['image']; ?>" 
                     alt="<?php echo htmlspecialchars($news['title']); ?>" 
                     class="w-full h-64 md:h-96 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>
            <?php endif; ?>

            <div class="p-8">
                <!-- Article Header -->
                <header class="mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo htmlspecialchars($news['title']); ?>
                    </h1>
                    
                    <div class="flex items-center text-gray-600 text-sm space-x-4">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            <span><?php echo htmlspecialchars($news['first_name'] . ' ' . $news['last_name']); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2"></i>
                            <span><?php echo formatDate($news['created_at'], 'd.m.Y H:i'); ?></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            <span>Ko'rildi</span>
                        </div>
                    </div>
                </header>

                <!-- Article Content -->
                <div class="prose prose-lg max-w-none">
                    <?php echo nl2br(htmlspecialchars($news['content'])); ?>
                </div>

                <!-- Share Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Ulashish:</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-facebook-f mr-2"></i>Facebook
                        </a>
                        <a href="#" class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition duration-300">
                            <i class="fab fa-twitter mr-2"></i>Twitter
                        </a>
                        <a href="https://t.me/doston_l1ghtdream22_55" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition duration-300">
                            <i class="fab fa-telegram mr-2"></i>Telegram
                        </a>
                        <button onclick="copyToClipboard('click')" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            <i class="fas fa-link mr-2"></i>Havolani nusxalash
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related News -->
        <?php if (!empty($related_news)): ?>
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">O'xshash yangiliklar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($related_news as $item): ?>
                    <article class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $item['image'] ? '../uploads/news/' . $item['image'] : '../images/default-news.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
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
        </section>
        <?php endif; ?>

        <!-- Back to News -->
        <div class="mt-8 text-center">
            <a href="news.php" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Barcha yangiliklarga qaytish
            </a>
        </div>
    </div>
</main>

<script>
function copyToClipboard('click') {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        showNotification('Havola nusxalandi!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showNotification('Havolani nusxalashda xatolik!', 'error');
    });
}
</script>

<?php require_once './includes/footer.php'; ?>