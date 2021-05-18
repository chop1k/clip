<?php

namespace Consolly\Tests\Subscriber\Consolly;

use Consolly\ConsollyEvents;
use Consolly\Event\Consolly\ExceptionEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Throwable;

class ExceptionEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected string $expectedException, protected Throwable $exceptionToOverride)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsollyEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getThrowable()::class === $this->expectedException);

        $event->setThrowable($this->exceptionToOverride);
    }
}
