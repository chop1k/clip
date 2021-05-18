<?php

namespace Consolly\Event\Distributor;

use Consolly\Distributor\DistributorEvents;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class NextArgumentsEvent represents event object with information for {@link DistributorEvents::NEXT_ARGUMENTS} event
 *
 * @package Consolly\Event\Distributor
 */
class NextArgumentsEvent extends Event
{
    /**
     * NextArgumentsEvent constructor.
     *
     * @param array $arguments
     */
    public function __construct(protected array $arguments)
    {
    }

    /**
     * Gets next arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Rewrites next arguments.
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }
}
