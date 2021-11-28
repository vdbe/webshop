<?php
// TODO: header file
session_start();

if (isset($_SESSION['user'])) {
  var_dump($_SESSION['user']);
  echo '<br>';
}

include 'include/class/db.php';



/* Empty table */
$db = new DB('database', 'Webuser', 'Lab2021', 'webshop');

$db->query('DELETE FROM Category;');

/* Insert rows */
$category_name = 'food';
$category_description = 'any nutritious substance that people or animals eat or drink or that plants absorb in order to maintain life and growth.';

$query = 'INSERT INTO Category (category_name, category_description) VALUES (?, ?)';
$db->query($query, 'ss', array(&$category_name, &$category_description));

if ($db->errno) {
  exit($db->error);
}
$db->execute();

if ($db->errno) {
  exit($db->error);
}

$category_name = 'bricks';
$category_description = 'Small rectangular blocks';
$db->execute();

$category_name = 'electronics';
$category_description = 'circuits or devices . using transistors, microchips, and other components.';
$db->execute();

$db->close_stmt();

/* Select rows */
$db->query('SELECT * FROM Category WHERE category_name like ?', 's', '%s');

if ($db->errno) {
  exit($db->error);
}

$results = $db->fetch_all(MYSQLI_ASSOC);

if ($db->errno) {
  exit($db->error);
}

foreach ($results as $result) {
  echo $result['category_id'] . ', ' . $result['category_name'] . ', ' . $result['category_description'] . '<br>';
}

var_dump($db->query('SELECT * FROM Category WHERE category_name like ?', 's', '%o%')->fetch_all());

/* Close db connection */
$db->close();
