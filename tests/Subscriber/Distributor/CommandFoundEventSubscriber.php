<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandFoundEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandFoundEventSubscriber represents event subscriber
 * used for {@link DistributorEvents::COMMAND_FOUND} testing.
 *
 * @package Consolly\Tests\Subscriber\Distributor
 */
class CommandFoundEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * CommandFoundEventSubscriber constructor.
     *
     * @param CommandInterface $expectedCommand
     *
     * @param CommandInterface $commandToOverride
     */
    public function __construct(
        protected CommandInterface $expectedCommand,
        protected CommandInterface $commandToOverride
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DistributorEvents::COMMAND_FOUND => 'onCommandFound'
        ];
    }

    /**
     * {@link DistributorEvents::COMMAND_FOUND} event handler.
     *
     * @param CommandFoundEvent $event
     */
    public function onCommandFound(CommandFoundEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($this->expectedCommand === $event->getCommand());

        $event->setCommand($this->commandToOverride);
    }
}
