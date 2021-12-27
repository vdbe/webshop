<?php

require_once __DIR__ . "/class/log.php";

function handleUncaughtException($e)
{
    $log = new ErrorLog($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    $log->WriteError();
    exit("An unexpected error occurred. Please contact the system administrator!");
}

set_exception_handler('handleUncaughtException');

class MyException extends Exception
{
    public function HandleException()
    {
        $log = new ErrorLog($this->getCode(), $this->getMessage(), $this->getFile(), $this->getLine());
        $log->WriteError();
        exit($this->getMessage());
    }
}
