<?php

$needs_to_be_logged_in = 1;
$ADMIN_ONLY = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

$response = array('status' => 'success');

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/product.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$products = Product::search($db);

$products2 = [];

foreach ($products as $product) {
    $dateTime = $product->available;
    $date = $dateTime->format('Y-m-d H:i:s');
    $obj = array('id' => $product->getID(), 'name' => $product->name, 'description' => $product->description, 'category' => $product->category, 'avaible' => $date, 'stock' => $product->stock, 'untiprice' => $product->unitprice, false);
    array_push($products2, $obj);
}
echo json_encode($products2);
