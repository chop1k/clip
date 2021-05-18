<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandFoundEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandFoundEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected CommandInterface $expectedCommand,
        protected CommandInterface $commandToOverride
    ) {
        parent::__construct();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMAND_FOUND => 'onCommandFound'
        ];
    }

    public function onCommandFound(CommandFoundEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedCommand === $event->getCommand());

        $event->setCommand($this->commandToOverride);
    }
}
