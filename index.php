<?php
require_once 'includes/header.php';

// Get latest news
$stmt = $pdo->prepare("SELECT * FROM news WHERE is_published = 1 ORDER BY created_at DESC LIMIT 6");
$stmt->execute();
$latestNews = $stmt->fetchAll();

// Get upcoming events
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_date >= NOW() AND is_published = 1 ORDER BY event_date ASC LIMIT 4");
$stmt->execute();
$upcomingEvents = $stmt->fetchAll();

// Get featured books
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       WHERE b.is_featured = 1 AND b.is_available = 1 
                       ORDER BY b.created_at DESC LIMIT 8");
$stmt->execute();
$featuredBooks = $stmt->fetchAll();
?>
<main>
    <!-- Hero Section -->
    <section class="relative bg-blue-900 text-white py-20 md:py-28 lg:py-36 xl:py-44 overflow-hidden">
        <!-- Background image with gradient overlay -->
        <div class="absolute inset-0 ">
            <!-- Responsive background image with multiple sources -->
            <picture>
                <!-- WebP format (avvalo) -->
                <source media="(max-width: 640px)" srcset="/images/library_bg.jpg" type="image/webp">
                <source media="(max-width: 1024px)" srcset="/images/library_bg.jpg" type="image/webp">
                <source srcset="/images/library_bg.jpg" type="image/webp">

                <!-- JPEG format (fallback) -->
                <source media="(max-width: 640px)" srcset="/images/hero-bg-small.jpg">
                <source media="(max-width: 1024px)" srcset="/images/hero-bg-medium.jpg">
                <source srcset="/images/library_bg.jpg">

                <img src="/images/library_bg.jpg" alt="Navoiy kutubxonasi interyeri"
                    class="w-full h-full object-cover object-center" loading="eager" width="1920" height="1080">
            </picture>

            <!-- Gradient overlay -->
            <div class="absolute inset-0bg-gradient-to-r from-blue-900 to-blue-700"></div>
        </div>

        <!-- Content container -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Logo (optional) -->
                <div class="mb-6 flex justify-center">
                    <img src="images/logo_2.png" alt="Navoiy kutubxonasi logotipi" class="h-16 md:h-20 w-auto">
                </div>

                <!-- Main heading with responsive text sizes -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    <?= translate('i1') ?><br> <?= translate('i2') ?>
                </h1>

                <!-- Subheading -->
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    <?= translate('i3')?>
                </p>

                <!-- Search Box -->
                <div class="max-w-2xl mx-auto mb-10">
                    <form action="/search.php" method="get" class="flex flex-col sm:flex-row gap-2">
                        <input type="text" name="q" placeholder="<?= translate('i4')?>"
                            class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg"
                            required>
                        <button type="submit"
                            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-lg">
                            <i class="fas fa-search mr-2"></i> <?=translate('i5')?>
                        </button>
                    </form>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/catalog.php" class="btn-primary-lg">
                        <i class="fas fa-book-open mr-2"></i> <?= translate('i6')?>
                    </a>
                    <a href="/register.php" class="btn-secondary-lg">
                        <i class="fas fa-user-plus mr-2"></i> <?= translate('i7')?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Scrolling indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <a href="#main-content" class="text-white text-2xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Main content anchor -->
    <div id="main-content" class="relative -top-20"></div>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= translate('i8')?></h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    <?= translate('i9')?>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('i10')?></h3>
                    <p class="text-gray-600 mb-4">
                        <?= translate('i11')?>
                    </p>
                    <a href="catalog.php" class="text-blue-600 hover:text-blue-800 font-medium">
                        <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 2 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('i12')?></h3>
                    <p class="text-gray-600 mb-4">
                        <?= translate('i13')?>
                    </p>
                    <a href="services.php" class="text-green-600 hover:text-green-800 font-medium">
                    <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 3 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"> <?= translate('i14')?></h3>
                    <p class="text-gray-600 mb-4">
                        <?= translate('i15')?>
                    </p>
                    <a href="events.php" class="text-purple-600 hover:text-purple-800 font-medium">
                         <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 4 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"> <?= translate('i16')?></h3>
                    <p class="text-gray-600 mb-4">
                    <?= translate('i17')?>
                    </p>
                    <a href="about.php" class="text-red-600 hover:text-red-800 font-medium">
                         <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 5 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('i18')?></h3>
                    <p class="text-gray-600 mb-4">
                    <?= translate('i19')?>
                    </p>
                    <a href="services.php" class="text-yellow-600 hover:text-yellow-800 font-medium">
                         <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 6 -->
                <div class="card-hover bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headphones text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('i20')?></h3>
                    <p class="text-gray-600 mb-4">
                    <?= translate('i21')?>
                    </p>
                    <a href="services.php" class="text-indigo-600 hover:text-indigo-800 font-medium">
                         <?= translate('ib')?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <?php if (!empty($featuredBooks)): ?>
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= translate('i22')?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                    <?= translate('i23')?>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($featuredBooks as $book): ?>
                        <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                            <img src="<?php echo $book['cover_image'] ? 'uploads/books/' . $book['cover_image'] : 'images/default-book.jpg'; ?>"
                                alt="<?php echo htmlspecialchars($book['title']); ?>" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($book['author_name']); ?></p>
                                <p class="text-gray-500 text-xs mb-3"><?php echo htmlspecialchars($book['publication_year']); ?>
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 text-sm font-medium">
                                        <?php echo $book['is_available'] ? 'Mavjud' : 'Mavjud emas'; ?>
                                    </span>
                                    <a href="book-detail.php?id=<?php echo $book['id']; ?>"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <?= translate('ib')?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-8">
                    <a href="catalog.php"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        <?= translate('i24')?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Latest News Section -->
    <?php if (!empty($latestNews)): ?>
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= translate('i25')?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                    <?= translate('i26')?>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach (array_slice($latestNews, 0, 6) as $news): ?>
                        <article class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                            <img src="<?php echo $news['image'] ? 'uploads/news/' . $news['image'] : 'images/default-news.jpg'; ?>"
                                alt="<?php echo htmlspecialchars($news['title']); ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo formatDate($news['created_at'], 'd.m.Y'); ?>
                                </div>
                                <h3 class="text-xl font-semibold mb-3 line-clamp-2">
                                    <?php echo htmlspecialchars($news['title']); ?>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    <?php echo htmlspecialchars(substr($news['content'], 0, 150)) . '...'; ?>
                                </p>
                                <a href="news-detail.php?id=<?php echo $news['id']; ?>"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    <?= translate('i27')?><i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-8">
                    <a href="news.php"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        <?= translate('i28')?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Upcoming Events Section -->
    <?php if (!empty($upcomingEvents)): ?>
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= translate('i29')?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                    <?= translate('i30')?>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="md:flex">
                                <div class="md:flex-shrink-0">
                                    <img src="<?php echo $event['image'] ? 'uploads/events/' . $event['image'] : 'images/default-event.jpg'; ?>"
                                        alt="<?php echo htmlspecialchars($event['title']); ?>"
                                        class="h-48 w-full object-cover md:w-48">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <?php echo formatDate($event['event_date'], 'd.m.Y H:i'); ?>
                                    </div>
                                    <h3 class="text-xl font-semibold mb-3">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?>
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <?php echo htmlspecialchars($event['location']); ?>
                                        </div>
                                        <a href="event-detail.php?id=<?php echo $event['id']; ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium">
                                            <?= translate('ib')?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-8">
                    <a href="events.php"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        <?= translate('i31')?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Statistics Section -->
    <section class="py-16 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4"><?= translate('i32')?></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                // Get statistics
                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM books WHERE is_available = 1");
                $stmt->execute();
                $booksCount = $stmt->fetchColumn();

                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
                $stmt->execute();
                $usersCount = $stmt->fetchColumn();

                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM events WHERE event_date >= NOW()");
                $stmt->execute();
                $eventsCount = $stmt->fetchColumn();

                $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM authors");
                $stmt->execute();
                $authorsCount = $stmt->fetchColumn();
                ?>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo number_format($booksCount); ?></div>
                    <div class="text-blue-100"><?= translate('i33')?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?= '10000+' ?></div>
                    <div class="text-blue-100"><?= translate('i34')?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo number_format($eventsCount); ?></div>
                    <div class="text-blue-100"><?= translate('i35')?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo number_format($authorsCount); ?></div>
                    <div class="text-blue-100"><?= translate('i36')?></div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>