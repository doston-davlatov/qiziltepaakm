<?php
session_start();
require_once 'translations.php';

// Generate CSRF token
function generateCsrfToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Sanitize input
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Validate email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hash password
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Redirect function
function redirect($location)
{
    header("Location: $location");
    exit();
}

// Get current language
function getCurrentLanguage()
{
    return $_SESSION['language'] ?? DEFAULT_LANGUAGE;
}

// Set language
function setLanguage($lang)
{
    if (in_array($lang, AVAILABLE_LANGUAGES)) {
        $_SESSION['language'] = $lang;
    }
}

// Translation function
function translate($key, $lang = null)
{
    if ($lang === null) {
        $lang = getCurrentLanguage();
    }







    $translations = getTranslations();

    return $translations[$lang][$key] ?? $key;
}

// Upload file function
function uploadFile($file, $directory, $allowedTypes = null)
{
    if ($allowedTypes === null) {
        $allowedTypes = ALLOWED_IMAGE_TYPES;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check file size
    if ($fileSize > MAX_FILE_SIZE) {
        return false;
    }

    // Check file type
    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    // Generate unique filename
    $newFileName = uniqid() . '.' . $fileType;
    $destination = $directory . $newFileName;

    // Create directory if it doesn't exist
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($fileTmpName, $destination)) {
        return $newFileName;
    }

    return false;
}

// Pagination function
function paginate($currentPage, $totalItems, $itemsPerPage = 10)
{
    $totalPages = ceil($totalItems / $itemsPerPage);
    $offset = ($currentPage - 1) * $itemsPerPage;

    return [
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'items_per_page' => $itemsPerPage,
        'offset' => $offset,
        'total_items' => $totalItems
    ];
}

// Format date
function formatDate($date, $format = 'Y-m-d H:i:s')
{
    return date($format, strtotime($date));
}

// Get user IP
function getUserIP()
{
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

function uploadsFile($file, $target_dir, $allowed_types = ['jpg', 'jpeg', 'png', 'gif'])
{
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    }

    // Check file size (5MB max)
    if ($file["size"] > 5000000) {
        return false;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, $allowed_types)) {
        return false;
    }

    // Try to upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false;
    }
}

// Log activity
function logActivity($action, $userId = null, $details = null)
{
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO activity_log (user_id, action, details, ip_address, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $userId ?? ($_SESSION['user_id'] ?? null),
        $action,
        $details,
        getUserIP()
    ]);
}
?>