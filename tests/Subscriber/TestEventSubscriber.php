<?php

namespace Consolly\Tests\Subscriber;

/**
 * Class TestEventSubscriber represents base event subscriber class.
 *
 * @package Consolly\Tests\Subscriber
 */
class TestEventSubscriber
{
    /**
     * TestEventSubscriber constructor.
     *
     * @param bool $successful
     *
     * @param bool $executed
     */
    public function __construct(protected bool $successful = false, protected bool $executed = false)
    {
    }

    /**
     * Returns true if the event data is as expected.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    /**
     * Sets whether the event is successful.
     *
     * @param bool $successful
     */
    public function setSuccessful(bool $successful): void
    {
        $this->successful = $successful;
    }

    /**
     * Returns true if the event is executed.
     *
     * @return bool
     */
    public function isExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * Sets whether the event is executed.
     *
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void
    {
        $this->executed = $executed;
    }
}
