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

class ConsollyBuilder
{
    protected ?DistributorInterface $distributor;

    protected ?SourceInterface $source;

    protected ?EventDispatcherInterface $dispatcher;

    protected ?CommandInterface $defaultCommand;

    protected array $commands;

    protected array $listeners;

    protected array $subscribers;

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

    public function withDistributor(?DistributorInterface $distributor): self
    {
        $this->distributor = $distributor;

        return $this;
    }

    public function withSource(?SourceInterface $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function withDispatcher(?EventDispatcherInterface $dispatcher): self
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    public function withDefaultCommand(?CommandInterface $command): self
    {
        $this->defaultCommand = $command;

        return $this;
    }

    public function withCommand(CommandInterface $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    public function withCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    public function withListener(string $event, array $listener): self
    {
        $this->listeners[$event] = $listener;

        return $this;
    }

    public function withListeners(array $listeners): self
    {
        $this->listeners = $listeners;

        return $this;
    }

    public function withSubscriber(EventSubscriberInterface $subscriber): self
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    public function withSubscribers(array $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }

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
