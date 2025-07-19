<?php
require_once '../includes/header.php';

// Get search parameters
$query = $_GET['q'] ?? '';
$type = $_GET['type'] ?? 'all';
$page = max(1, $_GET['page'] ?? 1);
$per_page = 10;

$results = [];
$total_results = 0;

if (!empty($query)) {
    $search_param = "%{$query}%";
    
    // Search in different content types
    if ($type === 'all' || $type === 'books') {
        // Search books
        $stmt = $pdo->prepare("SELECT 'book' as type, b.id, b.title as name, b.description, 
                               a.name as author_name, b.cover_image as image, b.created_at
                               FROM books b 
                               JOIN authors a ON b.author_id = a.id 
                               WHERE (b.title LIKE ? OR b.description LIKE ? OR a.name LIKE ?) 
                               AND b.is_available = 1");
        $stmt->execute([$search_param, $search_param, $search_param]);
        $book_results = $stmt->fetchAll();
        $results = array_merge($results, $book_results);
    }
    
    if ($type === 'all' || $type === 'news') {
        // Search news
        $stmt = $pdo->prepare("SELECT 'news' as type, n.id, n.title as name, n.content as description, 
                               CONCAT(u.first_name, ' ', u.last_name) as author_name, 
                               n.image, n.created_at
                               FROM news n 
                               JOIN users u ON n.author_id = u.id 
                               WHERE (n.title LIKE ? OR n.content LIKE ?) 
                               AND n.is_published = 1");
        $stmt->execute([$search_param, $search_param]);
        $news_results = $stmt->fetchAll();
        $results = array_merge($results, $news_results);
    }
    
    if ($type === 'all' || $type === 'events') {
        // Search events
        $stmt = $pdo->prepare("SELECT 'event' as type, e.id, e.title as name, e.description, 
                               CONCAT(u.first_name, ' ', u.last_name) as author_name, 
                               e.image, e.created_at
                               FROM events e 
                               JOIN users u ON e.organizer_id = u.id 
                               WHERE (e.title LIKE ? OR e.description LIKE ?) 
                               AND e.is_published = 1");
        $stmt->execute([$search_param, $search_param]);
        $event_results = $stmt->fetchAll();
        $results = array_merge($results, $event_results);
    }
    
    if ($type === 'all' || $type === 'authors') {
        // Search authors
        $stmt = $pdo->prepare("SELECT 'author' as type, a.id, a.name, a.biography as description, 
                               a.nationality as author_name, NULL as image, a.created_at
                               FROM authors a 
                               WHERE (a.name LIKE ? OR a.biography LIKE ?)");
        $stmt->execute([$search_param, $search_param]);
        $author_results = $stmt->fetchAll();
        $results = array_merge($results, $author_results);
    }
    
    $total_results = count($results);
    
    // Sort by relevance (created_at for now)
    usort($results, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    // Pagination
    $total_pages = ceil($total_results / $per_page);
    $offset = ($page - 1) * $per_page;
    $results = array_slice($results, $offset, $per_page);
}
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Qidiruv natijalari</h1>
            <?php if (!empty($query)): ?>
                <p class="text-gray-600">
                    "<strong><?php echo htmlspecialchars($query); ?></strong>" uchun 
                    <?php echo $total_results; ?> ta natija topildi
                </p>
            <?php endif; ?>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="q" 
                               value="<?php echo htmlspecialchars($query); ?>" 
                               placeholder="Qidiruv so'zini kiriting..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <select name="type" class="px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all" <?php echo $type === 'all' ? 'selected' : ''; ?>>Barchasi</option>
                            <option value="books" <?php echo $type === 'books' ? 'selected' : ''; ?>>Kitoblar</option>
                            <option value="news" <?php echo $type === 'news' ? 'selected' : ''; ?>>Yangiliklar</option>
                            <option value="events" <?php echo $type === 'events' ? 'selected' : ''; ?>>Tadbirlar</option>
                            <option value="authors" <?php echo $type === 'authors' ? 'selected' : ''; ?>>Mualliflar</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search mr-2"></i>Qidirish
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <?php if (empty($query)): ?>
            <div class="text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Qidiruv so'zini kiriting</h3>
                <p class="text-gray-500">Kitoblar, yangiliklar, tadbirlar va mualliflar orasidan qidiring</p>
            </div>
        <?php elseif (empty($results)): ?>
            <div class="text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Hech narsa topilmadi</h3>
                <p class="text-gray-500">Boshqa so'zlar bilan qidirib ko'ring</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($results as $result): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                        <div class="flex items-start space-x-4">
                            <!-- Image -->
                            <div class="flex-shrink-0">
                                <?php if ($result['image']): ?>
                                    <img src="../uploads/<?php echo $result['type'] === 'book' ? 'books' : $result['type'].'s'; ?>/<?php echo $result['image']; ?>" 
                                         alt="<?php echo htmlspecialchars($result['name']); ?>" 
                                         class="w-20 h-24 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-20 h-24 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-<?php echo $result['type'] === 'book' ? 'book' : ($result['type'] === 'news' ? 'newspaper' : ($result['type'] === 'event' ? 'calendar' : 'user')); ?> text-gray-400 text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <!-- Type Badge -->
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php 
                                        switch($result['type']) {
                                            case 'book': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'news': echo 'bg-green-100 text-green-800'; break;
                                            case 'event': echo 'bg-purple-100 text-purple-800'; break;
                                            case 'author': echo 'bg-yellow-100 text-yellow-800'; break;
                                        }
                                        ?>">
                                        <?php 
                                        switch($result['type']) {
                                            case 'book': echo 'Kitob'; break;
                                            case 'news': echo 'Yangilik'; break;
                                            case 'event': echo 'Tadbir'; break;
                                            case 'author': echo 'Muallif'; break;
                                        }
                                        ?>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    <a href="<?php 
                                        switch($result['type']) {
                                            case 'book': echo 'book-detail.php?id=' . $result['id']; break;
                                            case 'news': echo 'news-detail.php?id=' . $result['id']; break;
                                            case 'event': echo 'event-detail.php?id=' . $result['id']; break;
                                            case 'author': echo 'catalog.php?author_id=' . $result['id']; break;
                                        }
                                        ?>" 
                                       class="hover:text-blue-600 transition duration-300">
                                        <?php echo htmlspecialchars($result['name']); ?>
                                    </a>
                                </h3>

                                <!-- Author/Meta -->
                                <?php if ($result['author_name']): ?>
                                    <p class="text-gray-600 text-sm mb-2">
                                        <?php echo htmlspecialchars($result['author_name']); ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Description -->
                                <?php if ($result['description']): ?>
                                    <p class="text-gray-700 mb-3">
                                        <?php echo htmlspecialchars(substr(strip_tags($result['description']), 0, 200)) . '...'; ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Date -->
                                <p class="text-gray-500 text-sm">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <?php echo formatDate($result['created_at'], 'd.m.Y'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" 
                               class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="fas fa-chevron-left mr-1"></i>Oldingi
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                               class="px-3 py-2 text-sm <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> border border-gray-300 rounded-md">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" 
                               class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Keyingi<i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>