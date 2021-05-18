<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CommandNotFoundEvent extends Event
{
    public function __construct(protected array $commands, protected ?CommandInterface $command = null)
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
     * @return CommandInterface|null
     */
    public function getCommand(): ?CommandInterface
    {
        return $this->command;
    }

    /**
     * @param CommandInterface|null $command
     */
    public function setCommand(?CommandInterface $command): void
    {
        $this->command = $command;
    }
}
