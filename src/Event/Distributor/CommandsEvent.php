<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CommandsEvent extends Event
{
    public function __construct(protected array $commands)
    {
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    public function addCommand(CommandInterface $command): void
    {
        $this->commands[] = $command;
    }
}
