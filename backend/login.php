<?php
/**
 * Apex Air Pilot Login
 */

require_once 'config.php';

header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}

// Get input
$username = sanitize($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validation
if (empty($username) || empty($password)) {
    die(json_encode([
        'success' => false,
        'message' => 'Username and password required'
    ]));
}

// Find pilot
$pilots = readDatabase(PILOTS_DB);
$pilot = null;

foreach ($pilots as $p) {
    if (($p['email'] === $username || $p['name'] === $username) && password_verify($password, $p['password'])) {
        $pilot = $p;
        break;
    }
}

if (!$pilot) {
    die(json_encode([
        'success' => false,
        'message' => 'Invalid username or password'
    ]));
}

// Log in
$_SESSION['pilot_id'] = $pilot['id'];

// Return success with pilot data (without password)
unset($pilot['password']);
die(json_encode([
    'success' => true,
    'message' => 'Login successful!',
    'data' => $pilot
]));
?>
