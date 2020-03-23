<?php

namespace Logger;

class FakeLogger extends AbstractLoggerRoute
{
    public function log(int $level, string $message = '')
    {
        if ($this->isHandling($level)) {
            // Делает ничего
        }
    }
}