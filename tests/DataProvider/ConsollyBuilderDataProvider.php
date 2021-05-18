<?php

namespace Consolly\Tests\DataProvider;

use Consolly\ConsollyBuilder;
use Consolly\ConsollyEvents;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorEvents;
use Consolly\Formatter\Formatter;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\Subscriber\Consolly\ExceptionEventSubscriber;
use Consolly\Tests\Subscriber\Distributor\CommandsEventSubscriber;
use Consolly\Tests\Subscriber\Distributor\NextArgumentsEventSubscriber;
use Consolly\Tests\Subscriber\Source\ArgumentsEventSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ConsollyBuilderDataProvider
{
    public function getWithDispatcherArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withDispatcher(new EventDispatcher())
                ->build([])
            ]
        ];
    }

    public function getWithDistributorArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withDistributor(new Distributor(new Formatter()))
                ->build([])
            ]
        ];
    }

    public function getWithSourceArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withSource(new ConsoleArgumentsSource([]))
                ->build()
            ]
        ];
    }

    public function getWithDefaultCommandArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withDefaultCommand(new DefaultTestCommand())
                ->build([])
            ]
        ];
    }

    public function getWithCommandArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withCommand(new DefaultTestCommand())
                ->build([])
            ]
        ];
    }

    public function getWithCommandsArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withCommands([
                        new DefaultTestCommand(),
                        new TestCommand()
                    ])
                ->build([])
            ]
        ];
    }

    public function getWithListenerArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withListener(ConsollyEvents::EXCEPTION, [[ExceptionEventSubscriber::class, 'onException']])
                ->build([])
            ]
        ];
    }

    public function getWithListenersArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withListeners([
                        ConsollyEvents::EXCEPTION => [[ExceptionEventSubscriber::class, 'onException']],
                        DistributorEvents::COMMANDS => [[CommandsEventSubscriber::class, 'onCommands']]
                    ])
                ->build([])
            ]
        ];
    }

    public function getWithSubscriberArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withSubscriber(new NextArgumentsEventSubscriber([], []))
                ->build([])
            ]
        ];
    }

    public function getWithSubscribersArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())
                    ->withSubscribers([
                        new NextArgumentsEventSubscriber([], []),
                        new ArgumentsEventSubscriber([], [])
                    ])
                ->build([])
            ]
        ];
    }

    public function getSourceAndArgumentsNotProvidedExceptionArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())->build()
            ]
        ];
    }
}
