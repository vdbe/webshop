<?php

$needs_to_be_logged_in = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

$response = array('status' => 'success');

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/product.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');

$json = file_get_contents('php://input');


$name = '';
$desc = '';
$catg = '';

if (!empty($json)) {
    $data = json_decode($json);
    $name = $data->name;
    $desc = $data->description;
    $catg = $data->category;
}


$products = Product::search($db, $name, $desc, $catg);

$assoc_products = [];

foreach ($products as $product) {
    $dateTime = $product->available;
    $date = $dateTime->format('Y-m-d H:i:s');
    array_push($assoc_products, array('id' => $product->getID(), 'name' => $product->name, 'description' => $product->description, 'category' => $product->category, 'avaible' => $date, 'stock' => $product->stock, 'untiprice' => $product->unitprice));
}

echo json_encode($assoc_products);
