<?php

namespace Consolly\Event\Source;

use Consolly\Source\SourceEvents;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ArgumentsEvent represents event object with information for {@link SourceEvents::ARGUMENTS} event.
 *
 * @package Consolly\Event\Source
 */
class ArgumentsEvent extends Event
{
    /**
     * ArgumentsEvent constructor.
     *
     * @param array $arguments
     */
    public function __construct(protected array $arguments)
    {
    }

    /**
     * Returns arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Rewrites arguments.
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }
}
