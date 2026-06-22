<?php
/**
 * Apex Air Backend Configuration
 * Database and session configuration
 */

// Enable error reporting (change in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);
}

// Create data directory if it doesn't exist
if (!file_exists(__DIR__ . '/../data')) {
    mkdir(__DIR__ . '/../data', 0755, true);
}

// Session configuration
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS
ini_set('session.cookie_samesite', 'Lax');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Database file paths (using JSON files for simplicity)
define('PILOTS_DB', __DIR__ . '/../data/pilots.json');
define('APPLICATIONS_DB', __DIR__ . '/../data/applications.json');
define('ADMIN_PASSWORD_FILE', __DIR__ . '/../data/admin.json');

// Initialize database files
function initDatabases() {
    // Create pilots database
if (!file_exists(PILOTS_DB)) {
    file_put_contents(PILOTS_DB, json_encode([]));
}
    
    // Create applications database
if (!file_exists(APPLICATIONS_DB)) {
    file_put_contents(APPLICATIONS_DB, json_encode([]));
}
    
    // Create admin credentials (default: admin/admin - CHANGE THIS!)
    if (!file_exists(ADMIN_PASSWORD_FILE)) {
        $admin = [
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT)
        ];
        file_put_contents(ADMIN_PASSWORD_FILE, json_encode($admin));
    }
}

// Read JSON database
function readDatabase($filepath) {
    if (!file_exists($filepath)) {
        return [];
    }
    $content = file_get_contents($filepath);
    return json_decode($content, true) ?: [];
}

// Write JSON database
function writeDatabase($filepath, $data) {
    return file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate password strength
function validatePassword($password) {
    return strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[0-9]/', $password);
}

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Generate response
function response($success, $message, $data = null) {
    header('Content-Type: application/json');
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['pilot_id']) && !empty($_SESSION['pilot_id']);
}

// Get current pilot
function getCurrentPilot() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $pilots = readDatabase(PILOTS_DB);
    foreach ($pilots as $pilot) {
        if ($pilot['id'] == $_SESSION['pilot_id']) {
            return $pilot;
        }
    }
    
    return null;
}

// Generate unique ID
function generateId() {
    return uniqid('pilot_', true);
}

// Initialize databases on load
initDatabases();
?>
