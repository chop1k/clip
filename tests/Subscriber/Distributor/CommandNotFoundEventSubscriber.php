<?php

namespace Consolly\Tests\Subscriber\Distributor;

use Consolly\Command\CommandInterface;
use Consolly\Distributor\DistributorEvents;
use Consolly\Event\Distributor\CommandNotFoundEvent;
use Consolly\Tests\Subscriber\TestEventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandNotFoundEventSubscriber represents event subscriber
 * used for {@link DistributorEvents::COMMAND_NOT_FOUND} testing.
 *
 * @package Consolly\Tests\Subscriber\Distributor
 */
class CommandNotFoundEventSubscriber extends TestEventSubscriber implements EventSubscriberInterface
{
    /**
     * CommandNotFoundEventSubscriber constructor.
     *
     * @param CommandInterface $command
     */
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

    /**
     * {@link DistributorEvents::COMMAND_NOT_FOUND} event handler.
     *
     * @param CommandNotFoundEvent $event
     */
    public function onCommandNotFound(CommandNotFoundEvent $event): void
    {
        $this->setExecuted(true);

        $this->setSuccessful($event->getCommand() === null);

        $event->setCommand($this->command);
    }
}
