<?php

if (isset($ADMIN_ONLY)) {
    if ($ADMIN_ONLY == 1) {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            if ($user->role_name == 'admin') {
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST']);
            }
        } else {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    }
}

if (isset($NEEDS_TO_BE_LOGGED_IN)) {
    if ($NEEDS_TO_BE_LOGGED_IN == 0) {
        if (isset($_SESSION['user'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    } elseif ($NEEDS_TO_BE_LOGGED_IN == 1) {
        if (!isset($_SESSION['user'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        }
    }
}
