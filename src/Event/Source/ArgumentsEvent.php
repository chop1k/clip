<?php

namespace Consolly\Event\Source;

use Symfony\Contracts\EventDispatcher\Event;

class ArgumentsEvent extends Event
{
    public function __construct(protected array $arguments)
    {
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }
}
