<?php
require_once 'includes/header.php';

// Get search parameters
$search = $_GET['search'] ?? '';
$genre_id = $_GET['genre_id'] ?? '';
$author_id = $_GET['author_id'] ?? '';
$page = max(1, $_GET['page'] ?? 1);
$per_page = 6; // Changed to 6 books per page

// Build query
$where_conditions = ['b.is_available = 1'];
$params = [];

if (!empty($search)) {
    $where_conditions[] = "(b.title LIKE ? OR b.description LIKE ? OR a.name LIKE ?)";
    $search_param = "%{$search}%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

if (!empty($genre_id)) {
    $where_conditions[] = "b.genre_id = ?";
    $params[] = $genre_id;
}

if (!empty($author_id)) {
    $where_conditions[] = "b.author_id = ?";
    $params[] = $author_id;
}

$where_clause = implode(' AND ', $where_conditions);

// Get total count
$count_query = "SELECT COUNT(*) FROM books b 
                JOIN authors a ON b.author_id = a.id 
                WHERE {$where_clause}";
$stmt = $pdo->prepare($count_query);
$stmt->execute($params);
$total_books = $stmt->fetchColumn();

// Calculate pagination
$total_pages = ceil($total_books / $per_page);
$offset = ($page - 1) * $per_page;

// Get books
$query = "SELECT b.*, a.name as author_name, g.name as genre_name, p.name as publisher_name 
          FROM books b 
          JOIN authors a ON b.author_id = a.id 
          LEFT JOIN genres g ON b.genre_id = g.id
          LEFT JOIN publishers p ON b.publisher_id = p.id 
          WHERE {$where_clause} 
          ORDER BY b.created_at DESC 
          LIMIT ? OFFSET ?";

$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll();

// Get genres for filter
$stmt = $pdo->prepare("SELECT * FROM genres ORDER BY name");
$stmt->execute();
$genres = $stmt->fetchAll();

// Get authors for filter
$stmt = $pdo->prepare("SELECT * FROM authors ORDER BY name");
$stmt->execute();
$authors = $stmt->fetchAll();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo translate('catalog'); ?></h1>
            <p class="text-gray-600">
                Kutubxona katalogida <?php echo number_format($total_books); ?> ta kitob mavjud
            </p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Qidiruv</label>
                        <input type="text" 
                               name="search" 
                               value="<?php echo htmlspecialchars($search); ?>" 
                               placeholder="Kitob nomi, muallif..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Genre Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Janr</label>
                        <select name="genre_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Barcha janrlar</option>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?php echo $genre['id']; ?>" 
                                        <?php echo $genre_id == $genre['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($genre['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Author Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Muallif</label>
                        <select name="author_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Barcha mualliflar</option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?php echo $author['id']; ?>" 
                                        <?php echo $author_id == $author['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($author['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-search mr-2"></i>Qidirish
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Books Grid -->
        <?php if (empty($books)): ?>
            <div class="text-center py-12">
                <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Kitoblar topilmadi</h3>
                <p class="text-gray-500">Qidiruv shartlarini o'zgartirib ko'ring</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                <?php foreach ($books as $book): ?>
                    <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $book['cover_image'] ? 'uploads/books/' . $book['cover_image'] : 'images/default-book.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($book['title']); ?>" 
                                 class="w-full h-64 object-cover">
                            <?php if ($book['is_featured']): ?>
                                <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star mr-1"></i>Tavsiya
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 line-clamp-2"><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars($book['author_name']); ?></p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span><?php echo htmlspecialchars($book['genre_name']); ?></span>
                                <span><?php echo htmlspecialchars($book['publication_year']); ?></span>
                            </div>
                            <?php if ($book['publisher_name']): ?>
                                <p class="text-xs text-gray-500 mb-2">
                                    <i class="fas fa-building mr-1"></i><?php echo htmlspecialchars($book['publisher_name']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($book['pages']): ?>
                                <p class="text-xs text-gray-500 mb-2">
                                    <i class="fas fa-file-alt mr-1"></i><?php echo $book['pages']; ?> sahifa
                                </p>
                            <?php endif; ?>
                            <div class="flex items-center justify-between">
                                <span class="text-green-600 text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Mavjud
                                </span>
                                <?php if ($book['file_pdf']): ?>
                                    <a href="uploads/books/pdf/<?php echo $book['file_pdf']; ?>" 
                                       target="_blank"
                                       class="text-red-600 hover:text-red-800 text-xs font-medium">
                                        <i class="fas fa-file-pdf mr-1"></i>PDF
                                    </a>
                                <?php endif; ?>
                                <a href="book-detail.php?id=<?php echo $book['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Batafsil
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="flex justify-center">
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

<?php require_once 'includes/footer.php'; ?>