<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Consolly;
use Consolly\Distributor\DistributorEvents;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\NextArgumentsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\NextArgumentsEventSubscriber;
use PHPUnit\Framework\TestCase;

/**
 * Class NextArgumentsSubscriberTest represents test for {@link DistributorEvents::NEXT_ARGUMENTS} event.
 *
 * @package Consolly\Tests\Unit\Event\Distributor
 */
class NextArgumentsSubscriberTest extends TestCase
{
    /**
     * Data provider for the subscriber.
     *
     * @var NextArgumentsSubscriberDataProvider $dataProvider
     */
    protected NextArgumentsSubscriberDataProvider $dataProvider;

    /**
     * The subscriber which listens the event.
     *
     * @var NextArgumentsEventSubscriber $subscriber
     */
    protected NextArgumentsEventSubscriber $subscriber;

    /**
     * Test command which transfers next arguments to the test.
     *
     * @var TestCommand $command
     */
    protected TestCommand $command;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();

        $this->dataProvider = new NextArgumentsSubscriberDataProvider($this->command, 'value');
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->subscriber = new NextArgumentsEventSubscriber(
            $this->dataProvider->getExceptedArguments(),
            $this->dataProvider->getArgumentsToOverride()
        );

        $consolly = Consolly::default($this->dataProvider->getArguments());

        $dispatcher = $consolly->getDispatcher();

        $dispatcher->addSubscriber($this->subscriber);

        $consolly->addCommand($this->command);

        $consolly->handle();
    }

    /**
     * Tests whether the event dispatches correctly.
     */
    public function testEventExecution(): void
    {
        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    /**
     * Tests whether correct event data provides to the subscriber.
     */
    public function testArgumentsSame(): void
    {
        $isArgumentsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isArgumentsSame);
    }

    /**
     * Tests whether next arguments rewrites correctly.
     */
    public function testArgumentsRewriting(): void
    {
        $commandNextArguments = $this->command->getNextArguments();

        self::assertEquals($this->dataProvider->getArgumentsToOverride(), $commandNextArguments);
    }
}
