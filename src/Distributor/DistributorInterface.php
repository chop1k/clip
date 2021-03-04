<?php

namespace Consolly\Distributor;

use Consolly\Command\CommandInterface;

/**
 * Interface DistributorInterface defines functionality required by each distributor.
 *
 * @package Consolly\Distributor
 */
interface DistributorInterface
{
    /**
     * Sets an array of the commands.
     *
     * @param array $commands
     */
    public function setCommands(array $commands): void;

    /**
     * Sets an array of argument which will be handled.
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments): void;

    /**
     * Finds command in the arguments and returns command.
     * If no commands found, it returns null.
     *
     * @return CommandInterface|null
     */
    public function getCommand(): ?CommandInterface;

    /**
     * Handling given arguments.
     *
     * @param CommandInterface $command
     * The command given by getCommand method or default command if getCommand method returned null.
     */
    public function handleOptions(CommandInterface $command): void;

    /**
     * Returns an array of next arguments, which will be transferred to the handle method of the command.
     *
     * @return array
     */
    public function getNextArguments(): array;
}
