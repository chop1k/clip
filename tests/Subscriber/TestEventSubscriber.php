<?php

namespace Consolly\Tests\Subscriber;

class TestEventSubscriber
{
    public function __construct(protected bool $successful = false, protected bool $executed = false)
    {
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    /**
     * @param bool $successful
     */
    public function setSuccessful(bool $successful): void
    {
        $this->successful = $successful;
    }

    public function testEvent(): void
    {
        $this->successful = true;
    }

    /**
     * @return bool
     */
    public function isExecuted(): bool
    {
        return $this->executed;
    }

    /**
     * @param bool $executed
     */
    public function setExecuted(bool $executed): void
    {
        $this->executed = $executed;
    }
}
