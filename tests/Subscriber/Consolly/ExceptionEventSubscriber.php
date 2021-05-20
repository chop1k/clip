<?php

namespace Consolly\Tests\Subscriber\Consolly;

use Consolly\ConsollyEvents;
use Consolly\Event\Consolly\ExceptionEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Throwable;

/**
 * Class ExceptionEventSubscriber represents event subscriber used for {@link ConsollyEvents::EXCEPTION} testing.
 *
 * @package Consolly\Tests\Subscriber\Consolly
 */
class ExceptionEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * ExceptionEventSubscriber constructor.
     *
     * @param string $expectedException
     *
     * @param Throwable $exceptionToOverride
     */
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

    /**
     * {@link ConsollyEvents::EXCEPTION} event handler.
     *
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getThrowable()::class === $this->expectedException);

        $event->setThrowable($this->exceptionToOverride);
    }
}
