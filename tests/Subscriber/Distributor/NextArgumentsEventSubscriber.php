<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\NextArgumentsEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class NextArgumentsEventSubscriber represents event subscriber
 * used for {@link DistributorEvents::NEXT_ARGUMENTS} testing.
 *
 * @package Consolly\Tests\Subscriber\Distributor
 */
class NextArgumentsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * NextArgumentsEventSubscriber constructor.
     *
     * @param array $expectedNextArguments
     *
     * @param array $nextArgumentsToOverride
     */
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

    /**
     * {@link DistributorEvents::NEXT_ARGUMENTS} event handler.
     *
     * @param NextArgumentsEvent $event
     */
    public function onNextArguments(NextArgumentsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedNextArguments === $event->getArguments());

        $event->setArguments($this->nextArgumentsToOverride);
    }
}
