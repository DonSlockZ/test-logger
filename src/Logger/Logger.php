<?php

namespace Logger;

/**
 * Компонент логирования с поддержкой разных способов логирования
 */
class Logger implements LoggerInterface
{
    protected $routes = [];

    public function addLogger(LoggerInterface $logger): self
    {
        array_push($this->routes, $logger);
        return $this;
    }

    public function log(int $level, string $message)
    {
        foreach ($this->routes as $route) {
            $route->log($level, $message);
        }
    }

    public function error(string $message)
    {
        $this->log(LogLevel::LEVEL_ERROR, $message);
    }

    public function info(string $message)
    {
        $this->log(LogLevel::LEVEL_INFO, $message);
    }

    public function debug(string $message)
    {
        $this->log(LogLevel::LEVEL_DEBUG, $message);
    }

    public function notice(string $message)
    {
        $this->log(LogLevel::LEVEL_NOTICE, $message);
    }
}