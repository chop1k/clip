<?php

namespace Consolly\Tests\Subscriber\Source;

use Consolly\Event\Source\ArgumentsEvent;
use Consolly\Source\SourceEvents;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArgumentsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{

    public function __construct(protected array $expectedArguments, protected array $argumentsToOverride)
    {
        parent::__construct();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SourceEvents::ARGUMENTS => 'onArguments'
        ];
    }

    public function onArguments(ArgumentsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getArguments() === $this->expectedArguments);

        $event->setArguments($this->argumentsToOverride);
    }
}
