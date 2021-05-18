<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CommandFoundEvent represents event object with information for {@link DistributorEvents::COMMAND_FOUND} event.
 *
 * @package Consolly\Event\Distributor
 */
class CommandFoundEvent extends Event
{
    /**
     * CommandFoundEvent constructor.
     *
     * @param CommandInterface $command
     */
    public function __construct(protected CommandInterface $command)
    {
    }

    /**
     * Returns command found.
     *
     * @return CommandInterface
     */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    /**
     * Rewrites the command.
     *
     * @param CommandInterface $command
     */
    public function setCommand(CommandInterface $command): void
    {
        $this->command = $command;
    }
}
