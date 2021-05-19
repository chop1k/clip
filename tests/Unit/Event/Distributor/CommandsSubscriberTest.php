<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Distributor\DistributorEvents;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandsEventSubscriber;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandsSubscriberTest represents test for {@link DistributorEvents::COMMANDS} event.
 *
 * @package Consolly\Tests\Unit\Event\Distributor
 */
class CommandsSubscriberTest extends TestCase
{
    /**
     * The subscriber which listens event.
     *
     * @var CommandsEventSubscriber $subscriber
     */
    protected CommandsEventSubscriber $subscriber;

    /**
     * Data provider for the subscriber.
     *
     * @var CommandsSubscriberDataProvider $dataProvider
     */
    protected CommandsSubscriberDataProvider $dataProvider;

    /**
     * Command to rewrite.
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

        $this->dataProvider = new CommandsSubscriberDataProvider();
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->command = new DefaultTestCommand();

        $testCommand = new TestCommand();

        $this->subscriber = new CommandsEventSubscriber([$testCommand], [$this->command]);

        $consolly = Consolly::default($this->dataProvider->getArguments());

        $consolly->addCommand($testCommand);

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
    public function testCommandsSame(): void
    {
        $isCommandsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isCommandsSame);
    }

    /**
     * Tests whether command rewrites correctly.
     */
    public function testCommandsRewriting(): void
    {
        $isExecuted = $this->command->isExecuted();

        self::assertTrue($isExecuted);
    }
}
