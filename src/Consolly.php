<?php

namespace Consolly;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorEvents;
use Consolly\Distributor\DistributorInterface;
use Consolly\Event\Consolly\ExceptionEvent;
use Consolly\Event\Distributor\CommandFoundEvent;
use Consolly\Event\Distributor\CommandNotFoundEvent;
use Consolly\Event\Distributor\CommandsEvent;
use Consolly\Event\Distributor\NextArgumentsEvent;
use Consolly\Event\Source\ArgumentsEvent;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Formatter\Formatter;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Source\SourceEvents;
use Consolly\Source\SourceInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Throwable;

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
     * Event dispatcher for dispatching and listening events.
     *
     * @var EventDispatcherInterface $dispatcher
     */
    protected EventDispatcherInterface $dispatcher;

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
        ?CommandInterface $defaultCommand = null,
        ?EventDispatcherInterface $dispatcher = null
    ) {
        $this->defaultCommand = $defaultCommand;
        $this->source = $source;
        $this->distributor = $distributor;
        $this->commands = [];

        $this->dispatcher = $dispatcher === null ? new EventDispatcher() : $dispatcher;
    }

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
     * Returns the symfony dispatcher.
     *
     * @return EventDispatcherInterface
     */
    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * Sets the symfony dispatcher.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Invokes the {@link DistributorEvents::COMMANDS} event and sets commands.
     */
    protected function invokeCommands(): void
    {
        $commands = $this->commands;

        if ($this->dispatcher->hasListeners(DistributorEvents::COMMANDS)) {
            $event = new CommandsEvent($commands);

            $this->dispatcher->dispatch($event, DistributorEvents::COMMANDS);

            $commands = $event->getCommands();
        }

        $this->distributor->setCommands($commands);
    }

    /**
     * Invokes the {@link SourceEvents::ARGUMENTS} event and pass it to the distributor.
     */
    protected function invokeArguments(): void
    {
        $arguments = $this->source->getArguments();

        if ($this->dispatcher->hasListeners(SourceEvents::ARGUMENTS)) {
            $event = new ArgumentsEvent($arguments);

            $this->dispatcher->dispatch($event, SourceEvents::ARGUMENTS);

            $arguments = $event->getArguments();
        }

        $this->distributor->setArguments($arguments);
    }

    /**
     * Invokes {@link DistributorEvents::COMMAND_NOT_FOUND} if command not found.
     *
     * Invokes {@link DistributorEvents::COMMAND_FOUND} if command found
     * even if {@link DistributorEvents::COMMAND_NOT_FOUND} was invoked.
     *
     * @return CommandInterface
     *
     * @throws CommandNotFoundException If no command found and listener not set command.
     */
    protected function invokeSearch(): CommandInterface
    {
        $command = $this->distributor->getCommand();

        if ($command === null) {
            if ($this->defaultCommand === null) {
                if ($this->dispatcher->hasListeners(DistributorEvents::COMMAND_NOT_FOUND)) {
                    $event = new CommandNotFoundEvent($this->commands);

                    $this->dispatcher->dispatch($event, DistributorEvents::COMMAND_NOT_FOUND);

                    $command = $event->getCommand();
                }

                if ($command === null) {
                    throw new CommandNotFoundException('Command not found. ');
                }
            } else {
                $command = $this->defaultCommand;
            }
        }

        if ($this->dispatcher->hasListeners(DistributorEvents::COMMAND_FOUND)) {
            $event = new CommandFoundEvent($command);

            $this->dispatcher->dispatch($event, DistributorEvents::COMMAND_FOUND);

            $command = $event->getCommand();
        }

        return $command;
    }

    /**
     * Invokes the {@link DistributorEvents::NEXT_ARGUMENTS} event.
     *
     * @return array
     */
    protected function invokeNextArguments(): array
    {
        $arguments = $this->distributor->getNextArguments();

        if ($this->dispatcher->hasListeners(DistributorEvents::NEXT_ARGUMENTS)) {
            $event = new NextArgumentsEvent($arguments);

            $this->dispatcher->dispatch($event, DistributorEvents::NEXT_ARGUMENTS);

            $arguments = $event->getArguments();
        }


        return $arguments;
    }

    /**
     * Handles commands by given args.
     *
     * @return mixed|void
     * Returns a result of handle() function of the command or void if none.
     *
     * @throws CommandNotFoundException|Throwable
     * Throws when the command not found and the default command not defined.
     */
    public function handle()
    {
        try {
            $this->invokeCommands();
            $this->invokeArguments();

            $command = $this->invokeSearch();

            $this->distributor->handleArguments($command);

            return $command->handle(
                $this->invokeNextArguments()
            );
        } catch (Throwable $throwable) {
            if ($this->dispatcher->hasListeners(ConsollyEvents::EXCEPTION)) {
                $event = new ExceptionEvent($throwable);

                $this->dispatcher->dispatch($event, ConsollyEvents::EXCEPTION);

                if ($event->getResult() !== null) {
                    return $event->getResult();
                }

                $throwable = $event->getThrowable();
            }

            throw $throwable;
        }
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
