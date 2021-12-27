<?php

require_once __DIR__ . "/class/log.php";

function handleErrors($errno, $errMsg, $errFile, $errLine)
{
    $log = new ErrorLog($errno, $errMsg, $errFile, $errLine);
    $log->WriteError();
    echo "An error occurred. Please consult the error log file for more information.";
    exit();
}

set_error_handler("handleErrors");
