<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandsEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandsEventSubscriber represents event subscriber used for {@link DistributorEvents::COMMANDS} testing.
 *
 * @package Consolly\Tests\Subscriber\Distributor
 */
class CommandsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * CommandsEventSubscriber constructor.
     *
     * @param array $expectedCommands
     *
     * @param array $commandsToOverride
     */
    public function __construct(protected array $expectedCommands, protected array $commandsToOverride)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMANDS => 'onCommands'
        ];
    }

    /**
     * {@link DistributorEvents::COMMANDS} event handler.
     *
     * @param CommandsEvent $event
     */
    public function onCommands(CommandsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedCommands === array_values($event->getCommands()));

        $event->setCommands($this->commandsToOverride);
    }
}
