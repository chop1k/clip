<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandNotFoundEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandNotFoundEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected CommandInterface $command)
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMAND_NOT_FOUND => 'onCommandNotFound'
        ];
    }

    public function onCommandNotFound(CommandNotFoundEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getCommand() === null);

        $event->setCommand($this->command);
    }
}
