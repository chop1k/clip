<?php

namespace Consolly\Event\Consolly;

use Consolly\ConsollyEvents;
use Throwable;

/**
 * Class ExceptionEvent represent event object with information for {@link ConsollyEvents::EXCEPTION} event.
 *
 * @package Consolly\Event\Consolly
 */
class ExceptionEvent
{
    /**
     * Contains result. If not null it will be returned by handle() method.
     *
     * @var mixed $result
     */
    protected mixed $result;

    /**
     * ExceptionEvent constructor.
     *
     * @param Throwable $throwable
     */
    public function __construct(protected Throwable $throwable)
    {
        $this->result = null;
    }

    /**
     * Gets exception.
     *
     * @return Throwable
     */
    public function getThrowable(): Throwable
    {
        return $this->throwable;
    }

    /**
     * Rewrites the exception.
     *
     * @param Throwable $throwable
     */
    public function setThrowable(Throwable $throwable): void
    {
        $this->throwable = $throwable;
    }

    /**
     * Returns current result.
     *
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * Sets result. It will be returned by handle() method.
     *
     * @param mixed $result
     */
    public function setResult(mixed $result): void
    {
        $this->result = $result;
    }
}
