<?php

namespace Logger;

use DateTime;

class SyslogLogger extends AbstractLoggerRoute
{
    protected static $syslogLevelsMapped = [
        LogLevel::LEVEL_ERROR     => LOG_ERR,
        LogLevel::LEVEL_INFO      => LOG_INFO,
        LogLevel::LEVEL_DEBUG     => LOG_DEBUG,
        LogLevel::LEVEL_NOTICE    => LOG_NOTICE,
    ];

    protected static $levelsPrinted = [
        LogLevel::LEVEL_ERROR     => 'ERROR',
        LogLevel::LEVEL_INFO      => 'INFO',
        LogLevel::LEVEL_DEBUG     => 'DEBUG',
        LogLevel::LEVEL_NOTICE    => 'NOTICE',
    ];

    public function __construct(array $options = null)
    {
        parent::__construct($options);
        openlog("phpLogger", LOG_PID | LOG_PERROR, LOG_LOCAL0);
    }
    
    public function log(int $level, string $message)
    {
        if ($this->isHandling($level)) {
            $datetime = new DateTime();
            $formattedMessage = sprintf("%s  %s  %03d  %s\n", $datetime->format(DateTime::ATOM), self::$levelsPrinted[$level], $level, $message);
            syslog(self::$syslogLevelsMapped[$level], $formattedMessage);
        }
    }
}