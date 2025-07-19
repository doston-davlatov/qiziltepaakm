<?php
require_once 'includes/header.php';

// Get events with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 6;
$offset = ($page - 1) * $per_page;

// Get total count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM events WHERE is_published = 1");
$stmt->execute();
$total_events = $stmt->fetchColumn();
$total_pages = ceil($total_events / $per_page);

// Get events
$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name 
                       FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.is_published = 1 
                       ORDER BY e.event_date ASC 
                       LIMIT ? OFFSET ?");
$stmt->execute([$per_page, $offset]);
$events = $stmt->fetchAll();

// Get upcoming events
$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name 
                       FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.is_published = 1 AND e.event_date >= NOW() 
                       ORDER BY e.event_date ASC 
                       LIMIT 6");
$stmt->execute();
$upcoming_events = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?php echo translate('events'); ?></h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kutubxonamizda bo'lib o'tadigan ilmiy konferensiyalar, seminalar va boshqa tadbirlar
            </p>
        </div>

        <!-- Event Categories -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="?filter=all" class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
                    Barcha tadbirlar
                </a>
                <a href="?filter=upcoming" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition duration-300">
                    Yaqinlashayotgan
                </a>
                <a href="?filter=past" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition duration-300">
                    O'tgan tadbirlar
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        <?php if (!empty($upcoming_events)): ?>
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Yaqinlashayotgan tadbirlar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($upcoming_events as $event): ?>
                    <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $event['image'] ? 'uploads/events/' . $event['image'] : 'images/default-event.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 left-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo formatDate($event['event_date'], 'd.m.Y'); ?>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-3">
                                <?php echo htmlspecialchars($event['title']); ?>
                            </h3>
                            <p class="text-gray-600 mb-4">
                                <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?>
                            </p>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo formatDate($event['event_date'], 'd.m.Y H:i'); ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <?php echo htmlspecialchars($event['location']); ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-users mr-2"></i>
                                    <?php echo $event['registered_count']; ?>/<?php echo $event['capacity']; ?> ishtirokchi
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="event-detail.php?id=<?php echo $event['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Batafsil
                                </a>
                                <?php if ($event['registered_count'] < $event['capacity']): ?>
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                                        Ro'yxatdan o'tish
                                    </button>
                                <?php else: ?>
                                    <span class="text-red-600 font-medium">To'liq</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- All Events -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Barcha tadbirlar</h2>
            
            <?php if (empty($events)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-calendar-alt text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tadbirlar topilmadi</h3>
                    <p class="text-gray-500">Hozircha tadbirlar mavjud emas</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($events as $event): ?>
                        <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="md:flex">
                                <div class="md:flex-shrink-0">
                                    <img src="<?php echo $event['image'] ? 'uploads/events/' . $event['image'] : 'images/default-event.jpg'; ?>" 
                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                         class="h-48 w-full object-cover md:w-48">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center mb-2">
                                        <span class="<?php echo strtotime($event['event_date']) > time() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?> px-2 py-1 rounded-full text-xs font-medium">
                                            <?php echo strtotime($event['event_date']) > time() ? 'Yaqinlashayotgan' : 'O\'tgan'; ?>
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-semibold mb-3">
                                        <?php echo htmlspecialchars($event['title']); ?>
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?>
                                    </p>
                                    <div class="space-y-1 mb-4">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-calendar mr-2"></i>
                                            <?php echo formatDate($event['event_date'], 'd.m.Y H:i'); ?>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <?php echo htmlspecialchars($event['location']); ?>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <a href="event-detail.php?id=<?php echo $event['id']; ?>" 
                                           class="text-blue-600 hover:text-blue-800 font-medium">
                                            Batafsil
                                        </a>
                                        <?php if (strtotime($event['event_date']) > time() && $event['registered_count'] < $event['capacity']): ?>
                                            <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                                                Ro'yxatdan o'tish
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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