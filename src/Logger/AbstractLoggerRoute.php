<?php

namespace Logger;

/**
 * Способ логирования
 */
abstract class AbstractLoggerRoute implements LoggerInterface
{
    protected $isEnabled;

    /**
     * Уровни логирования в которые необходимо делать запись
     */
    protected $levels;

    /**
     * Список поддерживаемых уровней логирования
     */
    protected $availableLevels = [
        LogLevel::LEVEL_ERROR,
        LogLevel::LEVEL_INFO,
        LogLevel::LEVEL_DEBUG,
        LogLevel::LEVEL_NOTICE,
    ];

    public function __construct(array $options = null)
    {
        $this->isEnabled = $options['is_enabled'] ?? true;
        $newLevels = $options['levels'] ?? $this->availableLevels;
        $this->setLevels($newLevels);
    }

    /**
     * Проверяет готовность сделать запись в журнал
     */
    public function isHandling(int $level)
    {
        return ($this->isEnabled && $this->canLogLevel($level));
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

    public function setIsEnabled(bool $isEnabled)
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }

    public function canLogLevel(int $level)
    {
        return in_array($level, $this->levels);
    }
    
    /**
     * Установливает в какие уровни логирования из списка поддерживаемых необходимо производить запись.
     */
    public function setLevels(array $levels)
    {
        $newLevels = [];
        foreach ($levels as $level) {
            if (in_array($level, $this->availableLevels)) {
                $newLevels[] = $level;
            } else {
                throw new Exception('Logger can\'t work with custom log levels');
            }
        }
        $this->levels = $newLevels;
        return $this;
    }

    public function getLevels()
    {
        return $this->levels;
    }
}