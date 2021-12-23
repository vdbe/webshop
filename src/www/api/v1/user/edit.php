<?php
$NEEDS_TO_BE_LOGGED_IN = 1;
$ADMIN_ONLY = 1;

require_once __DIR__ . '/../../../include/php_header.php';

header('Content-Type: application/json; charset=utf-8');

$response = array('status' => 'success');

$json = file_get_contents('php://input');

if (empty($json)) {
    http_response_code(401);
    exit();
}

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/user.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$data = json_decode($json);

if (User::change($db, $data->id, $data->displayname, $data->role, $data->active)) {
    echo json_encode($response);
} else {
    $response['status'] = "failed";
    echo json_encode($response);
}
