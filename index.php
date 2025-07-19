<?php
require_once 'includes/header.php';

// Get latest news
$stmt = $pdo->prepare("SELECT n.*, u.first_name, u.last_name FROM news n 
                       JOIN users u ON n.author_id = u.id 
                       WHERE n.is_published = 1 ORDER BY n.created_at DESC LIMIT 6");
$stmt->execute();
$latestNews = $stmt->fetchAll();

// Get upcoming events
$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.event_date >= NOW() AND e.is_published = 1 ORDER BY e.event_date ASC LIMIT 4");
$stmt->execute();
$upcomingEvents = $stmt->fetchAll();

// Get featured books
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       WHERE b.is_featured = 1 AND b.is_available = 1 
                       ORDER BY b.created_at DESC LIMIT 12");
$stmt->execute();
$featuredBooks = $stmt->fetchAll();
?>

<main class="overflow-hidden">
    <!-- Hero Section -->
    <section class="hero-responsive hero-gradient text-white relative">
        <!-- Background image with gradient overlay -->
        <div class="absolute inset-0">
            <img src="images/library_bg.jpg" alt="<?php echo translate('library_name'); ?>" 
                 class="img-responsive img-responsive-landscape" loading="eager">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-blue-700/80"></div>
        </div>

        <!-- Content container -->
        <div class="container-responsive relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Logo (optional) -->
                <div class="mb-6">
                    <img src="images/logo_2.png" alt="<?php echo translate('library_name'); ?>" 
                         class="h-16 md:h-20 w-auto mx-auto">
                </div>

                <!-- Main heading with responsive text sizes -->
                <h1 class="text-responsive-xl font-bold mb-6 leading-tight">
                    <?php echo translate('i1'); ?><br>
                    <?php echo translate('i2'); ?>
                </h1>

                <!-- Subheading -->
                <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    <?php echo translate('i3'); ?>
                </p>

                <!-- Search Box -->
                <div class="max-w-2xl mx-auto mb-8">
                    <form action="search.php" method="get" class="flex-responsive">
                        <input type="text" name="q" placeholder="<?php echo translate('i4'); ?>"
                               class="input-modern flex-1" required>
                        <button type="submit" class="btn-modern btn-primary">
                            <i class="fas fa-search mr-2"></i><?php echo translate('i5'); ?>
                        </button>
                    </form>
                </div>

                <!-- Action buttons -->
                <div class="flex-responsive justify-center">
                    <a href="catalog.php" class="btn-modern btn-primary">
                        <i class="fas fa-book-open mr-2"></i><?php echo translate('i6'); ?>
                    </a>
                    <a href="register.php" class="btn-modern btn-secondary">
                        <i class="fas fa-user-plus mr-2"></i><?php echo translate('i7'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="spacing-responsive bg-white">
        <div class="container-responsive">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php echo translate('i8'); ?></h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    <?php echo translate('i9'); ?>
                </p>
            </div>

            <div class="grid-modern grid-responsive-md-2 grid-responsive-lg-3">
                <!-- Service 1 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i10'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i11'); ?>
                    </p>
                    <a href="catalog.php" class="text-blue-600 hover:text-blue-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 2 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i12'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i13'); ?>
                    </p>
                    <a href="services.php" class="text-green-600 hover:text-green-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 3 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i14'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i15'); ?>
                    </p>
                    <a href="events.php" class="text-purple-600 hover:text-purple-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 4 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i16'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i17'); ?>
                    </p>
                    <a href="about.php" class="text-red-600 hover:text-red-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 5 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i18'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i19'); ?>
                    </p>
                    <a href="services.php" class="text-yellow-600 hover:text-yellow-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Service 6 -->
                <div class="card-responsive card-hover p-6 text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headphones text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?php echo translate('i20'); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo translate('i21'); ?>
                    </p>
                    <a href="services.php" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        <?php echo translate('ib'); ?> <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <?php if (!empty($featuredBooks)): ?>
        <section class="spacing-responsive bg-gray-50">
            <div class="container-responsive">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php echo translate('i22'); ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        <?php echo translate('i23'); ?>
                    </p>
                </div>

                <!-- Books Slider -->
                <div class="swiper books-slider swiper-modern">
                    <div class="swiper-wrapper">
                        <?php foreach ($featuredBooks as $book): ?>
                            <div class="swiper-slide">
                                <div class="card-responsive card-hover">
                                    <img src="<?php echo $book['cover_image'] ? 'uploads/books/' . $book['cover_image'] : 'images/default-book.jpg'; ?>"
                                         alt="<?php echo htmlspecialchars($book['title']); ?>" 
                                         class="img-responsive img-responsive-portrait">
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                            <?php echo htmlspecialchars($book['title']); ?>
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($book['author_name']); ?></p>
                                        <p class="text-gray-500 text-xs mb-3"><?php echo htmlspecialchars($book['publication_year']); ?></p>
                                        <div class="flex justify-between items-center">
                                            <span class="status-indicator status-success">
                                                <?php echo $book['is_available'] ? translate('available') : translate('unavailable'); ?>
                                            </span>
                                            <a href="book-detail.php?id=<?php echo $book['id']; ?>"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <?php echo translate('ib'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="text-center mt-8">
                    <a href="catalog.php" class="btn-modern btn-primary">
                        <?php echo translate('i24'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Latest News Section -->
    <?php if (!empty($latestNews)): ?>
        <section class="spacing-responsive bg-white">
            <div class="container-responsive">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php echo translate('i25'); ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        <?php echo translate('i26'); ?>
                    </p>
                </div>

                <!-- News Slider -->
                <div class="swiper news-slider swiper-modern">
                    <div class="swiper-wrapper">
                        <?php foreach ($latestNews as $news): ?>
                            <div class="swiper-slide">
                                <article class="card-responsive card-hover">
                                    <img src="<?php echo $news['image'] ? 'uploads/news/' . $news['image'] : 'images/default-news.jpg'; ?>"
                                         alt="<?php echo htmlspecialchars($news['title']); ?>" 
                                         class="img-responsive img-responsive-landscape">
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
                                            <?php echo translate('i27'); ?><i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="text-center mt-8">
                    <a href="news.php" class="btn-modern btn-primary">
                        <?php echo translate('i28'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Upcoming Events Section -->
    <?php if (!empty($upcomingEvents)): ?>
        <section class="spacing-responsive bg-gray-50">
            <div class="container-responsive">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?php echo translate('i29'); ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        <?php echo translate('i30'); ?>
                    </p>
                </div>

                <!-- Events Slider -->
                <div class="swiper events-slider swiper-modern">
                    <div class="swiper-wrapper">
                        <?php foreach ($upcomingEvents as $event): ?>
                            <div class="swiper-slide">
                                <div class="card-responsive card-hover">
                                    <img src="<?php echo $event['image'] ? 'uploads/events/' . $event['image'] : 'images/default-event.jpg'; ?>"
                                         alt="<?php echo htmlspecialchars($event['title']); ?>"
                                         class="img-responsive img-responsive-landscape">
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
                                                <?php echo translate('ib'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="text-center mt-8">
                    <a href="events.php" class="btn-modern btn-primary">
                        <?php echo translate('i31'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Statistics Section -->
    <section class="spacing-responsive bg-blue-600">
        <div class="container-responsive">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4"><?php echo translate('i32'); ?></h2>
            </div>

            <div class="grid-modern grid-responsive-sm-2 grid-responsive-lg-4">
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
                    <div class="text-blue-100"><?php echo translate('i33'); ?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2">10,000+</div>
                    <div class="text-blue-100"><?php echo translate('i34'); ?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo number_format($eventsCount); ?></div>
                    <div class="text-blue-100"><?php echo translate('i35'); ?></div>
                </div>

                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo number_format($authorsCount); ?></div>
                    <div class="text-blue-100"><?php echo translate('i36'); ?></div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Include modern JavaScript -->
<script src="js/modern.js"></script>

<?php require_once 'includes/footer.php'; ?>