<?php

namespace Logger;

use DateTime;

class FileLogger extends AbstractLoggerRoute
{
    protected $fileHandle;

    protected static $levelsPrinted = [
        LogLevel::LEVEL_ERROR     => 'ERROR',
        LogLevel::LEVEL_INFO      => 'INFO',
        LogLevel::LEVEL_DEBUG     => 'DEBUG',
        LogLevel::LEVEL_NOTICE    => 'NOTICE',
    ];

    public function __construct(array $options = null)
    {
        parent::__construct($options);
        $this->fileHandle = fopen($options['filename'], 'a');
    }

    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }
    
    public function log(int $level, string $message = '')
    {
        if ($this->isHandling($level)) {
            $datetime = new DateTime();
            $formattedMessage = sprintf("%s  %s  %03d  %s\n", $datetime->format(DateTime::ATOM), self::$levelsPrinted[$level], $level, $message);
            $this->write($formattedMessage);
        }
    }

    private function write(string $message)
    {
        return fwrite($this->fileHandle, $message);
    }
}