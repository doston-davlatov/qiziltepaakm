<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

$query = $_GET['q'] ?? '';
$suggestions = [];

if (strlen($query) >= 2) {
    $search_param = "%{$query}%";
    
    // Search books
    $stmt = $pdo->prepare("SELECT DISTINCT title as name, 'book' as type FROM books 
                           WHERE title LIKE ? AND is_available = 1 LIMIT 5");
    $stmt->execute([$search_param]);
    $book_suggestions = $stmt->fetchAll();
    
    // Search authors
    $stmt = $pdo->prepare("SELECT DISTINCT name, 'author' as type FROM authors 
                           WHERE name LIKE ? LIMIT 3");
    $stmt->execute([$search_param]);
    $author_suggestions = $stmt->fetchAll();
    
    $suggestions = array_merge($book_suggestions, $author_suggestions);
}

echo json_encode($suggestions);
?>