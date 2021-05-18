<?php

namespace Consolly\Tests\Unit\Event\Consolly;

use Consolly\Consolly;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Tests\DataProvider\Event\Consolly\ExceptionSubscriberDataProvider;
use Consolly\Tests\Exception\TestException;
use Consolly\Tests\Subscriber\Consolly\ExceptionEventSubscriber;
use PHPUnit\Framework\TestCase;
use Throwable;

class ExceptionSubscriberTest extends TestCase
{
    protected Consolly $consolly;

    protected ExceptionSubscriberDataProvider $dataProvider;

    protected ExceptionEventSubscriber $subscriber;

    protected string $expectedException;

    protected Throwable $exceptionToOverride;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->expectedException = CommandNotFoundException::class;
        $this->exceptionToOverride = new TestException();

        $this->dataProvider = new ExceptionSubscriberDataProvider();
    }


    protected function setUp(): void
    {
        $this->subscriber = new ExceptionEventSubscriber($this->expectedException, $this->exceptionToOverride);

        $this->consolly = Consolly::default($this->dataProvider->getArguments());

        $dispatcher = $this->consolly->getDispatcher();

        $dispatcher->addSubscriber($this->subscriber);
    }

    public function testEventExecution(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();

        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    public function testExceptionSame(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();

        $isArgumentsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isArgumentsSame);
    }

    public function testExceptionOverriding(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();
    }
}
