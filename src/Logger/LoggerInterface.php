<?php

namespace Logger;

interface LoggerInterface
{
    public function error(string $message);

    public function info(string $message);

    public function debug(string $message);

    public function notice(string $message);

    public function log(int $level, string $message);
}