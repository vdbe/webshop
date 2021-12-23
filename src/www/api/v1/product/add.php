<?php
$NEEDS_TO_BE_LOGGED_IN = 1;
$ADMIN_ONLY = 1;

require_once __DIR__ . '/../../../include/php_header.php';

//header('Content-Type: application/json; charset=utf-8');

$response = array('status' => 'success');

$json = file_get_contents('php://input');

if (empty($json)) {
    http_response_code(401);
    exit();
}

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/product.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$data = json_decode($json);

$stock = (int)$data->stock;
$unitprice = (float)$data->stock;

if ($data->available == true) {
    //$date = date('Y-m-d');
    $date = new DateTime('1970-01-01');
} else {
    $date = new DateTime('2999-01-01');
}


Product::add($db, $data->name, $data->description, $data->categories, $date, $stock, $unitprice);

echo json_encode($response);
