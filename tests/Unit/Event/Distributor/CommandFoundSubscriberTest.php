<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Distributor\DistributorEvents;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandFoundSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandFoundEventSubscriber;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandFoundSubscriberTest represents test for {@link DistributorEvents::COMMAND_FOUND} event.
 *
 * @package Consolly\Tests\Unit\Event\Distributor
 */
class CommandFoundSubscriberTest extends TestCase
{
    /**
     * The subscriber which listens the event.
     *
     * @var CommandFoundEventSubscriber $subscriber
     */
    protected CommandFoundEventSubscriber $subscriber;

    /**
     * Data provider for the subscriber.
     *
     * @var CommandFoundSubscriberDataProvider $dataProvider
     */
    protected CommandFoundSubscriberDataProvider $dataProvider;

    /**
     * The command which will rewrite.
     *
     * @var CommandInterface $command
     */
    protected CommandInterface $command;

    /**
     * The command which will be rewrote.
     *
     * @var TestCommand $rewrittenCommand
     */
    protected CommandInterface $rewrittenCommand;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new DefaultTestCommand();
        $this->rewrittenCommand = new TestCommand();
        $this->dataProvider = new CommandFoundSubscriberDataProvider($this->rewrittenCommand);
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->subscriber = new CommandFoundEventSubscriber($this->rewrittenCommand, $this->command);

        $consolly = Consolly::default($this->dataProvider->getArguments());

        $consolly->addCommand($this->rewrittenCommand);

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
