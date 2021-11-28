<?php

// TODO: header file
session_start();

unset($_SESSION['user']);

header("Location: http://" . $_SERVER['HTTP_HOST']);
exit();
