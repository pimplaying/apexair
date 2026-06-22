<?php
/**
 * Get current session status
 */

require_once 'config.php';

header('Content-Type: application/json');

$pilot = getCurrentPilot();

if ($pilot) {
    unset($pilot['password']);
    die(json_encode([
        'logged_in' => true,
        'pilot' => $pilot
    ]));
} else {
    die(json_encode([
        'logged_in' => false,
        'pilot' => null
    ]));
}
?>
