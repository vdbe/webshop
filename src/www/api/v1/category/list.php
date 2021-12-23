<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/category.php';


$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$categories = Category::getCategories($db);

foreach ($categories as &$category) {
    foreach ($category as $key => &$value) {
        if (gettype($value) == "string") {
            $category[$key] = htmlspecialchars($value);
        }
    }
}

echo json_encode($categories);
