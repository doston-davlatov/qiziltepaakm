<?php
require_once 'header.php';

// Check if user is admin
if (!isAdmin()) {
    redirect('../login.php');
}

$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $csrf_token = $_POST['csrf_token'];
    
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        // Handle adding new author from book form
        if (isset($_POST['add_author'])) {
            $author_name = sanitizeInput($_POST['new_author_name']);
            $author_biography = sanitizeInput($_POST['new_author_biography']);
            
            if (empty($author_name)) {
                $error = 'Muallif nomi majburiy.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO authors (name, biography, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$author_name, $author_biography]);
                $success = 'Muallif muvaffaqiyatli qo\'shildi.';
                logActivity('Author added: ' . $author_name);
            }
        }
        // Handle adding new genre from book form
        elseif (isset($_POST['add_genre'])) {
            $genre_name = sanitizeInput($_POST['new_genre_name']);
            $genre_description = sanitizeInput($_POST['new_genre_description']);
            
            if (empty($genre_name)) {
                $error = 'Janr nomi majburiy.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO genres (name, description, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$genre_name, $genre_description]);
                $success = 'Janr muvaffaqiyatli qo\'shildi.';
                logActivity('Genre added: ' . $genre_name);
            }
        }
        // Handle adding new publisher from book form
        elseif (isset($_POST['add_publisher'])) {
            $publisher_name = sanitizeInput($_POST['new_publisher_name']);
            $publisher_address = sanitizeInput($_POST['new_publisher_address']);
            
            if (empty($publisher_name)) {
                $error = 'Nashriyot nomi majburiy.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO publishers (name, address, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$publisher_name, $publisher_address]);
                $success = 'Nashriyot muvaffaqiyatli qo\'shildi.';
                logActivity('Publisher added: ' . $publisher_name);
            }
        }
        // Handle book operations
        elseif ($action === 'add' || $action === 'edit') {
            $title = sanitizeInput($_POST['title']);
            $author_id = $_POST['author_id'];
            $genre_id = $_POST['genre_id'];
            $publisher_id = $_POST['publisher_id'];
            $isbn = sanitizeInput($_POST['isbn']);
            $publication_year = $_POST['publication_year'];
            $pages = $_POST['pages'];
            $language = $_POST['language'];
            $description = sanitizeInput($_POST['description']);
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_available = isset($_POST['is_available']) ? 1 : 0;
            
            // Handle cover image upload
            $cover_image = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = uploadFile($_FILES['cover_image'], '../uploads/books/');
                if (!$cover_image) {
                    $error = 'Rasm yuklashda xatolik.';
                }
            }
            
            // Handle PDF file upload
            $file_pdf = null;
            if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === UPLOAD_ERR_OK) {
                $file_pdf = uploadFile($_FILES['file_pdf'], '../uploads/books/pdf/', ['pdf']);
                if (!$file_pdf) {
                    $error = 'PDF fayl yuklashda xatolik.';
                }
            }
            
            if (!$error) {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO books (title, author_id, genre_id, publisher_id, isbn, publication_year, pages, language, description, cover_image, file_pdf, is_featured, is_available, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$title, $author_id, $genre_id, $publisher_id, $isbn, $publication_year, $pages, $language, $description, $cover_image, $file_pdf, $is_featured, $is_available]);
                    $success = 'Kitob muvaffaqiyatli qo\'shildi.';
                    logActivity('Book added: ' . $title);
                } else {
                    $book_id = $_POST['book_id'];
                    $update_query = "UPDATE books SET title=?, author_id=?, genre_id=?, publisher_id=?, isbn=?, publication_year=?, pages=?, language=?, description=?, is_featured=?, is_available=?, updated_at=NOW()";
                    $params = [$title, $author_id, $genre_id, $publisher_id, $isbn, $publication_year, $pages, $language, $description, $is_featured, $is_available];
                    
                    if ($cover_image) {
                        $update_query .= ", cover_image=?";
                        $params[] = $cover_image;
                    }
                    
                    if ($file_pdf) {
                        $update_query .= ", file_pdf=?";
                        $params[] = $file_pdf;
                    }
                    
                    $update_query .= " WHERE id=?";
                    $params[] = $book_id;
                    
                    $stmt = $pdo->prepare($update_query);
                    $stmt->execute($params);
                    $success = 'Kitob muvaffaqiyatli yangilandi.';
                    logActivity('Book updated: ' . $title);
                }
            }
        } elseif ($action === 'delete') {
            $book_id = $_POST['book_id'];
            $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
            $stmt->execute([$book_id]);
            $success = 'Kitob o\'chirildi.';
            logActivity('Book deleted', null, "Book ID: $book_id");
        }
    }
}

// Get books with pagination
$page = max(1, $_GET['page'] ?? 1);
$per_page = 10;
$offset = ($page - 1) * $per_page;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM books");
$stmt->execute();
$total_books = $stmt->fetchColumn();
$total_pages = ceil($total_books / $per_page);

$stmt = $pdo->prepare("SELECT b.*, a.name as author_name, g.name as genre_name, p.name as publisher_name
                       FROM books b 
                       JOIN authors a ON b.author_id = a.id 
                       LEFT JOIN genres g ON b.genre_id = g.id 
                       LEFT JOIN publishers p ON b.publisher_id = p.id
                       ORDER BY b.created_at DESC 
                       LIMIT ? OFFSET ?");
$stmt->execute([$per_page, $offset]);
$books = $stmt->fetchAll();

// Get authors, genres and publishers for form
$stmt = $pdo->prepare("SELECT * FROM authors ORDER BY name");
$stmt->execute();
$authors = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM genres ORDER BY name");
$stmt->execute();
$genres = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM publishers ORDER BY name");
$stmt->execute();
$publishers = $stmt->fetchAll();

// Get book for editing
$edit_book = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_book = $stmt->fetch();
}
?>

<main class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kitoblar boshqaruvi</h1>
            <p class="text-gray-600">Kitoblarni qo'shish, tahrirlash va o'chirish</p>
        </div>

        <!-- Messages -->
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-triangle mr-2"></i><?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i><?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Book Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <?php echo $edit_book ? 'Kitobni tahrirlash' : 'Yangi kitob qo\'shish'; ?>
            </h2>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                <input type="hidden" name="action" value="<?php echo $edit_book ? 'edit' : 'add'; ?>">
                <?php if ($edit_book): ?>
                    <input type="hidden" name="book_id" value="<?php echo $edit_book['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kitob nomi *</label>
                        <input type="text" 
                               name="title" 
                               value="<?php echo $edit_book ? htmlspecialchars($edit_book['title']) : ''; ?>" 
                               required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Muallif *</label>
                        <div class="flex gap-2">
                            <select name="author_id" required class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Muallifni tanlang</option>
                                <?php foreach ($authors as $author): ?>
                                    <option value="<?php echo $author['id']; ?>" 
                                            <?php echo ($edit_book && $edit_book['author_id'] == $author['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($author['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" onclick="toggleAddForm('author')" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <!-- Add Author Form (Hidden by default) -->
                        <div id="add-author-form" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <h3 class="text-sm font-medium mb-2">Yangi muallif qo'shish</h3>
                            <input type="text" name="new_author_name" placeholder="Muallif nomi" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2">
                            <textarea name="new_author_biography" placeholder="Muallif haqida" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2"></textarea>
                            <div class="flex justify-end">
                                <button type="button" onclick="toggleAddForm('author')" class="mr-2 px-3 py-1 bg-gray-500 text-white rounded-md">Bekor qilish</button>
                                <button type="submit" name="add_author" class="px-3 py-1 bg-blue-600 text-white rounded-md">Qo'shish</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Janr</label>
                        <div class="flex gap-2">
                            <select name="genre_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Janrni tanlang</option>
                                <?php foreach ($genres as $genre): ?>
                                    <option value="<?php echo $genre['id']; ?>" 
                                            <?php echo ($edit_book && $edit_book['genre_id'] == $genre['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($genre['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" onclick="toggleAddForm('genre')" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <!-- Add Genre Form (Hidden by default) -->
                        <div id="add-genre-form" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <h3 class="text-sm font-medium mb-2">Yangi janr qo'shish</h3>
                            <input type="text" name="new_genre_name" placeholder="Janr nomi" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2">
                            <textarea name="new_genre_description" placeholder="Janr haqida" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2"></textarea>
                            <div class="flex justify-end">
                                <button type="button" onclick="toggleAddForm('genre')" class="mr-2 px-3 py-1 bg-gray-500 text-white rounded-md">Bekor qilish</button>
                                <button type="submit" name="add_genre" class="px-3 py-1 bg-blue-600 text-white rounded-md">Qo'shish</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nashriyot</label>
                        <div class="flex gap-2">
                            <select name="publisher_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Nashriyotni tanlang</option>
                                <?php foreach ($publishers as $publisher): ?>
                                    <option value="<?php echo $publisher['id']; ?>" 
                                            <?php echo ($edit_book && $edit_book['publisher_id'] == $publisher['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($publisher['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" onclick="toggleAddForm('publisher')" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <!-- Add Publisher Form (Hidden by default) -->
                        <div id="add-publisher-form" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <h3 class="text-sm font-medium mb-2">Yangi nashriyot qo'shish</h3>
                            <input type="text" name="new_publisher_name" placeholder="Nashriyot nomi" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2">
                            <textarea name="new_publisher_address" placeholder="Nashriyot manzili" class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2"></textarea>
                            <div class="flex justify-end">
                                <button type="button" onclick="toggleAddForm('publisher')" class="mr-2 px-3 py-1 bg-gray-500 text-white rounded-md">Bekor qilish</button>
                                <button type="submit" name="add_publisher" class="px-3 py-1 bg-blue-600 text-white rounded-md">Qo'shish</button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                        <input type="text" 
                               name="isbn" 
                               value="<?php echo $edit_book ? htmlspecialchars($edit_book['isbn']) : ''; ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nashr yili</label>
                        <input type="number" 
                               name="publication_year" 
                               value="<?php echo $edit_book ? $edit_book['publication_year'] : ''; ?>" 
                               min="1800" 
                               max="<?php echo date('Y'); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sahifalar soni</label>
                        <input type="number" 
                               name="pages" 
                               value="<?php echo $edit_book ? $edit_book['pages'] : ''; ?>" 
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Til</label>
                        <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="uz" <?php echo ($edit_book && $edit_book['language'] === 'uz') ? 'selected' : ''; ?>>O'zbekcha</option>
                            <option value="en" <?php echo ($edit_book && $edit_book['language'] === 'en') ? 'selected' : ''; ?>>English</option>
                            <option value="ru" <?php echo ($edit_book && $edit_book['language'] === 'ru') ? 'selected' : ''; ?>>Русский</option>
                            <option value="other" <?php echo ($edit_book && $edit_book['language'] === 'other') ? 'selected' : ''; ?>>Boshqa</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tavsif</label>
                    <textarea name="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $edit_book ? htmlspecialchars($edit_book['description']) : ''; ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Muqova rasmi</label>
                    <input type="file" 
                           name="cover_image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($edit_book && $edit_book['cover_image']): ?>
                        <p class="text-sm text-gray-500 mt-1">Hozirgi rasm: <?php echo htmlspecialchars($edit_book['cover_image']); ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PDF fayl</label>
                    <input type="file" 
                           name="file_pdf" 
                           accept=".pdf"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($edit_book && $edit_book['file_pdf']): ?>
                        <p class="text-sm text-gray-500 mt-1">
                            Hozirgi fayl: 
                            <a href="../uploads/books/pdf/<?php echo htmlspecialchars($edit_book['file_pdf']); ?>" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-800">
                                <?php echo htmlspecialchars($edit_book['file_pdf']); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1" 
                               <?php echo ($edit_book && $edit_book['is_featured']) ? 'checked' : ''; ?>
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Tavsiya etilgan</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_available" 
                               value="1" 
                               <?php echo ($edit_book && $edit_book['is_available']) || !$edit_book ? 'checked' : ''; ?>
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Mavjud</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4">
                    <?php if ($edit_book): ?>
                        <a href="books.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Bekor qilish
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <?php echo $edit_book ? 'Yangilash' : 'Qo\'shish'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Books List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Kitoblar ro'yxati</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kitob</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Muallif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Janr</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nashriyot</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-10">
                                            <img src="<?php echo $book['cover_image'] ? '../uploads/books/' . $book['cover_image'] : '../images/default-book.jpg'; ?>" 
                                                 alt="<?php echo htmlspecialchars($book['title']); ?>" 
                                                 class="h-12 w-10 object-cover rounded">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($book['title']); ?></div>
                                            <div class="text-sm text-gray-500">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($book['author_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($book['genre_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($book['publisher_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <?php if ($book['is_available']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Mavjud
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Mavjud emas
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($book['is_featured']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Tavsiya
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="?edit=<?php echo $book['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                        Tahrirlash
                                    </a>
                                    <form method="POST" class="inline" onsubmit="return confirm('Rostdan ham o\'chirishni xohlaysizmi?')">
                                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            O'chirish
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="mt-6 flex justify-center">
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

<script>
function toggleAddForm(type) {
    const form = document.getElementById(`add-${type}-form`);
    form.classList.toggle('hidden');
}
</script>

<?php require_once 'footer.php'; ?>