<?php
$needs_to_be_logged_in = 1;
$admin_only = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

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
$unitprice = (float)$data->unitprice;

if ($data->available == true) {
    //$date = date('Y-m-d');
    $date = new DateTime('1970-01-01');
} else {
    $date = new DateTime('2999-01-01');
}

if (empty($data->id)) {
    $productid = Product::add($db, $data->name, $data->description, $data->categories, $date, $stock, $unitprice);
    $response['productid'] = $productid;
} else {
    $productid = $data->id;
    $product = new Product($productid, $data->name, $data->description, $data->categories, $date, $stock, $unitprice);
    $product->update($db);
}



echo json_encode($response);
