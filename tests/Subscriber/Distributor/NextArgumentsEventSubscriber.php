<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\NextArgumentsEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NextArgumentsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected array $expectedNextArguments, protected array $nextArgumentsToOverride)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::NEXT_ARGUMENTS => 'onNextArguments'
        ];
    }

    public function onNextArguments(NextArgumentsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedNextArguments === $event->getArguments());

        $event->setArguments($this->nextArgumentsToOverride);
    }
}
