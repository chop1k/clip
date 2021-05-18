<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandFoundSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandFoundEventSubscriber;
use PHPUnit\Framework\TestCase;

class CommandFoundSubscriberTest extends TestCase
{
    protected CommandFoundEventSubscriber $subscriber;

    protected CommandFoundSubscriberDataProvider $dataProvider;

    protected CommandInterface $command;

    protected CommandInterface $overwrittenCommand;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new DefaultTestCommand();
        $this->overwrittenCommand = new TestCommand();
        $this->dataProvider = new CommandFoundSubscriberDataProvider($this->overwrittenCommand);
    }

    protected function setUp(): void
    {
        $this->subscriber = new CommandFoundEventSubscriber($this->overwrittenCommand, $this->command);

        $consolly = Consolly::default($this->dataProvider->getArguments());

        $consolly->addCommand($this->overwrittenCommand);

        $consolly->getDispatcher()->addSubscriber($this->subscriber);

        $consolly->handle();
    }

    public function testEventExecution(): void
    {
        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    public function testCommandSame(): void
    {
        $isCommandsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isCommandsSame);
    }

    public function testCommandOverride(): void
    {
        $isExecuted = $this->command->isExecuted();

        self::assertTrue($isExecuted);
    }
}
