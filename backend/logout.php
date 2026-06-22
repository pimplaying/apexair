<?php
/**
 * Apex Air Pilot Logout
 */

require_once 'config.php';

header('Content-Type: application/json');

// Destroy session
session_destroy();

die(json_encode([
    'success' => true,
    'message' => 'Logged out successfully'
]));
?>
