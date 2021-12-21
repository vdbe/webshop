<?php

// Set default state
$LOGGED_IN = 0;
$IS_ADMIN = 0;

// Get state
if (isset($_SESSION['user'])) {
    $LOGGED_IN = 1;
}

if ($LOGGED_IN == 1) {
    require_once __DIR__ . '/class/user.php';
    $USER = unserialize($_SESSION['user']);
    if ($USER->getRole() == 'admin') {
        $IS_ADMIN = 1;
    }
}

// Check permission
if (isset($NEEDS_TO_BE_LOGGED_IN)) {
    if ($NEEDS_TO_BE_LOGGED_IN == 1) {
        if ($LOGGED_IN == 0) {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    } elseif ($NEEDS_TO_BE_LOGGED_IN == 0) {
        if ($LOGGED_IN == 1) {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    }
}

if (isset($ADMIN_ONLY) && $LOGGED_IN) {
    if ($ADMIN_ONLY == 1) {
        if ($IS_ADMIN == 1) {
        } else {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    }
}
