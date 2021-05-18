<?php

namespace Consolly\Tests\Unit;

use Consolly\Consolly;
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

class ConsollyBuilderTest extends TestCase
{
    protected ConsollyBuilderDataProvider $dataProvider;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new ConsollyBuilderDataProvider();
    }

    public function getWithDispatcherArguments(): array
    {
        return $this->dataProvider->getWithDispatcherArguments();
    }

    /**
     * @dataProvider getWithDispatcherArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDispatcher(Consolly $consolly): void
    {
        self::assertInstanceOf(EventDispatcher::class, $consolly->getDispatcher());
    }

    public function getWithDistributorArguments(): array
    {
        return $this->dataProvider->getWithDistributorArguments();
    }

    /**
     * @dataProvider getWithDistributorArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDistributor(Consolly $consolly): void
    {
        self::assertInstanceOf(Distributor::class, $consolly->getDistributor());
    }

    public function getWithSourceArguments(): array
    {
        return $this->dataProvider->getWithSourceArguments();
    }

    /**
     * @dataProvider getWithSourceArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSource(Consolly $consolly): void
    {
        self::assertInstanceOf(ConsoleArgumentsSource::class, $consolly->getSource());
    }

    public function getWithDefaultCommandArguments(): array
    {
        return $this->dataProvider->getWithDefaultCommandArguments();
    }

    /**
     * @dataProvider getWithDefaultCommandArguments
     *
     * @param Consolly $consolly
     */
    public function testWithDefaultCommand(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getDefaultCommand());
    }

    public function getWithCommandArguments(): array
    {
        return $this->dataProvider->getWithCommandArguments();
    }

    /**
     * @dataProvider getWithCommandArguments
     *
     * @param Consolly $consolly
     */
    public function testWithCommand(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getCommands()[0]);
    }

    public function getWithCommandsArguments(): array
    {
        return $this->dataProvider->getWithCommandsArguments();
    }

    /**
     * @dataProvider getWithCommandsArguments
     *
     * @param Consolly $consolly
     */
    public function testWithCommands(Consolly $consolly): void
    {
        self::assertInstanceOf(DefaultTestCommand::class, $consolly->getCommands()[0]);
        self::assertInstanceOf(TestCommand::class, $consolly->getCommands()[1]);
    }

    public function getWithListenerArguments(): array
    {
        return $this->dataProvider->getWithListenerArguments();
    }

    /**
     * @dataProvider getWithListenerArguments
     *
     * @param Consolly $consolly
     */
    public function testWithListener(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(ConsollyEvents::EXCEPTION));
    }

    public function getWithListenersArguments(): array
    {
        return $this->dataProvider->getWithListenersArguments();
    }

    /**
     * @dataProvider getWithListenersArguments
     *
     * @param Consolly $consolly
     */
    public function testWithListeners(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(ConsollyEvents::EXCEPTION));
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::COMMANDS));
    }

    public function getWithSubscriberArguments(): array
    {
        return $this->dataProvider->getWithSubscriberArguments();
    }

    /**
     * @dataProvider getWithSubscriberArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSubscriber(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::NEXT_ARGUMENTS));
    }

    public function getWithSubscribersArguments(): array
    {
        return $this->dataProvider->getWithSubscribersArguments();
    }

    /**
     * @dataProvider getWithSubscribersArguments
     *
     * @param Consolly $consolly
     */
    public function testWithSubscribers(Consolly $consolly): void
    {
        self::assertTrue($consolly->getDispatcher()->hasListeners(DistributorEvents::NEXT_ARGUMENTS));
        self::assertTrue($consolly->getDispatcher()->hasListeners(SourceEvents::ARGUMENTS));
    }

    public function testSourceAndArgumentsNotProvidedException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->dataProvider->getSourceAndArgumentsNotProvidedExceptionArguments();
    }
}
