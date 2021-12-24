<?php

$NEEDS_TO_BE_LOGGED_IN = 1;


require_once __dir__ . '/../../../include/php_header.php';

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/userorder.php';

header('Content-Type: application/json; charset=utf-8');

$response = array('status' => 'success', 'stock' => -1);

$json = file_get_contents('php://input');

if (empty($json)) {
    http_response_code(401);
    exit();
}

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$data = json_decode($json);

$basket = UserOrder::basket($db, $USER);

$stock = $basket->addItem($db, $data->id, $data->amount);
if ($stock < 0) {
    $response['status'] = "failed";
    $response['stock'] = $stock;
    echo json_encode($response);
    die();
}

$response['stock'] = $stock;
echo json_encode($response);
