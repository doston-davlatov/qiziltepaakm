<?php
require_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $rating = (int)$_POST['rating'];
    $review = sanitizeInput($_POST['review']);
    $csrf_token = $_POST['csrf_token'];
    
    // Verify CSRF token
    if (!verifyCsrfToken($csrf_token)) {
        $error = 'Xavfsizlik xatosi.';
    } else {
        // Validate inputs
        if (empty($book_id) || $rating < 1 || $rating > 5) {
            $error = 'Noto\'g\'ri ma\'lumotlar.';
        } else {
            // Check if book exists
            $stmt = $pdo->prepare("SELECT id FROM books WHERE id = ? AND is_available = 1");
            $stmt->execute([$book_id]);
            if (!$stmt->fetch()) {
                $error = 'Kitob topilmadi.';
            } else {
                // Check if user already reviewed this book
                $stmt = $pdo->prepare("SELECT id FROM reviews WHERE book_id = ? AND user_id = ?");
                $stmt->execute([$book_id, $_SESSION['user_id']]);
                if ($stmt->fetch()) {
                    $error = 'Siz bu kitobga allaqachon sharh qoldirgan ekansiz.';
                } else {
                    // Insert review
                    $stmt = $pdo->prepare("INSERT INTO reviews (book_id, user_id, rating, review, is_approved, created_at) VALUES (?, ?, ?, ?, 0, NOW())");
                    if ($stmt->execute([$book_id, $_SESSION['user_id'], $rating, $review])) {
                        $success = 'Sharhingiz muvaffaqiyatli yuborildi. Admin tasdiqlashidan keyin ko\'rsatiladi.';
                        logActivity('Review added', $_SESSION['user_id'], "Book ID: $book_id, Rating: $rating");
                    } else {
                        $error = 'Sharh qo\'shishda xatolik yuz berdi.';
                    }
                }
            }
        }
    }
}

// Redirect back to book detail page
if (isset($_POST['book_id'])) {
    $redirect_url = "book-detail.php?id=" . (int)$_POST['book_id'];
    if ($success) {
        $redirect_url .= "&success=" . urlencode($success);
    } elseif ($error) {
        $redirect_url .= "&error=" . urlencode($error);
    }
    redirect($redirect_url);
} else {
    redirect('catalog.php');
}
?>