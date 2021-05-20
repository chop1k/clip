<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CommandNotFoundEvent represents event object
 * with information for {@link DistributorEvents::COMMAND_NOT_FOUND} event.
 *
 * @package Consolly\Event\Distributor
 */
class CommandNotFoundEvent extends Event
{
    /**
     * CommandNotFoundEvent constructor.
     *
     * @param array $commands
     *
     * @param CommandInterface|null $command
     */
    public function __construct(protected array $commands, protected ?CommandInterface $command = null)
    {
    }

    /**
     * Returns array of registered commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Gets rewritten command.
     *
     * @return CommandInterface|null
     */
    public function getCommand(): ?CommandInterface
    {
        return $this->command;
    }

    /**
     * Rewrites command.
     *
     * @param CommandInterface|null $command
     */
    public function setCommand(?CommandInterface $command): void
    {
        $this->command = $command;
    }
}
