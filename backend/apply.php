<?php
/**
 * Apex Air Pilot Application Handler
 */

require_once 'config.php';

header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}

// Check if logged in
if (!isLoggedIn()) {
    die(json_encode([
        'success' => false,
        'message' => 'Not logged in'
    ]));
}

// Get input
$flight_hours = intval($_POST['flight_hours'] ?? 0);
$rating = sanitize($_POST['rating'] ?? '');
$availability = sanitize($_POST['availability'] ?? '');
$additional_info = sanitize($_POST['additional_info'] ?? '');
$aircraft = $_POST['aircraft'] ?? [];
$agree_conduct = isset($_POST['agree_conduct']);
$agree_terms = isset($_POST['agree_terms']);

// Validation
$errors = [];

if ($flight_hours < 0) {
    $errors[] = 'Invalid flight hours';
}

if (empty($rating) || !in_array($rating, ['S1', 'S2', 'S3', 'C1', 'C3', 'I1'])) {
    $errors[] = 'Invalid VATSIM rating';
}

if (empty($availability) || !in_array($availability, ['weekdays', 'weekends', 'both'])) {
    $errors[] = 'Invalid availability';
}

if (!$agree_conduct || !$agree_terms) {
    $errors[] = 'You must agree to terms and conditions';
}

if (!empty($errors)) {
    die(json_encode([
        'success' => false,
        'message' => implode(', ', $errors)
    ]));
}

$pilot = getCurrentPilot();

// Create application
$new_application = [
    'id' => generateId(),
    'pilot_id' => $pilot['id'],
    'pilot_name' => $pilot['name'],
    'pilot_email' => $pilot['email'],
    'pilot_vatsim' => $pilot['vatsim'],
    'flight_hours' => $flight_hours,
    'rating' => $rating,
    'aircraft_preferences' => is_array($aircraft) ? $aircraft : [],
    'availability' => $availability,
    'additional_info' => $additional_info,
    'status' => 'pending', // Can be: pending, approved, rejected, needs_info
    'created_at' => date('Y-m-d H:i:s'),
    'reviewed_at' => null,
    'reviewed_by' => null,
    'notes' => ''
];

$applications = readDatabase(APPLICATIONS_DB);
$applications[] = $new_application;
writeDatabase(APPLICATIONS_DB, $applications);

// Update pilot status
$pilots = readDatabase(PILOTS_DB);
foreach ($pilots as &$p) {
    if ($p['id'] == $pilot['id']) {
        $p['status'] = 'pending';
        break;
    }
}
writeDatabase(PILOTS_DB, $pilots);

die(json_encode([
    'success' => true,
    'message' => 'Application submitted! We will review it shortly.',
    'data' => $new_application
]));
?>
