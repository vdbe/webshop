<?php

$needs_to_be_logged_in = 1;
$ADMIN_ONLY = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

$response = array('status' => 'success');

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/product.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$products = Product::search($db, '', '', '', false);

$assoc_products = [];

foreach ($products as $product) {
    $dateTime = $product->available;
    $date = $dateTime->format('Y-m-d H:i:s');
    array_push($assoc_products, array('id' => $product->getID(), 'name' => htmlspecialchars($product->name), 'description' => htmlspecialchars($product->description), 'category' => htmlspecialchars($product->category), 'available' => htmlspecialchars_decode($date), 'stock' => $product->stock, 'unitprice' => $product->unitprice));
}
echo json_encode($assoc_products);
