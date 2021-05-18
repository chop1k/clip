<?php

namespace Consolly\Tests\Unit\Event\Distributor;

use Consolly\Consolly;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Distributor\NextArgumentsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Distributor\NextArgumentsEventSubscriber;
use PHPUnit\Framework\TestCase;

class NextArgumentsSubscriberTest extends TestCase
{
    protected Consolly $consolly;

    protected NextArgumentsSubscriberDataProvider $dataProvider;

    protected NextArgumentsEventSubscriber $subscriber;

    protected TestCommand $command;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();

        $this->dataProvider = new NextArgumentsSubscriberDataProvider($this->command, 'value');
    }

    protected function setUp(): void
    {
        $this->subscriber = new NextArgumentsEventSubscriber(
            $this->dataProvider->getExceptedArguments(),
            $this->dataProvider->getArgumentsToOverride()
        );

        $this->consolly = Consolly::default($this->dataProvider->getArguments());

        $dispatcher = $this->consolly->getDispatcher();

        $dispatcher->addSubscriber($this->subscriber);
    }

    protected function assertPreConditions(): void
    {
        $this->consolly->addCommand($this->command);

        $this->consolly->handle();
    }

    public function testEventExecution(): void
    {
        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    public function testArgumentsSame(): void
    {
        $isArgumentsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isArgumentsSame);
    }

    public function testArgumentsOverriding(): void
    {
        $commandNextArguments = $this->command->getNextArguments();

        self::assertEquals($this->dataProvider->getArgumentsToOverride(), $commandNextArguments);
    }
}
