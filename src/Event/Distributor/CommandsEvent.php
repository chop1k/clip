<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CommandsEvent represents event object with information for {@link DistributorEvents::COMMANDS} event.
 *
 * @package Consolly\Event\Distributor
 */
class CommandsEvent extends Event
{
    /**
     * CommandsEvent constructor.
     *
     * @param array $commands
     */
    public function __construct(protected array $commands)
    {
    }

    /**
     * Returns all registered commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Rewrites array of registered commands.
     *
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    /**
     * Adds command to the array.
     *
     * @param CommandInterface $command
     */
    public function addCommand(CommandInterface $command): void
    {
        $this->commands[] = $command;
    }
}
