<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/user.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$users = User::getUsers($db);

foreach ($users as &$user) {
    foreach ($user as $key => &$value) {
        if (gettype($value) == "string") {
            $user[$key] = htmlspecialchars($value);
        }
    }
}

echo json_encode($users);
