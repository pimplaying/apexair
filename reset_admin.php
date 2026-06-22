<?php
require_once 'backend/config.php';

$newPassword = 'AdminapexairappeltaartmetlekkerelimonadeKiloSchiphol12!'; // <-- verander dit naar jouw eigen wachtwoord

$data = [
    'username' => 'admin-p',
    'password' => password_hash($newPassword, PASSWORD_BCRYPT)
];
file_put_contents(ADMIN_PASSWORD_FILE, json_encode($data));
echo "Klaar! Wachtwoord is aangepast.";