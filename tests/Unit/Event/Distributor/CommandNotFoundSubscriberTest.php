<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Consolly;
use Consolly\Tests\Command\DefaultTestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\CommandNotFoundSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\CommandNotFoundEventSubscriber;
use PHPUnit\Framework\TestCase;

class CommandNotFoundSubscriberTest extends TestCase
{
    protected CommandNotFoundEventSubscriber $subscriber;

    protected CommandNotFoundSubscriberDataProvider $dataProvider;

    protected CommandInterface $command;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new DefaultTestCommand();
        $this->dataProvider = new CommandNotFoundSubscriberDataProvider();
    }

    protected function setUp(): void
    {
        $this->subscriber = new CommandNotFoundEventSubscriber($this->command);

        $consolly = Consolly::default($this->dataProvider->getArguments());

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
