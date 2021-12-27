<?php

$NEEDS_TO_BE_LOGGED_IN = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

$response = array('status' => 'success');

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/product.php';

$db = new DB();

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
    array_push($assoc_products, array('id' => $product->getID(), 'name' => htmlspecialchars($product->name), 'description' => htmlspecialchars($product->description), 'category' => htmlspecialchars($product->category), 'available' => htmlspecialchars_decode($date), 'stock' => $product->stock, 'unitprice' => $product->unitprice));
}

foreach ($assoc_products as &$element) {
    foreach ($element as $key => &$value) {
        if (gettype($value) == "string") {
            $element[$key] = htmlspecialchars($value);
        }
    }
}

echo json_encode($assoc_products);
