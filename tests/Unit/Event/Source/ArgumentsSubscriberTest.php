<?php

namespace Consolly\Tests\Unit\Event\Source;

use Consolly\Consolly;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Source\ArgumentsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Source\ArgumentsEventSubscriber;
use PHPUnit\Framework\TestCase;

class ArgumentsSubscriberTest extends TestCase
{
    protected Consolly $consolly;

    protected ArgumentsSubscriberDataProvider $dataProvider;

    protected ArgumentsEventSubscriber $subscriber;

    protected TestCommand $command;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();

        $this->dataProvider = new ArgumentsSubscriberDataProvider($this->command, 'value');
    }


    protected function setUp(): void
    {
        $this->subscriber = new ArgumentsEventSubscriber(
            $this->dataProvider->getExceptedArguments(),
            $this->dataProvider->getArgumentsToOverride()
        );

        $this->consolly = Consolly::default($this->dataProvider->getExceptedArguments());

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
        $isOverwritten = $this->command->getThird()->isIndicated();

        self::assertTrue($isOverwritten);
    }
}
