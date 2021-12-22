<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/category.php';


$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');
$categories = Category::getCategories($db);

var_dump($categories);
echo "<br>";
foreach ($categories as &$category) {
    var_dump($category);
    echo "<br>";
    foreach ($category as $key => &$value) {
        if (gettype($value) == "string") {
            $category[$key] = htmlspecialchars($value);
        }
    }
}

echo json_encode($categories);
