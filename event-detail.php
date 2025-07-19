<?php
require_once 'includes/header.php';

// Get event ID from URL
$event_id = $_GET['id'] ?? 0;

if (!$event_id) {
    redirect('events.php');
}

// Get event details
$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name 
                       FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.id = ? AND e.is_published = 1");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    redirect('events.php');
}

// Check if user is already registered
$is_registered = false;
if (isLoggedIn()) {
    $stmt = $pdo->prepare("SELECT id FROM event_registrations WHERE event_id = ? AND user_id = ?");
    $stmt->execute([$event_id, $_SESSION['user_id']]);
    $is_registered = $stmt->fetch() ? true : false;
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
    
    $csrf_token = $_POST['csrf_token'];
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        if (!$is_registered && $event['registered_count'] < $event['capacity']) {
            $stmt = $pdo->prepare("INSERT INTO event_registrations (event_id, user_id, registration_date) VALUES (?, ?, NOW())");
            if ($stmt->execute([$event_id, $_SESSION['user_id']])) {
                // Update registered count
                $stmt = $pdo->prepare("UPDATE events SET registered_count = registered_count + 1 WHERE id = ?");
                $stmt->execute([$event_id]);
                
                $success = 'Siz tadbirga muvaffaqiyatli ro\'yxatdan o\'tdingiz!';
                $is_registered = true;
                $event['registered_count']++;
                
                logActivity('Event registration', $_SESSION['user_id'], "Event: " . $event['title']);
            }
        }
    }
}

// Get related events
$stmt = $pdo->prepare("SELECT e.*, u.first_name, u.last_name 
                       FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.id != ? AND e.is_published = 1 AND e.event_date >= NOW() 
                       ORDER BY e.event_date ASC 
                       LIMIT 3");
$stmt->execute([$event_id]);
$related_events = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="index.php" class="hover:text-blue-600">Bosh sahifa</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="events.php" class="hover:text-blue-600">Tadbirlar</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-900"><?php echo htmlspecialchars(substr($event['title'], 0, 50)) . '...'; ?></li>
            </ol>
        </nav>

        <!-- Event Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <!-- Featured Image -->
            <?php if ($event['image']): ?>
            <div class="relative">
                <img src="uploads/events/<?php echo $event['image']; ?>" 
                     alt="<?php echo htmlspecialchars($event['title']); ?>" 
                     class="w-full h-64 md:h-96 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                
                <!-- Event Status Badge -->
                <div class="absolute top-4 left-4">
                    <?php if (strtotime($event['event_date']) > time()): ?>
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            Yaqinlashayotgan
                        </span>
                    <?php else: ?>
                        <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            O'tgan
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="p-8">
                <!-- Event Header -->
                <header class="mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </h1>
                    
                    <!-- Event Meta Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-3 text-blue-600"></i>
                                <span><?php echo formatDate($event['event_date'], 'd.m.Y H:i'); ?></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-3 text-red-600"></i>
                                <span><?php echo htmlspecialchars($event['location']); ?></span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user mr-3 text-green-600"></i>
                                <span>Tashkilotchi: <?php echo htmlspecialchars($event['first_name'] . ' ' . $event['last_name']); ?></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users mr-3 text-purple-600"></i>
                                <span><?php echo $event['registered_count']; ?>/<?php echo $event['capacity'] ?: '∞'; ?> ishtirokchi</span>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Registration Section -->
                <?php if (strtotime($event['event_date']) > time()): ?>
                <div class="bg-blue-50 p-6 rounded-lg mb-6">
                    <?php if (isLoggedIn()): ?>
                        <?php if ($is_registered): ?>
                            <div class="text-center">
                                <i class="fas fa-check-circle text-green-600 text-3xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-green-800 mb-2">Siz ro'yxatdan o'tgansiz!</h3>
                                <p class="text-green-700">Tadbir sanasi yaqinlashganda sizga eslatma yuboriladi.</p>
                            </div>
                        <?php elseif ($event['registered_count'] >= $event['capacity'] && $event['capacity'] > 0): ?>
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Joylar tugadi</h3>
                                <p class="text-yellow-700">Afsuski, bu tadbirga ro'yxatdan o'tish tugagan.</p>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-blue-800 mb-4">Tadbirga ro'yxatdan o'ting</h3>
                                <form method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                    <button type="submit" name="register" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                                        <i class="fas fa-user-plus mr-2"></i>Ro'yxatdan o'tish
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Tadbirga ro'yxatdan o'tish uchun</h3>
                            <a href="login.php" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300 inline-block">
                                <i class="fas fa-sign-in-alt mr-2"></i>Tizimga kiring
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Event Description -->
                <?php if ($event['description']): ?>
                <div class="prose prose-lg max-w-none mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Tadbir haqida</h2>
                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                </div>
                <?php endif; ?>

                <!-- Event Details -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Tadbir tafsilotlari</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Sana va vaqt</h4>
                            <p class="text-gray-600"><?php echo formatDate($event['event_date'], 'd.m.Y, H:i'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Joy</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($event['location']); ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Sig'im</h4>
                            <p class="text-gray-600"><?php echo $event['capacity'] ? $event['capacity'] . ' kishi' : 'Cheklanmagan'; ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Tashkilotchi</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($event['first_name'] . ' ' . $event['last_name']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Share Buttons -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold mb-4">Ulashish:</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-facebook-f mr-2"></i>Facebook
                        </a>
                        <a href="#" class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition duration-300">
                            <i class="fab fa-twitter mr-2"></i>Twitter
                        </a>
                        <a href="#" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition duration-300">
                            <i class="fab fa-telegram mr-2"></i>Telegram
                        </a>
                        <button onclick="copyToClipboard()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                            <i class="fas fa-link mr-2"></i>Havolani nusxalash
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Events -->
        <?php if (!empty($related_events)): ?>
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Boshqa tadbirlar</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($related_events as $item): ?>
                    <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $item['image'] ? 'uploads/events/' . $item['image'] : 'images/default-event.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 left-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo formatDate($item['event_date'], 'd.m'); ?>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3 line-clamp-2">
                                <a href="event-detail.php?id=<?php echo $item['id']; ?>" class="hover:text-blue-600 transition duration-300">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </a>
                            </h3>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo formatDate($item['event_date'], 'd.m.Y H:i'); ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <?php echo htmlspecialchars($item['location']); ?>
                                </div>
                            </div>
                            <a href="event-detail.php?id=<?php echo $item['id']; ?>" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Batafsil
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Back to Events -->
        <div class="mt-8 text-center">
            <a href="events.php" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Barcha tadbirlarga qaytish
            </a>
        </div>
    </div>
</main>

<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        showNotification('Havola nusxalandi!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showNotification('Havolani nusxalashda xatolik!', 'error');
    });
}
</script>

<?php require_once 'includes/footer.php'; ?>