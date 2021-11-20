<?php
include 'include/class/db.php';

$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');

$db->query('DELETE FROM Category;');

$db->bind_reference = true;

$category_name = 'food';
$category_description = 'any nutritious substance that people or animals eat or drink or that plants absorb in order to maintain life and growth.';

$query = 'INSERT INTO Category (category_name, category_description) VALUES (?, ?)';
$db->query($query, 'ss', array(&$category_name, &$category_description));
$db->execute();

if ($db->errno) {
  exit($db->error);
}

$category_name = 'bricks';
$category_description = 'Small rectangular blocks';
$db->execute();

if ($db->errno) {
  exit($db->error);
}

$category_name = 'electronics';
$category_description = 'circuits or devices . using transistors, microchips, and other components.';
$db->execute();

if ($db->errno) {
  exit($db->error);
}

$db->bind_reference = false;
$db->query('SELECT * FROM Category WHERE category_name like ?', 's', '%s');

if ($db->errno) {
  exit($db->error);
}

$results = $db->fetch_all(MYSQLI_ASSOC);

foreach ($results as $result) {
  echo $result['category_id'] . ', ' . $result['category_name'] . ', ' . $result['category_description'] . '<br>';
}

$db->close();
