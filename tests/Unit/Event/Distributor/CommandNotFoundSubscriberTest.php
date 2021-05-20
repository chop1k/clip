<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Distributor\DistributorEvents;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandNotFoundSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandNotFoundEventSubscriber;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandNotFoundSubscriberTest represents test for {@link DistributorEvents::COMMAND_NOT_FOUND} event.
 *
 * @package Consolly\Tests\Unit\Event\Distributor
 */
class CommandNotFoundSubscriberTest extends TestCase
{
    /**
     * The subscriber which listens the event.
     *
     * @var CommandNotFoundEventSubscriber $subscriber
     */
    protected CommandNotFoundEventSubscriber $subscriber;

    /**
     * Data provider for the subscriber.
     *
     * @var CommandNotFoundSubscriberDataProvider $dataProvider
     */
    protected CommandNotFoundSubscriberDataProvider $dataProvider;

    /**
     * The command which will be set.
     *
     * @var CommandInterface $command
     */
    protected CommandInterface $command;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new DefaultTestCommand();
        $this->dataProvider = new CommandNotFoundSubscriberDataProvider();
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->subscriber = new CommandNotFoundEventSubscriber($this->command);

        $consolly = Consolly::default($this->dataProvider->getArguments());

        $consolly->getDispatcher()->addSubscriber($this->subscriber);

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
    public function testCommandSame(): void
    {
        $isCommandsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isCommandsSame);
    }

    /**
     * Tests whether command rewrites correctly.
     */
    public function testCommandRewriting(): void
    {
        $isExecuted = $this->command->isExecuted();

        self::assertTrue($isExecuted);
    }
}
