<?php

namespace Consolly\Tests\Unit;

use Consolly\Consolly;
use Consolly\ConsollyBuilder;
use Consolly\ConsollyEvents;
use Consolly\Distributor\Distributor;
use Consolly\Distributor\DistributorEvents;
use Consolly\Source\ConsoleArgumentsSource;
use Consolly\Source\SourceEvents;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\ConsollyBuilderDataProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ConsollyBuilderTest represents test for {@link ConsollyBuilder} class.
 *
 * @package Consolly\Tests\Unit
 */
class ConsollyBuilderTest extends TestCase
{
    /**
     * Data provider for test.
     *
     * @var ConsollyBuilderDataProvider $dataProvider
     */
    protected ConsollyBuilderDataProvider $dataProvider;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ConsollyBuilderDataProvider();
    }

    /**
     * Data provider for testing dispatcher.
     *
     * @return Consolly[]
     */
    public function getWithDispatcherArguments(): array
    {
        return $this->dataProvider->getWithDispatcherArguments();
    }

    /**
     * Tests whether the dispatcher sets correctly.
     *
     * @dataProvider getWithDispatcherArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDispatcher(Consolly $consolly): void
    {
        self::assertInstanceOf(EventDispatcher::class, $consolly->getDispatcher());
    }

    /**
     * Data provider for testing distributor.
     *
     * @return Consolly[]
     */
    public function getWithDistributorArguments(): array
    {
        return $this->dataProvider->getWithDistributorArguments();
    }

    /**
     * Tests whether the distributor sets correctly.
     *
     * @dataProvider getWithDistributorArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDistributor(Consolly $consolly): void
    {
        self::assertInstanceOf(Distributor::class, $consolly->getDistributor());
    }

    /**
     * Data provider for testing source.
     *
     * @return Consolly[]
     */
    public function getWithSourceArguments(): array
    {
        return $this->dataProvider->getWithSourceArguments();
    }

    /**
     * Tests whether the source sets correctly.
     *
     * @dataProvider getWithSourceArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSource(Consolly $consolly): void
    {
        self::assertInstanceOf(ConsoleArgumentsSource::class, $consolly->getSource());
    }

    /**
     * Data provider for testing the default command.
     *
     * @return Consolly[]
     */
    public function getWithDefaultCommandArguments(): array
    {
        return $this->dataProvider->getWithDefaultCommandArguments();
    }

    /**
     * Tests whether the default command sets correctly.
     *
     * @dataProvider getWithDefaultCommandArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDefaultCommand(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getDefaultCommand());
    }

    /**
     * Data provider for testing the command.
     *
     * @return Consolly[]
     */
    public function getWithCommandArguments(): array
    {
        return $this->dataProvider->getWithCommandArguments();
    }

    /**
     * Tests whether the command adds correctly.
     *
     * @dataProvider getWithCommandArguments
     *
     * @param Consolly $consolly
     */
    public function testWithCommand(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getCommands()[0]);
    }

    /**
     * Data provider for testing the command.
     *
     * @return Consolly[]
     */
    public function getWithCommandsArguments(): array
    {
        return $this->dataProvider->getWithCommandsArguments();
    }

    /**
     * Tests whether the command sets correctly.
     *
     * @dataProvider getWithCommandsArguments
     *
     * @param Consolly $consolly
     */
    public function testWithCommands(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getCommands()[0]);
        self::assertInstanceOf(TestCommand::class, $consolly->getCommands()[1]);
    }

    /**
     * Data provider for testing the listener.
     *
     * @return Consolly[]
     */
    public function getWithListenerArguments(): array
    {
        return $this->dataProvider->getWithListenerArguments();
    }

    /**
     * Tests whether the listener sets correctly.
     *
     * @dataProvider getWithListenerArguments
     *
     * @param Consolly $consolly
     */
    public function testWithListener(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(ConsollyEvents::EXCEPTION));
    }

    /**
     * Data provider for testing the listeners.
     *
     * @return Consolly[]
     */
    public function getWithListenersArguments(): array
    {
        return $this->dataProvider->getWithListenersArguments();
    }

    /**
     * Tests whether the listeners sets correctly.
     *
     * @dataProvider getWithListenersArguments
     *
     * @param Consolly $consolly
     */
    public function testWithListeners(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(ConsollyEvents::EXCEPTION));
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::COMMANDS));
    }

    /**
     * Data provider for testing the subscriber.
     *
     * @return Consolly[]
     */
    public function getWithSubscriberArguments(): array
    {
        return $this->dataProvider->getWithSubscriberArguments();
    }

    /**
     * Tests whether the subscriber sets correctly.
     *
     * @dataProvider getWithSubscriberArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSubscriber(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::NEXT_ARGUMENTS));
    }

    /**
     * Data provider for testing subscribers.
     *
     * @return Consolly[]
     */
    public function getWithSubscribersArguments(): array
    {
        return $this->dataProvider->getWithSubscribersArguments();
    }

    /**
     * Tests whether the subscribers sets correctly.
     *
     * @dataProvider getWithSubscribersArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSubscribers(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::NEXT_ARGUMENTS));
        self::assertTrue($consolly->getDispatcher()->hasListeners(SourceEvents::ARGUMENTS));
    }

    /**
     * Tests whether exception throws when no source and no arguments provided at same time.
     */
    public function testSourceAndArgumentsNotProvidedException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->dataProvider->getSourceAndArgumentsNotProvidedExceptionArguments();
    }
}
