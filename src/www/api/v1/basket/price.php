<?php

$NEEDS_TO_BE_LOGGED_IN = 1;

require_once __dir__ . '/../../../include/php_header.php';

header('content-type: application/json; charset=utf-8');

$response = array('status' => 'success');

require_once __DIR__ . '/../../../include/class/db.php';
require_once __DIR__ . '/../../../include/class/userorder.php';

$db = new DB();

$basket = UserOrder::basket($db, $USER);
$totalprice = $basket->getPrice($db);
$repsonse['totalprice'] = $totalprice;

echo json_encode($repsonse);
