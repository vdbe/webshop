<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/userrole.php';


$db = new DB();
$roles = UserRole::getRoles($db);

foreach ($roles as &$role) {
    foreach ($role as $key => &$value) {
        if (gettype($value) == "string") {
            $role[$key] = htmlspecialchars($value);
        }
    }
}

echo json_encode($roles);
