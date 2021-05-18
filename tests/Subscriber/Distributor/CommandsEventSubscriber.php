<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandsEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandsEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
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

    public function onCommands(CommandsEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedCommands === array_values($event->getCommands()));

        $event->setCommands($this->commandsToOverride);
    }
}
