<?php

namespace Consolly\Tests\Unit\Event\Source;

use Consolly\Consolly;
use Consolly\Source\SourceEvents;
use Consolly\Tests\Command\TestCommand;
use Consolly\Tests\DataProvider\Event\Source\ArgumentsSubscriberDataProvider;
use Consolly\Tests\Subscriber\Source\ArgumentsEventSubscriber;
use PHPUnit\Framework\TestCase;

/**
 * Class ArgumentsSubscriberTest represents test for {@link SourceEvents::ARGUMENTS} event.
 *
 * @package Consolly\Tests\Unit\Event\Source
 */
class ArgumentsSubscriberTest extends TestCase
{
    /**
     * Data provider for the subscriber.
     *
     * @var ArgumentsSubscriberDataProvider $dataProvider
     */
    protected ArgumentsSubscriberDataProvider $dataProvider;

    /**
     * The subscriber which listens the event.
     *
     * @var ArgumentsEventSubscriber $subscriber
     */
    protected ArgumentsEventSubscriber $subscriber;

    /**
     * Test command which options will be used for testing.
     *
     * @var TestCommand $command
     */
    protected TestCommand $command;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->command = new TestCommand();

        $this->dataProvider = new ArgumentsSubscriberDataProvider($this->command, 'value');
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->subscriber = new ArgumentsEventSubscriber(
            $this->dataProvider->getExceptedArguments(),
            $this->dataProvider->getArgumentsToOverride()
        );

        $consolly = Consolly::default($this->dataProvider->getExceptedArguments());

        $dispatcher = $consolly->getDispatcher();

        $dispatcher->addSubscriber($this->subscriber);

        $consolly->addCommand($this->command);

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
    public function testArgumentsSame(): void
    {
        $isArgumentsSame = $this->subscriber->isSuccessful();

        self::assertTrue($isArgumentsSame);
    }

    /**
     * Tests whether arguments rewrites correctly.
     */
    public function testArgumentsRewriting(): void
    {
        $isOverwritten = $this->command->getThird()->isIndicated();

        self::assertTrue($isOverwritten);
    }
}
