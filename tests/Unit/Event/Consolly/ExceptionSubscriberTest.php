<?php

namespace Consolly\Tests\Unit\Event\Consolly;

use Consolly\Consolly;
use Consolly\ConsollyEvents;
use Consolly\Exception\CommandNotFoundException;
use Consolly\Tests\DataProvider\Event\Consolly\ExceptionSubscriberDataProvider;
use Consolly\Tests\Exception\TestException;
use Consolly\Tests\Subscriber\Consolly\ExceptionEventSubscriber;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Class ExceptionSubscriberTest represents test for {@link ConsollyEvents::EXCEPTION} event.
 *
 * @package Consolly\Tests\Unit\Event\Consolly
 */
class ExceptionSubscriberTest extends TestCase
{
    /**
     * Consolly instance for dispatching events.
     *
     * @var Consolly $consolly
     */
    protected Consolly $consolly;

    /**
     * Data provider for the subscriber.
     *
     * @var ExceptionSubscriberDataProvider $dataProvider
     */
    protected ExceptionSubscriberDataProvider $dataProvider;

    /**
     * The subscriber which subscribes to the event.
     *
     * @var ExceptionEventSubscriber $subscriber
     */
    protected ExceptionEventSubscriber $subscriber;

    /**
     * Exception class to expect.
     *
     * @var string $expectedException
     */
    protected string $expectedException;

    /**
     * Exception to override.
     *
     * @var TestException $exceptionToOverride
     */
    protected Throwable $exceptionToOverride;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->expectedException = CommandNotFoundException::class;
        $this->exceptionToOverride = new TestException();

        $this->dataProvider = new ExceptionSubscriberDataProvider();
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->subscriber = new ExceptionEventSubscriber($this->expectedException, $this->exceptionToOverride);

        $this->consolly = Consolly::default($this->dataProvider->getArguments());

        $dispatcher = $this->consolly->getDispatcher();

        $dispatcher->addSubscriber($this->subscriber);
    }

    /**
     * Tests whether the event dispatches correctly.
     *
     * @throws CommandNotFoundException
     *
     * @throws Throwable
     */
    public function testEventExecution(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();

        $isExecuted = $this->subscriber->isExecuted();

        self::assertTrue($isExecuted);
    }

    /**
     * Tests whether correct event data provides to the subscriber.
     *
     * @throws CommandNotFoundException
     *
     * @throws Throwable
     */
    public function testExceptionSame(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();

        $isArgumentsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isArgumentsSame);
    }

    /**
     * Tests whether exception overrides correctly.
     *
     * @throws CommandNotFoundException
     *
     * @throws Throwable
     */
    public function testExceptionRewriting(): void
    {
        $this->expectException(TestException::class);

        $this->consolly->handle();
    }
}
