<?php

class ErrorLog
{
    const ERROR_FILE = __DIR__ . "/../../log/siteerrors.log";
    private $errno;
    private $errMsg;
    private $errFile;
    private $errLine;

    public function __construct($errno = 0, $errMsg = "", $errFile = "", $errLine = "")
    {
        $this->errno = $errno;
        $this->errMsg = $errMsg;
        $this->errFile = $errFile;
        $this->errLine = $errLine;
    }

    public function WriteError()
    {
        $error = "[" . date("Y-m-d H:i:s") . "]";
        $error .= " [ERROR:" . $this->errno . "]";
        $error .= " [" . $this->errFile . ":" . $this->errLine . "]";
        $error .= ": " . $this->errMsg . "\n";

        // Log details of error in a file
        error_log($error, 3, self::ERROR_FILE);
    }
}
