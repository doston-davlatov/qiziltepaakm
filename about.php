<?php
require_once 'includes/header.php';

// Get library statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM books WHERE is_available = 1");
$stmt->execute();
$total_books = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'user' AND is_active = 1");
$stmt->execute();
$total_users = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM events WHERE event_date >= NOW()");
$stmt->execute();
$upcoming_events = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM authors");
$stmt->execute();
$total_authors = $stmt->fetchColumn();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= translate('about') ?></h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo translate('library_name'); ?> <?= translate('about_1') ?>
            </p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_books); ?></h3>
                <p class="text-gray-600"><?= translate('books') ?></p>
            </div>

            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-green-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_users); ?></h3>
                <p class="text-gray-600"><?= translate('users') ?></p>
            </div>

            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($upcoming_events); ?></h3>
                <p class="text-gray-600"><?= translate('about_2') ?></p>
            </div>

            <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-pen text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_authors); ?></h3>
                <p class="text-gray-600"><?= translate('authors') ?></p>
            </div>
        </div>

        <!-- About Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?= translate('about_3') ?></h2>
                <div class="space-y-4 text-gray-700">
                    <p>
                        <?php echo translate('library_name') . translate('about_4'); ?>
                    </p>
                    <p><?= translate('about_5') ?></p>
                    <p><?= translate('about_6') ?></p>
                </div>
            </div>

            <div>
                <img src="./images/library_bg.jpg" alt="Kutubxona binosi"
                    class="w-full h-64 object-cover rounded-lg shadow-lg">
            </div>
        </div>

        <!-- Mission and Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-blue-50 p-8 rounded-lg">
                <h3 class="text-2xl font-bold text-blue-900 mb-4"><?= translate('about_7') ?></h3>
                <p class="text-blue-800"><?= translate('about_8') ?></p>
            </div>

            <div class="bg-green-50 p-8 rounded-lg">
                <h3 class="text-2xl font-bold text-green-900 mb-4"><?= translate('about_9') ?></h3>
                <p class="text-green-800"><?= translate('about_10') ?></p>
            </div>
        </div>

        <!-- Services -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('about_11') ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_12') ?></h3>
                    <p class="text-gray-600"><?= translate('about_13') ?></p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_14') ?></h3>
                    <p class="text-gray-600"><?= translate('about_15') ?></p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_16') ?></h3>
                    <p class="text-gray-600"><?= translate('about_17') ?></p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-check text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_18') ?></h3>
                    <p class="text-gray-600"><?= translate('about_19') ?></p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chalkboard-teacher text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_20') ?></h3>
                    <p class="text-gray-600"><?= translate('about_21') ?></p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-lg">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-copy text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3"><?= translate('about_22') ?></h3>
                    <p class="text-gray-600"><?= translate('about_23') ?></p>
                </div>
            </div>
        </div>

        <!-- Team Section (updated to use database) -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('about_24') ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM librarians WHERE is_active = 1 ORDER BY position");
                $stmt->execute();
                $librarians = $stmt->fetchAll();

                foreach ($librarians as $librarian):
                    ?>
                    <div class="text-center">
                        <?php if ($librarian['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($librarian['image_path']); ?>"
                                alt="<?php echo htmlspecialchars($librarian['full_name']); ?>"
                                class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                        <?php else: ?>
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500 text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($librarian['full_name']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($librarian['position']); ?></p>
                        <?php if ($librarian['department']): ?>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($librarian['department']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-gray-50 p-8 rounded-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center"><?= translate('about_25') ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2"><?= translate('about_26') ?></h3>
                    <p class="text-gray-600"><?= translate('about_27') ?></p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-green-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2"><?= translate('about_28') ?></h3>
                    <p class="text-gray-600">+998 79 123 45 67</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2"><?= translate('about_29') ?></h3>
                    <p class="text-gray-600">info@library.uz</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <h3 class="font-semibold mb-2"><?= translate('about_30') ?></h3>
                    <p class="text-gray-600"><?= translate('about_31') ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>