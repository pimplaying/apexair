<?php
/**
 * Apex Air Pilot Registration
 */

require_once 'config.php';

header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}

// Get input
$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$vatsim = sanitize($_POST['vatsim'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters';
}

if (!validateEmail($email)) {
    $errors[] = 'Invalid email address';
}

if (empty($vatsim) || !is_numeric($vatsim)) {
    $errors[] = 'Invalid VATSIM ID';
}

if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match';
}

if (!validatePassword($password)) {
    $errors[] = 'Password must be at least 8 characters with uppercase and numbers';
}

if (!empty($errors)) {
    die(json_encode([
        'success' => false,
        'message' => implode(', ', $errors)
    ]));
}

// Check if email already exists
$pilots = readDatabase(PILOTS_DB);
foreach ($pilots as $pilot) {
    if ($pilot['email'] === $email) {
        die(json_encode([
            'success' => false,
            'message' => 'Email already registered'
        ]));
    }
    if ($pilot['vatsim'] === $vatsim) {
        die(json_encode([
            'success' => false,
            'message' => 'VATSIM ID already registered'
        ]));
    }
}

// Create new pilot
$new_pilot = [
    'id' => generateId(),
    'name' => $name,
    'email' => $email,
    'vatsim' => $vatsim,
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'status' => 'registered', // Can be: registered, pending, approved, rejected
    'created_at' => date('Y-m-d H:i:s'),
    'flight_hours' => 0,
    'flights' => 0
];

$pilots[] = $new_pilot;
writeDatabase(PILOTS_DB, $pilots);

// Log in automatically
$_SESSION['pilot_id'] = $new_pilot['id'];

// Return success with pilot data (without password)
unset($new_pilot['password']);
die(json_encode([
    'success' => true,
    'message' => 'Account created successfully!',
    'data' => $new_pilot
]));
?>
