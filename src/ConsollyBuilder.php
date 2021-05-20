<?php

namespace Consolly;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorInterface;
use Consolly\Formatter\Formatter;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Source\SourceInterface;
use InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConsollyBuilder builds consolly instance.
 *
 * @package Consolly
 */
class ConsollyBuilder
{
    /**
     * Contains distributor if specified.
     *
     * @var DistributorInterface|null $distributor
     */
    protected ?DistributorInterface $distributor;

    /**
     * Contains source if specified.
     *
     * @var SourceInterface|null $source
     */
    protected ?SourceInterface $source;

    /**
     * Contains event dispatcher if specified.
     *
     * @var EventDispatcherInterface|null $dispatcher
     */
    protected ?EventDispatcherInterface $dispatcher;

    /**
     * Contains default command if specified.
     *
     * @var CommandInterface|null $defaultCommand
     */
    protected ?CommandInterface $defaultCommand;

    /**
     * Contains an array of commands.
     *
     * @var array $commands
     */
    protected array $commands;

    /**
     * Contains an array of event listeners.
     *
     * @var array $listeners
     */
    protected array $listeners;

    /**
     * Contains an array of event subscribers.
     *
     * @var array $subscribers
     */
    protected array $subscribers;

    /**
     * ConsollyBuilder constructor.
     */
    public function __construct()
    {
        $this->distributor = null;
        $this->source = null;
        $this->dispatcher = null;
        $this->defaultCommand = null;

        $this->commands = [];
        $this->listeners = [];
        $this->subscribers = [];
    }

    /**
     * Sets distributor.
     *
     * @param DistributorInterface|null $distributor
     *
     * @return $this
     */
    public function withDistributor(?DistributorInterface $distributor): self
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * Sets source.
     *
     * @param SourceInterface|null $source
     *
     * @return $this
     */
    public function withSource(?SourceInterface $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Sets event dispatcher.
     *
     * @param EventDispatcherInterface|null $dispatcher
     *
     * @return $this
     */
    public function withDispatcher(?EventDispatcherInterface $dispatcher): self
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * Sets default command.
     *
     * @param CommandInterface|null $command
     *
     * @return $this
     */
    public function withDefaultCommand(?CommandInterface $command): self
    {
        $this->defaultCommand = $command;

        return $this;
    }

    /**
     * Adds the command.
     *
     * @param CommandInterface $command
     *
     * @return $this
     */
    public function withCommand(CommandInterface $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Sets commands array.
     *
     * @param CommandInterface[] $commands
     *
     * @return $this
     */
    public function withCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * Adds the listener to the dispatcher.
     *
     * @param string $event
     *
     * @param array $listener
     *
     * @return $this
     */
    public function withListener(string $event, array $listener): self
    {
        $this->listeners[$event] = $listener;

        return $this;
    }

    /**
     * Sets listeners array.
     *
     * @param array $listeners
     *
     * @return $this
     */
    public function withListeners(array $listeners): self
    {
        $this->listeners = $listeners;

        return $this;
    }

    /**
     * Adds subscriber to the dispatcher.
     *
     * @param EventSubscriberInterface $subscriber
     *
     * @return $this
     */
    public function withSubscriber(EventSubscriberInterface $subscriber): self
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    /**
     * Sets subscribers array.
     *
     * @param EventSubscriberInterface[] $subscribers
     *
     * @return $this
     */
    public function withSubscribers(array $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }

    /**
     * Build instance and returns it.
     *
     * @param array|null $arguments
     *
     * @return Consolly
     */
    public function build(?array $arguments = null): Consolly
    {
        if ($this->source === null && $arguments === null) {
            throw new InvalidArgumentException('The source or arguments must be provided. ');
        }

        $consolly = new Consolly(
            $this->source ?? new ConsoleArgumentsSource($arguments),
            $this->distributor ?? new Distributor(new Formatter()),
            $this->defaultCommand,
            $this->dispatcher
        );

        $consolly->setCommands($this->commands);

        $dispatcher = $consolly->getDispatcher();

        foreach ($this->listeners as $event => $listener) {
            $dispatcher->addListener($event, ...$listener);
        }

        foreach ($this->subscribers as $subscriber) {
            $dispatcher->addSubscriber($subscriber);
        }

        return $consolly;
    }
}
