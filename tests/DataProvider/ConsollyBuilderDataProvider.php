<?php

namespace Consolly\Tests\DataProvider;

use Consolly\Consolly;
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
use Consolly\Tests\Unit\ConsollyBuilderTest;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ConsollyBuilderDataProvider represents data provider for {@link ConsollyBuilderTest} test.
 *
 * @package Consolly\Tests\DataProvider
 */
class ConsollyBuilderDataProvider
{
    /**
     * Returns data for {@link ConsollyBuilderTest::testWithDispatcher()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithDistributor()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithSource()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithDefaultCommand()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithCommand()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithCommands()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithListener()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithListeners()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithSubscriber()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testWithSubscribers()} test.
     *
     * @return Consolly[][]
     */
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

    /**
     * Returns data for {@link ConsollyBuilderTest::testSourceAndArgumentsNotProvidedException()} test.
     *
     * @return Consolly[][]
     */
    public function getSourceAndArgumentsNotProvidedExceptionArguments(): array
    {
        return [
            [
                (new ConsollyBuilder())->build()
            ]
        ];
    }
}
