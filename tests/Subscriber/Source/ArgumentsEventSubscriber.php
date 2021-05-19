<?php

namespace Consolly\Tests\Subscriber\Source;

use Consolly\Event\Source\ArgumentsEvent;
use Consolly\Source\SourceEvents;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ArgumentsEventSubscriber represents event subscriber used for {@link SourceEvents::ARGUMENTS} testing.
 *
 * @package Consolly\Tests\Subscriber\Source
 */
class ArgumentsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * ArgumentsEventSubscriber constructor.
     *
     * @param array $expectedArguments
     *
     * @param array $argumentsToOverride
     */
    public function __construct(protected array $expectedArguments, protected array $argumentsToOverride)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SourceEvents::ARGUMENTS => 'onArguments'
        ];
    }

    /**
     * {@link SourceEvents::ARGUMENTS} event handler.
     *
     * @param ArgumentsEvent $event
     */
    public function onArguments(ArgumentsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getArguments() === $this->expectedArguments);

        $event->setArguments($this->argumentsToOverride);
    }
}
