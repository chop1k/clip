<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandsEventSubscriber;
use PHPUnit\Framework\TestCase;

class CommandsSubscriberTest extends TestCase
{
    protected CommandsEventSubscriber $subscriber;

    protected CommandsSubscriberDataProvider $dataProvider;

    protected CommandInterface $command;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataProvider = new CommandsSubscriberDataProvider();
    }

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

    public function testEventExecution(): void
    {
        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    public function testCommandsSame(): void
    {
        $isCommandsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isCommandsSame);
    }

    public function testCommandsOverriding(): void
    {
        $isExecuted = $this->command->isExecuted();

        self::assertTrue($isExecuted);
    }
}
