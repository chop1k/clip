<?php

namespace Consolly;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorInterface;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Formatter\Formatter;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Source\SourceInterface;

/**
 * Class Consolly contains main functional for working with Consolly architecture.
 *
 * @package Consolly
 */
class Consolly
{
    /**
     * Contains array of commands.
     *
     * @var array $commands
     */
    protected array $commands;

    /**
     * Contains command which will be executed of command not specified.
     *
     * @var CommandInterface|null
     */
    protected ?CommandInterface $defaultCommand;

    /**
     * Contains source.
     *
     * @var SourceInterface $source
     */
    protected SourceInterface $source;

    /**
     * Contains distributor.
     *
     * @var DistributorInterface $distributor
     */
    protected DistributorInterface $distributor;

    /**
     * Returns an array of registered commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Sets an array of registered commands.
     *
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    /**
     * Adds command to the commands array.
     *
     * @param CommandInterface $command
     */
    public function addCommand(CommandInterface $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    /**
     * Returns the default command.
     *
     * @return CommandInterface|null
     */
    public function getDefaultCommand(): ?CommandInterface
    {
        return $this->defaultCommand;
    }

    /**
     * Sets the default command.
     *
     * @param CommandInterface $defaultCommand
     */
    public function setDefaultCommand(CommandInterface $defaultCommand): void
    {
        $this->defaultCommand = $defaultCommand;
    }

    /**
     * Returns the source.
     *
     * @return SourceInterface
     */
    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    /**
     * Sets the source.
     *
     * @param SourceInterface $source
     */
    public function setSource(SourceInterface $source): void
    {
        $this->source = $source;
    }

    /**
     * Returns the distributor.
     *
     * @return DistributorInterface
     */
    public function getDistributor(): DistributorInterface
    {
        return $this->distributor;
    }

    /**
     * Sets the distributor.
     *
     * @param DistributorInterface $distributor
     */
    public function setDistributor(DistributorInterface $distributor): void
    {
        $this->distributor = $distributor;
    }

    /**
     * Consolly constructor.
     *
     * @param SourceInterface $source
     * Source for getting arguments.
     *
     * @param DistributorInterface $distributor
     * Distributor for distributing arguments from the source.
     *
     * @param CommandInterface|null $defaultCommand
     * Default command which will be executed if no command was found by distributor.
     */
    public function __construct(
        SourceInterface $source,
        DistributorInterface $distributor,
        ?CommandInterface $defaultCommand = null
    ) {
        $this->defaultCommand = $defaultCommand;
        $this->source = $source;
        $this->distributor = $distributor;
        $this->commands = [];
    }

    /**
     * Handles commands by given args.
     *
     * @return mixed
     * Returns a result of handle() function of the command.
     *
     * @throws CommandNotFoundException
     * Throws when the command not found and the default command not defined.
     */
    public function handle()
    {
        $this->distributor->setCommands(
            $this->commands
        );

        $this->distributor->setArguments(
            $this->source->getArguments()
        );

        $command = $this->distributor->getCommand();

        if (is_null($command)) {
            if (is_null($this->defaultCommand)) {
                throw new CommandNotFoundException('Command not found. ');
            }

            $command = $this->defaultCommand;
        }

        $this->distributor->handleArguments($command);

        return $command->handle(
            $this->distributor->getNextArguments()
        );
    }

    /**
     * Shortcut for creating default preset.
     *
     * @param array $argv
     *
     * @param CommandInterface|null $defaultCommand
     *
     * @return static
     */
    public static function default(array $argv, ?CommandInterface $defaultCommand = null): self
    {
        return new Consolly(
            new ConsoleArgumentsSource($argv),
            new Distributor(new Formatter()),
            $defaultCommand
        );
    }
}
