<?php

$NEEDS_TO_BE_LOGGED_IN = 1;


require_once __dir__ . '/../../../include/php_header.php';

require_once __DIR__ . '../../../../include/class/db.php';
require_once __DIR__ . '../../../../include/class/userorder.php';

//header('Content-Type: application/json; charset=utf-8');

$response = array('status' => 'success');

$db = new DB();

$basket = UserOrder::basket($db, $USER);
if ($basket->placeorder($db)) {

    echo json_encode($response);
} else {
    $response['status'] = "failed";
    echo json_encode($response);
    die();
}
