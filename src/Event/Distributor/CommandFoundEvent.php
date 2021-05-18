<?php

namespace Consolly\Event\Distributor;

use Consolly\Command\CommandInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CommandFoundEvent extends Event
{
    public function __construct(protected CommandInterface $command)
    {
    }

    /**
     * @return CommandInterface
     */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    /**
     * @param CommandInterface $command
     */
    public function setCommand(CommandInterface $command): void
    {
        $this->command = $command;
    }
}
