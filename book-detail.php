<?php
require_once 'includes/header.php';

// Get book ID from URL
$book_id = $_GET['id'] ?? 0;

if (!$book_id) {
    redirect('catalog.php');
}

// Get book details
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name, a.biography as author_biography, 
                       g.name as genre_name, p.name as publisher_name 
                       FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       LEFT JOIN genres g ON b.genre_id = g.id 
                       LEFT JOIN publishers p ON b.publisher_id = p.id 
                       WHERE b.id = ? AND b.is_available = 1");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    redirect('catalog.php');
}

// Get book reviews
$stmt = $pdo->prepare("SELECT r.*, u.first_name, u.last_name 
                       FROM reviews r 
                       JOIN users u ON r.user_id = u.id 
                       WHERE r.book_id = ? AND r.is_approved = 1 
                       ORDER BY r.created_at DESC");
$stmt->execute([$book_id]);
$reviews = $stmt->fetchAll();

// Get related books (same author or genre)
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name 
                       FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       WHERE (b.author_id = ? OR b.genre_id = ?) 
                       AND b.id != ? AND b.is_available = 1 
                       ORDER BY b.is_featured DESC, b.created_at DESC 
                       LIMIT 6");
$stmt->execute([$book['author_id'], $book['genre_id'], $book_id]);
$related_books = $stmt->fetchAll();

// Calculate average rating
$average_rating = 0;
if (!empty($reviews)) {
    $total_rating = array_sum(array_column($reviews, 'rating'));
    $average_rating = round($total_rating / count($reviews), 1);
}
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="index.php" class="hover:text-blue-600">Bosh sahifa</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="catalog.php" class="hover:text-blue-600">Katalog</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-900"><?php echo htmlspecialchars($book['title']); ?></li>
            </ol>
        </nav>

        <!-- Book Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Book Cover -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <img src="<?php echo $book['cover_image'] ? 'uploads/books/' . $book['cover_image'] : 'images/default-book.jpg'; ?>" 
                         alt="<?php echo htmlspecialchars($book['title']); ?>" 
                         class="w-full max-w-sm mx-auto rounded-lg shadow-lg">
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <?php if (isLoggedIn()): ?>
                            <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-bookmark mr-2"></i>Bron qilish
                            </button>
                            <button class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                                <i class="fas fa-heart mr-2"></i>Sevimlilar
                            </button>
                        <?php else: ?>
                            <a href="login.php" class="block w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 text-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Bron qilish uchun kiring
                            </a>
                        <?php endif; ?>
                        
                        <button class="w-full bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 transition duration-300">
                            <i class="fas fa-share-alt mr-2"></i>Ulashish
                        </button>
                    </div>
                </div>
            </div>

            <!-- Book Information -->
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <!-- Title and Rating -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($book['title']); ?></h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo $i <= $average_rating ? 'text-yellow-400' : 'text-gray-300'; ?>"></i>
                                <?php endfor; ?>
                                <span class="ml-2 text-gray-600"><?php echo $average_rating; ?> (<?php echo count($reviews); ?> sharh)</span>
                            </div>
                            <?php if ($book['is_featured']): ?>
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-star mr-1"></i>Tavsiya etilgan
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Muallif:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($book['author_name']); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Janr:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($book['genre_name']); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Nashriyot:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($book['publisher_name']); ?></span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Nashr yili:</span>
                                <span class="text-gray-900"><?php echo $book['publication_year']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Sahifalar:</span>
                                <span class="text-gray-900"><?php echo $book['pages']; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">ISBN:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($book['isbn']); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <?php if ($book['description']): ?>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Tavsif</h3>
                        <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Author Bio -->
                    <?php if ($book['author_biography']): ?>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Muallif haqida</h3>
                        <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($book['author_biography'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Sharhlar va baholar</h2>
            
            <?php if (isLoggedIn()): ?>
                <!-- Add Review Form -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h3 class="text-lg font-semibold mb-4">Sharh qoldiring</h3>
                    <form method="POST" action="add-review.php">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Baho</label>
                            <div class="flex space-x-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" class="rating-star text-2xl text-gray-300 hover:text-yellow-400" data-rating="<?php echo $i; ?>">
                                        <i class="fas fa-star"></i>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="rating" id="rating-input" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sharh</label>
                            <textarea name="review" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kitob haqidagi fikringizni yozing..."></textarea>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Sharh qoldirish
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Reviews List -->
            <?php if (!empty($reviews)): ?>
                <div class="space-y-6">
                    <?php foreach ($reviews as $review): ?>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">
                                            <?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?>
                                        </h4>
                                        <div class="flex items-center">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?> text-sm"></i>
                                            <?php endfor; ?>
                                            <span class="ml-2 text-sm text-gray-500"><?php echo formatDate($review['created_at'], 'd.m.Y'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($review['review']): ?>
                                <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Hali sharhlar yo'q. Birinchi bo'lib sharh qoldiring!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Related Books -->
        <?php if (!empty($related_books)): ?>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">O'xshash kitoblar</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php foreach ($related_books as $related_book): ?>
                    <div class="card-hover bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="<?php echo $related_book['cover_image'] ? 'uploads/books/' . $related_book['cover_image'] : 'images/default-book.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($related_book['title']); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-sm mb-2 line-clamp-2"><?php echo htmlspecialchars($related_book['title']); ?></h3>
                            <p class="text-gray-600 text-xs mb-3"><?php echo htmlspecialchars($related_book['author_name']); ?></p>
                            <a href="book-detail.php?id=<?php echo $related_book['id']; ?>" 
                               class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                Batafsil
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
// Rating stars functionality
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating-input');
    
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            
            // Update star colors
            ratingStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            
            ratingStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                }
            });
        });
    });
    
    // Reset on mouse leave
    document.querySelector('.rating-star').parentNode.addEventListener('mouseleave', function() {
        const currentRating = ratingInput.value;
        
        ratingStars.forEach((s, index) => {
            if (index < currentRating) {
                s.classList.add('text-yellow-400');
                s.classList.remove('text-gray-300');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>